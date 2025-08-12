<?php
$page = 'system_meta';
include 'admin_auth.php';
include 'admin_nav.php';

function run($cmd) {
    return rtrim(shell_exec($cmd));
}

// ------- SEO/Meta coverage: live render scan with dynamic file list -------
// SEO Check - DISABLED BY DEFAULT (add ?seo=1 to URL to enable)
$run_seo_check = isset($_GET['seo']) && $_GET['seo'] == '1';
$public_pages = [];

if ($run_seo_check) {
    $base = 'https://www.ktp.digital/';
    // Build list of public *.php files, excluding system, admin, script, and template files.
    foreach (glob(__DIR__ . '/../*.php') as $f) {
        $name = basename($f);
        if (
            in_array($name, ['layout.php', 'nav.php', 'Parsedown.php', 'robots.txt', 'sitemap.xml', 'VERSION']) ||
            preg_match('/^admin|^older|^test|^index\-test|^newindex|^new_index|^_|\.bak$/i', $name)
        ) continue;
        $public_pages[] = $name;
    }
    sort($public_pages, SORT_STRING | SORT_FLAG_CASE);
} else {
    $base = 'https://www.ktp.digital/';
}

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
function meta_desc_word_count($url) {
    $html = @file_get_contents($url);
    if ($html === false) return '';
    if (preg_match('/<meta\s+name="description"\s+content="([^"]*)"/i', $html, $m)) {
        return str_word_count($m[1]);
    }
    return '';
}
$meta_results = [];
if ($run_seo_check) {
    foreach ($public_pages as $file) {
        $url = $base . $file;
        $meta_results[$file] = checkMetaTags($url);
    }
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

// ----- System Health -----
$system = [
    'Uptime'     => run('uptime -p'),
    'Disk Usage' => run('df -h / | tail -1'),
    'Memory'     => run('free -m | grep Mem'),
    'Top CPU'    => run('ps -eo pid,comm,%cpu --sort=-%cpu | head -n 6'),
    'Top RAM'    => run('ps -eo pid,comm,%mem --sort=-%mem | head -n 6'),
    'Nginx'      => run('systemctl is-active nginx'),
];

// ----- Memory (Human-Readable MB/GB) -----
$mem_raw = $system['Memory'];
$mem_labels = ['Total RAM', 'Used', 'Free', 'Shared', 'Buffers/Cache', 'Available'];
$mem_values = [];
if (preg_match('/Mem:\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $mem_raw, $matches)) {
    $raw_vals = array_slice($matches, 1, 6);
    foreach ($raw_vals as $i => $val) {
        if ($val >= 1024) {
            $g = round($val / 1024, 2);
            $mem_values[$mem_labels[$i]] = $g . ' GB';
        } else {
            $mem_values[$mem_labels[$i]] = $val . ' MB';
        }
    }
}

// ----- SSL: Get certificate info from cache file -----
$ssl_msg = '';
$domain_str = '';
$cache_file = '/tmp/ssl_cert_info.txt';
if (!file_exists($cache_file) || (time() - filemtime($cache_file) > 3600)) {
    // Cache is missing or older than 1 hour, try to refresh it
    run("/opt/webstack/bin/cache_ssl_info.sh 2>/dev/null");
}
$certbot_output = file_exists($cache_file) ? file_get_contents($cache_file) : '';
if ($certbot_output && strpos($certbot_output, 'ww2.ktp.digital') !== false) {
    // Parse domains
    if (preg_match('/Domains: (.+)/', $certbot_output, $domain_match)) {
        $domain_str = htmlspecialchars(trim($domain_match[1]));
    }
    // Parse expiry
    if (preg_match('/Expiry Date: ([0-9]{4}-[0-9]{2}-[0-9]{2}) [0-9]{2}:[0-9]{2}:[0-9]{2}\+[0-9]{2}:[0-9]{2} \(VALID: ([0-9]+) days?\)/', $certbot_output, $exp_match)) {
        $exp_date = $exp_match[1];
        $days = intval($exp_match[2]);
        $exp_str = $exp_date . " (" . ($days >= 0
                ? "<span class='text-green-700'>in $days day" . ($days == 1 ? '' : 's') . "</span>"
                : "<span class='text-red-700'>expired " . abs($days) . " day" . (abs($days) == 1 ? '' : 's') . " ago</span>"
            ) . ")";
        $ssl_msg = "<span class='text-green-700 font-bold'>Valid</span> – $domain_str – Expires: $exp_str";
    } else {
        $ssl_msg = "<span class='text-yellow-600 font-bold'>Certificate found but could not parse expiry</span>";
    }
} else {
    $ssl_msg = "<span class='text-red-700  font-bold'>No SSL certificate found for ww2.ktp.digital</span>";
}

// ----- UFW Firewall: Show all open ports (IPv4 + IPv6) -----
$ufw = run("sudo /usr/sbin/ufw status 2>/dev/null");
if ($ufw && stripos($ufw, 'Status: active') !== false) {
    $firewall_msg = "<span class='text-green-700  font-bold'>ACTIVE</span>";
    $allowed_ports = [];
    foreach (explode("\n", $ufw) as $line) {
        if (preg_match('/^([0-9]+\/[a-zA-Z0-9\(\) ]+)\s+ALLOW/', $line, $port_m)) {
            $allowed_ports[] = trim($port_m[1]);
        }
    }
    if ($allowed_ports) {
        $firewall_msg .= " – Open: <b>" . htmlspecialchars(implode(', ', $allowed_ports)) . "</b>";
    }
} elseif ($ufw && stripos($ufw, 'inactive') !== false) {
    $firewall_msg = "<span class='text-red-700  font-bold'>INACTIVE</span>";
} else {
    $firewall_msg = "Status unknown.<br><span class='text-xs text-gray-500'>Try <code>ufw status</code> on the server.</span>";
}

// -- Utility for row state in SEO table
function seo_row_state($r) {
    if ($r['error']) return 'error';
    if (!$r['title'] || !$r['meta']) return 'bad';
    if ($r['wordcount'] < 200) return 'warn';
    return 'ok';
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
    .tooltip-q { font-weight: bold; font-size: 13px; color: #3B82F6; margin-left: 2px; cursor: pointer;}
    .warn-row { background: #FEF9C3 !important; }
    .error-row { background: #FEE2E2 !important; }
  </style>
</head>
<body class="bg-white  text-gray-900 ">
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
      <div class="bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">🕒 Uptime</h3>
        <p><?= htmlspecialchars($system['Uptime']) ?></p>
      </div>
      <div class="bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">💾 Disk Usage</h3>
        <p><?= htmlspecialchars($system['Disk Usage']) ?></p>
      </div>
      <div class="bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">🧠 Memory</h3>
        <?php if ($mem_values): ?>
        <ul class="text-xs">
          <?php foreach ($mem_values as $label => $val): ?>
            <li>
              <span class="font-semibold"><?= htmlspecialchars($label) ?></span>:
              <?= htmlspecialchars($val) ?>
              <span class="tooltip-q tooltip" title="<?php
                switch ($label) {
                  case 'Total RAM': echo "Total system RAM installed."; break;
                  case 'Used': echo "RAM currently used by apps & kernel."; break;
                  case 'Free': echo "RAM currently not used at all."; break;
                  case 'Shared': echo "RAM shared between processes (tmpfs, etc)."; break;
                  case 'Buffers/Cache': echo "RAM used for disk buffering/caching (auto-managed by Linux)."; break;
                  case 'Available': echo "Estimated RAM available for new apps (inc. cache that can be reclaimed)."; break;
                  default: echo ""; break;
                }
              ?>">?</span>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <p><?= htmlspecialchars($system['Memory']) ?></p>
        <?php endif; ?>
      </div>
      <div class="bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">🌐 Nginx Status</h3>
        <p><?= htmlspecialchars($system['Nginx']) ?></p>
      </div>
      <div class="md:col-span-2 bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">🔥 Top CPU Processes</h3>
        <pre class="overflow-x-auto"><?= htmlspecialchars($system['Top CPU']) ?></pre>
      </div>
      <div class="md:col-span-2 bg-gray-100  p-4 rounded shadow">
        <h3 class="font-bold mb-2">📈 Top RAM Processes</h3>
        <pre class="overflow-x-auto"><?= htmlspecialchars($system['Top RAM']) ?></pre>
      </div>
    </div>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">TLS &amp; Security</h2>
    <ul class="list-disc pl-6">
      <li>
        <strong>SSL/TLS:</strong> <?= $ssl_msg ?>
      </li>
      <li>
        <strong>Firewall:</strong> <?= $firewall_msg ?>
      </li>
    </ul>
  </section>

  <section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Meta Tag &amp; SEO Coverage (Live Rendered)</h2>
    <?php if (!$run_seo_check): ?>
      <div class="bg-gray-100 border border-gray-300 rounded p-4">
        <p class="text-gray-700">SEO analysis is disabled for faster page loads.</p>
        <p class="mt-2"><a href="?seo=1" class="text-blue-600 hover:underline">Click here to run SEO analysis</a> (may take 1-2 minutes)</p>
      </div>
    <?php else: ?>
    <div class="overflow-x-auto rounded border border-gray-300 ">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-200  text-left">
          <tr>
            <th class="py-1 px-2">File</th>
            <th class="py-1 px-2 text-center">Title</th>
            <th class="py-1 px-2 text-center">Meta Description</th>
            <th class="py-1 px-2 text-center">Meta Desc Words</th>
            <th class="py-1 px-2 text-center">Word Count</th>
            <th class="py-1 px-2 text-center">HTML Size (KB)</th>
            <th class="py-1 px-2">Notes</th>
          </tr>
        </thead>
        <tbody class="bg-white ">
          <?php foreach ($meta_results as $file => $r):
              $row_state = seo_row_state($r);
              $row_class = $row_state === 'warn' ? 'warn-row' : ($row_state === 'error' ? 'error-row' : (($row_state === 'bad') ? 'error-row' : ''));
              $meta_words = $r['meta'] ? meta_desc_word_count($base . $file) : '–';
              ?>
          <tr class="border-t  <?= $row_class ?>">
            <td class="py-1 px-2 font-mono">
              <a href="<?= htmlspecialchars($base . $file) ?>" target="_blank" class="underline text-blue-700  hover:text-blue-900"><?= htmlspecialchars($file) ?></a>
            </td>
            <td class="py-1 px-2 text-center">
              <?= $r['title'] ? '✅' : '<span class="text-red-600  font-bold">❌</span>' ?>
            </td>
            <td class="py-1 px-2 text-center">
              <?= $r['meta'] ? '✅' : '<span class="text-red-600  font-bold">❌</span>' ?>
            </td>
            <td class="py-1 px-2 text-center"><?= $meta_words ?></td>
            <td class="py-1 px-2 text-center"><?= intval($r['wordcount']) ?></td>
            <td class="py-1 px-2 text-center"><?= htmlspecialchars($r['size_kb']) ?></td>
            <td class="py-1 px-2 text-xs text-gray-500 ">
              <?php
                if ($r['error']) {
                  echo htmlspecialchars($r['error']);
                } elseif (!$r['title'] || !$r['meta']) {
                  echo "Missing tags";
                } elseif ($r['wordcount'] < 200) {
                  echo "Too short (" . intval($r['wordcount']) . " words)";
                } else {
                  echo "OK";
                }
              ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-6 text-sm text-gray-500 ">
      <p>
        <b>Green = SEO-compliant, live rendered.</b> <br>
        <b>Yellow = Too short (&lt; 200 words) but otherwise tagged.</b><br>
        <b>Red = Missing or fetch failed (see Notes).</b>
      </p>
    </div>
    <?php endif; ?>
  </section>
</div>
</body>
</html>
