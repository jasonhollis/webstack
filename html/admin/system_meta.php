<?php
$page = 'system_meta';
include 'admin_auth.php';
include 'admin_nav.php';

function run($cmd) {
  return rtrim(shell_exec($cmd));
}

// ------- SEO/Meta coverage: live render scan instead of static -------
$public_pages = [
    'index.php',
    'about.php',
    'automation.php',
    'contact.php',
    'enterprise.php',
    'mac.php',
    'macos-tools.php',
    'nas.php',
    'nextdns.php',
    'smallbiz.php',
    'tailscale.php',
    'methodology.php',
    // add/remove public pages as needed
];
$base = 'https://www.ktp.digital/';

function checkMetaTags($url) {
    $html = @file_get_contents($url);
    if ($html === false) {
        return ['title' => false, 'meta' => false, 'error' => 'Fetch failed'];
    }
    if (preg_match('/<head.*?>(.*?)<\/head>/si', $html, $headMatch)) {
        $head = $headMatch[1];
        $hasTitle = stripos($head, '<title>') !== false;
        $hasMeta = stripos($head, '<meta name="description"') !== false;
        return [
            'title' => $hasTitle,
            'meta'  => $hasMeta,
            'error' => false,
        ];
    }
    return ['title' => false, 'meta' => false, 'error' => 'No head section'];
}
$meta_results = [];
foreach ($public_pages as $file) {
    $url = $base . $file;
    $meta_results[$file] = checkMetaTags($url);
}
// ---------------------------------------------------------------------

$version = @trim(file_get_contents('../VERSION'));
$latest_snap = run('ls -1t /opt/webstack/snapshots/*.zip 2>/dev/null | head -n1');
$dirs = [
  '/opt/webstack/html',
  '/opt/webstack/bin',
  '/opt/webstack/logs',
  '/opt/webstack/objectives',
];

$system = [
  'Uptime' => run('uptime -p'),
  'Disk Usage' => run('df -h / | tail -1'),
  'Memory' => run('free -h | grep Mem'),
  'Top CPU' => run('ps -eo pid,comm,%cpu --sort=-%cpu | head -n 6'),
  'Top RAM' => run('ps -eo pid,comm,%mem --sort=-%mem | head -n 6'),
  'Nginx' => run('systemctl is-active nginx'),
];

$cert_path = '/etc/letsencrypt/live/www.ktp.digital/fullchain.pem';
$cert_expiry = file_exists($cert_path)
  ? run("openssl x509 -enddate -noout -in $cert_path 2>/dev/null | cut -d= -f2")
  : 'No SSL certificate found.';

$ssh_fingerprints = run("find ~/.ssh -name '*.pub' -exec ssh-keygen -lf {} \\; 2>/dev/null");
$firewall_status = run("ufw status 2>/dev/null || iptables -L 2>/dev/null");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>System Meta – KTP Webstack</title>
  <meta name="description" content="Live deployment and system metadata viewer.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">🩺 System Meta Overview</h1>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Webstack Info</h2>
    <ul class="list-disc pl-6">
      <li><strong>Version:</strong> <?= $version ?></li>
      <li><strong>Latest Snapshot:</strong> <?= htmlspecialchars($latest_snap) ?></li>
      <?php foreach ($dirs as $d): ?>
        <li><strong><?= basename($d) ?> Last Modified:</strong> <?= date('Y-m-d H:i:s', filemtime($d)) ?></li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">System Health</h2>
    <div class="grid md:grid-cols-2 gap-4 text-sm">
      <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">🕒 Uptime</h3>
        <p><?= htmlspecialchars($system['Uptime']) ?></p>
      </div>
      <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">💾 Disk Usage</h3>
        <p><?= htmlspecialchars($system['Disk Usage']) ?></p>
      </div>
      <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">🧠 Memory</h3>
        <p><?= htmlspecialchars($system['Memory']) ?></p>
      </div>
      <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">🌐 Nginx Status</h3>
        <p><?= htmlspecialchars($system['Nginx']) ?></p>
      </div>
      <div class="md:col-span-2 bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">🔥 Top CPU Processes</h3>
        <pre class="overflow-x-auto"><?= htmlspecialchars($system['Top CPU']) ?></pre>
      </div>
      <div class="md:col-span-2 bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
        <h3 class="font-bold mb-2">📈 Top RAM Processes</h3>
        <pre class="overflow-x-auto"><?= htmlspecialchars($system['Top RAM']) ?></pre>
      </div>
    </div>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">TLS & Security</h2>
    <ul class="list-disc pl-6">
      <li><strong>SSL Expiry:</strong> <?= $cert_expiry ?></li>
      <li><strong>SSH Fingerprints:</strong><br><pre class="inline-block bg-gray-100 dark:bg-gray-800 p-2 rounded"><?= htmlspecialchars($ssh_fingerprints) ?></pre></li>
      <li><strong>Firewall Status:</strong><br><pre class="inline-block bg-gray-100 dark:bg-gray-800 p-2 rounded"><?= htmlspecialchars($firewall_status) ?></pre></li>
    </ul>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Meta Tag & SEO Coverage (Live Rendered)</h2>
    <div class="overflow-x-auto rounded border border-gray-300 dark:border-gray-700">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-200 dark:bg-gray-700 text-left">
          <tr>
            <th class="py-1 px-2">File</th>
            <th class="py-1 px-2 text-center">Title</th>
            <th class="py-1 px-2 text-center">Meta Description</th>
            <th class="py-1 px-2">Notes</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900">
          <?php foreach ($meta_results as $file => $r): ?>
          <tr class="border-t dark:border-gray-800 <?= (!$r['title'] || !$r['meta']) ? 'bg-red-50 dark:bg-red-900/30' : 'bg-green-50 dark:bg-green-900/10' ?>">
            <td class="py-1 px-2 font-mono">
              <a href="<?= htmlspecialchars($base . $file) ?>" target="_blank" class="underline text-blue-700 dark:text-blue-300 hover:text-blue-900"><?= htmlspecialchars($file) ?></a>
            </td>
            <td class="py-1 px-2 text-center">
              <?= $r['title'] ? '✅' : '<span class="text-red-600 dark:text-red-400 font-bold">❌</span>' ?>
            </td>
            <td class="py-1 px-2 text-center">
              <?= $r['meta'] ? '✅' : '<span class="text-red-600 dark:text-red-400 font-bold">❌</span>' ?>
            </td>
            <td class="py-1 px-2 text-xs text-gray-500 dark:text-gray-400">
              <?= $r['error'] ? htmlspecialchars($r['error']) : ($r['title'] && $r['meta'] ? 'OK' : 'Missing tags') ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
      <p>
        <b>Green = SEO-compliant, live rendered.</b> <br>
        <b>Red = Missing or fetch failed (see Notes).</b>
      </p>
    </div>
  </section>
</div>
</body>
</html>
