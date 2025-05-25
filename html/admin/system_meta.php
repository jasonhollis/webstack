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
        return [
            'title' => false,
            'meta' => false,
            'error' => 'Fetch failed',
            'wordcount' => 0,
            'size_kb' => 0
        ];
    }
    if (preg_match('/<head.*?>(.*?)<\/head>/si', $html, $headMatch)) {
        $head = $headMatch[1];
        $hasTitle = stripos($head, '<title>') !== false;
        $hasMeta = stripos($head, '<meta name="description"') !== false;
    } else {
        $hasTitle = false;
        $hasMeta = false;
    }
    // Count words in rendered HTML body (excluding tags)
    $text = strip_tags($html);
    $wordcount = str_word_count($text);
    $size_kb = round(strlen($html) / 1024, 1);
    return [
        'title' => $hasTitle,
        'meta'  => $hasMeta,
        'error' => false,
        'wordcount' => $wordcount,
        'size_kb' => $size_kb
    ];
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

// ----- System Health: Reliable Flat Array for Display -----
$system = [
    'Uptime'     => run('uptime -p'),
    'Disk Usage' => run('df -h / | tail -1'),
    'Memory'     => run('free -h | grep Mem'),
    'Top CPU'    => run('ps -eo pid,comm,%cpu --sort=-%cpu | head -n 6'),
    'Top RAM'    => run('ps -eo pid,comm,%mem --sort=-%mem | head -n 6'),
    'Nginx'      => run('systemctl is-active nginx'),
];

// ----- Memory Stats (Labeled & Tooltipped) -----
$mem_raw = $system['Memory'];
$mem_labels = ['total' => 'Total RAM', 'used' => 'Used', 'free' => 'Free', 'shared' => 'Shared', 'buff/cache' => 'Buffers/Cache', 'available' => 'Available'];
$mem_values = [];
if (preg_match('/Mem:\s+([\d\w\.]+)\s+([\d\w\.]+)\s+([\d\w\.]+)\s+([\d\w\.]+)\s+([\d\w\.]+)\s+([\d\w\.]+)/', $mem_raw, $matches)) {
    $mem_values = [
        'Total RAM' => $matches[1],
        'Used' => $matches[2],
        'Free' => $matches[3],
        'Shared' => $matches[4],
        'Buffers/Cache' => $matches[5],
        'Available' => $matches[6],
    ];
}

// ----- SSL Certbot: Status, Domains, Expiry -----
$cert_path = '/etc/letsencrypt/live/ww2.ktp.digital/fullchain.pem';
$ssl_msg = '';
$ssl_domains = [];
if (file_exists($cert_path)) {
    $raw_exp = run("openssl x509 -enddate -noout -in $cert_path 2>/dev/null");
    $raw_dns = run("openssl x509 -text -noout -in $cert_path 2>/dev/null | grep DNS:");
    if (preg_match('/notAfter=(.+)/', $raw_exp, $m)) {
        $expiry = strtotime($m[1]);
        $now = time();
        $days = floor(($expiry - $now) / 86400);
        $dns = [];
        if (preg_match('/DNS:([^\n]+)/', $raw_dns, $dns_m)) {
            $dns = array_map('trim', explode(',', str_replace('DNS:', '', $dns_m[0])));
        }
        $ssl_domains = $dns;
        if ($days >= 0) {
            $ssl_msg = "<span class='text-green-700 dark:text-green-300 font-bold'>SSL valid</span> &ndash; Expires <b>" .
                date('Y-m-d', $expiry) . "</b> <span class='text-gray-500'>(in $days day" . ($days == 1 ? '' : 's') . ")</span>";
        } else {
            $ssl_msg = "<span class='text-red-700 dark:text-red-400 font-bold'>SSL expired</span> &ndash; Expired <b>" .
                date('Y-m-d', $expiry) . "</b> <span class='text-red-500'>(expired " . abs($days) . " day" . (abs($days) == 1 ? '' : 's') . " ago)</span><br>" .
                "<span class='text-xs text-red-400'>Renew with <code>certbot renew</code> and reload your webserver.</span>";
        }
    } else {
        $ssl_msg = "<span class='text-red-700 dark:text-red-400 font-bold'>SSL certificate: parsing error</span>";
    }
} else {
    $ssl_msg = "<span class='text-red-700 dark:text-red-400 font-bold'>No SSL certificate found for ww2.ktp.digital</span><br>
    <span class='text-xs text-red-400'>To enable HTTPS, run <code>certbot --nginx -d www.ktp.digital -d ww2.ktp.digital</code></span>";
}

// ----- UFW Firewall Status -----
$ufw = run("ufw status 2>/dev/null");
if ($ufw && stripos($ufw, 'Status: active') !== false) {
    $firewall_msg = "<span class='text-green-700 dark:text-green-300 font-bold'>Firewall is ACTIVE</span>";
    // Parse allowed ports
    $allowed_ports = [];
    foreach (explode("\n", $ufw) as $line) {
        if (preg_match('/^(\d+\/\w+)\s+ALLOW/', $line, $port_m)) {
            $allowed_ports[] = $port_m[1];
        }
    }
    if ($allowed_ports) {
        $firewall_msg .= ". Open: <b>" . implode(', ', $allowed_ports) . "</b>";
    }
} elseif ($ufw && stripos($ufw, 'inactive') !== false) {
    $firewall_msg = "<span class='text-red-700 dark:text-red-400 font-bold'>Firewall is INACTIVE</span>";
} else {
    $firewall_msg = "Firewall status could not be determined.<br><span class='text-xs text-gray-500'>Try <code>ufw status</code> on the server.</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>System Meta – KTP Webstack</title>
  <meta name="description" content="Live deployment and system metadata viewer.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .tooltip { position: relative; cursor: pointer; }
    .tooltip .tooltip-text {
      visibility: hidden; opacity:0; transition: opacity 0.2s;
      background: #222; color: #fff; padding: 4px 8px; border-radius: 4px; position: absolute; z-index: 100;
      left: 50%; top: 100%; transform: translateX(-50%);
      font-size: 11px; white-space: pre-line; min-width: 110px;
    }
    .tooltip:hover .tooltip-text { visibility: visible; opacity: 1; }
  </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">🩺 System Meta Overview</h1>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Webstack Info</h2>
    <ul class="list-disc pl-6">
      <li><strong>Version:</strong> <?= htmlspecialchars($version) ?></li>
      <li><strong>Latest Snapshot:</strong> <?= htmlspecialchars($latest_snap) ?></li>
      <?php foreach ($dirs as $d): ?>
        <li><strong><?= htmlspecialchars(basename($d)) ?> Last Modified:</strong> <?= date('Y-m-d H:i:s', filemtime($d)) ?></li>
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
        <?php if ($mem_values): ?>
        <ul class="text-xs">
          <?php foreach ($mem_values as $label => $val): ?>
            <li>
              <span class="font-semibold"><?= htmlspecialchars($label) ?></span>:
              <?= htmlspecialchars($val) ?>
              <span class="tooltip">❔
                <span class="tooltip-text">
                  <?php
                    switch ($label) {
                      case 'Total RAM': echo "Total system RAM installed."; break;
                      case 'Used': echo "RAM currently used by apps & kernel."; break;
                      case 'Free': echo "RAM currently not used at all."; break;
                      case 'Shared': echo "RAM shared between processes (tmpfs, etc)."; break;
                      case 'Buffers/Cache': echo "RAM used for disk buffering/caching (auto-managed by Linux)."; break;
                      case 'Available': echo "Estimated RAM available for new apps (inc. cache that can be reclaimed)."; break;
                      default: echo ""; break;
                    }
                  ?>
                </span>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <p><?= htmlspecialchars($system['Memory']) ?></p>
        <?php endif; ?>
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
    <h2 class="text-xl font-semibold mb-2">TLS &amp; Security</h2>
    <ul class="list-disc pl-6">
      <li>
        <strong>SSL/TLS Status:</strong> <?= $ssl_msg ?>
        <?php if ($ssl_domains): ?>
          <br><span class="text-xs text-gray-500">Domains: <?= htmlspecialchars(implode(', ', $ssl_domains)) ?></span>
        <?php endif; ?>
      </li>
      <li>
        <strong>Firewall Status:</strong> <?= $firewall_msg ?>
      </li>
    </ul>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Meta Tag &amp; SEO Coverage (Live Rendered)</h2>
    <div class="overflow-x-auto rounded border border-gray-300 dark:border-gray-700">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-200 dark:bg-gray-700 text-left">
          <tr>
            <th class="py-1 px-2">File</th>
            <th class="py-1 px-2 text-center">Title</th>
            <th class="py-1 px-2 text-center">Meta Description</th>
            <th class="py-1 px-2 text-center">Word Count</th>
            <th class="py-1 px-2 text-center">HTML Size (KB)</th>
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
            <td class="py-1 px-2 text-center"><?= intval($r['wordcount']) ?></td>
            <td class="py-1 px-2 text-center"><?= htmlspecialchars($r['size_kb']) ?></td>
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
