<?php
$page = 'system_meta';
include 'admin_auth.php';
include 'admin_nav.php';

function run($cmd) {
  return rtrim(shell_exec($cmd));
}

function getMetaReport($dir) {
  $output = "";
  $files = glob("$dir/*.php");
  usort($files, fn($a, $b) => strcmp(basename($a), basename($b)));

  foreach ($files as $f) {
    $basename = basename($f);
    $contents = file_get_contents($f);

    // Accurate word count even for mostly-PHP files
    $words = preg_match_all('/\b\w+\b/u', $contents, $matches);
    $size = round(filesize($f) / 1024, 1);
    $lastmod = date("Y-m-d H:i:s", filemtime($f));

    $has_desc = stripos($contents, '<meta name="description"') !== false;
    $has_title = stripos($contents, '<title>') !== false;
    $has_robots = stripos($contents, '<meta name="robots"') !== false;

    $output .= "<tr class='border-t'>
      <td class='py-1 px-2 font-mono'>$basename</td>
      <td class='py-1 px-2 text-right'>$words</td>
      <td class='py-1 px-2 text-right'>$size KB</td>
      <td class='py-1 px-2 text-right'>$lastmod</td>
      <td class='py-1 px-2 text-center'>" . ($has_desc ? '✅' : '❌ No Meta') . "</td>
      <td class='py-1 px-2 text-center'>" . ($has_title ? '✅' : '❌ No Title') . "</td>
      <td class='py-1 px-2 text-center'>" . ($has_robots ? '⚠️ Robots' : 'OK') . "</td>
    </tr>";
  }

  return $output;
}


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
    <h2 class="text-xl font-semibold mb-2">Meta Tag & SEO Coverage</h2>
    <div class="overflow-x-auto rounded border border-gray-300 dark:border-gray-700">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-200 dark:bg-gray-700 text-left">
          <tr>
            <th class="py-1 px-2">File</th>
            <th class="py-1 px-2 text-right">Words</th>
            <th class="py-1 px-2 text-right">Size</th>
            <th class="py-1 px-2 text-right">Last Modified</th>
            <th class="py-1 px-2 text-center">Meta</th>
            <th class="py-1 px-2 text-center">Title</th>
            <th class="py-1 px-2 text-center">Robots</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900">
          <?= getMetaReport('..') ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
</body>
</html>
