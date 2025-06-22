<?php
include __DIR__.'/admin_auth.php';

// highlight the Analytics menu item
$page = 'analytics';
include __DIR__.'/admin_nav.php';

// get real client IP (supports proxy)
function getClientIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($list[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '';
}

// handle persistent Exclude My IP toggle
if (isset($_GET['no_me'])) {
    setcookie('exclude_my_ip', getClientIP(), time()+86400*30, '/');
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
if (isset($_GET['show_all'])) {
    setcookie('exclude_my_ip','', time()-3600, '/');
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

$exclude_ip = $_COOKIE['exclude_my_ip'] ?? null;

// path to your JSON lines log
$log_file = '/opt/webstack/logs/web_analytics.log';
$lines    = @file($log_file) ?: [];
// only look at the last 200 entries
$recent   = array_slice($lines, -200);

// aggregate structures
$total_hits       = 0;
$traffic_by_date  = [];
$page_hits        = [];
$referrers        = [];
$user_agents      = [];
$response_times   = [];
$admin_hits       = [];
$public_hits      = [];
$ip_counts        = [];

// parse each JSON line
foreach ($recent as $line) {
    $entry = json_decode($line, true);
    if (!$entry) continue;
    $ip = $entry['ip'] ?? '';
    if ($exclude_ip && $ip === $exclude_ip) {
        continue;
    }
    $total_hits++;
    $date = substr($entry['ts'],0,10);
    $traffic_by_date[$date] = ($traffic_by_date[$date] ?? 0) + 1;
    $page_hits[$entry['page']]      = ($page_hits[$entry['page']] ?? 0) + 1;
    $referrers[$entry['referer']]   = ($referrers[$entry['referer']] ?? 0) + 1;
    $user_agents[$entry['ua']]      = ($user_agents[$entry['ua']] ?? 0) + 1;
    $response_times[]               = floatval($entry['load_time'] ?? 0);
    $ip_counts[$ip]                 = ($ip_counts[$ip] ?? 0) + 1;
    if (($entry['context'] ?? '') === 'ADMIN') {
        $admin_hits[] = $entry;
    } else {
        $public_hits[] = $entry;
    }
}

// helper to grab top N
function top_n($arr, $n=5) {
    arsort($arr);
    return array_slice($arr, 0, $n, true);
}

// compute average
$avg_time = $response_times
    ? array_sum($response_times)/count($response_times)
    : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Analytics Dashboard – KTP Digital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/assets/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
  <div class="max-w-6xl mx-auto p-6">

    <!-- Debug panel (remove after confirming) -->
    <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400">
      <p><strong>Detected IP:</strong> <?=htmlspecialchars(getClientIP())?></p>
      <p><strong>Excluded IP:</strong> <?=htmlspecialchars($exclude_ip ?: '(none)')?></p>
      <p><strong>Sample IPs:</strong> <?=htmlspecialchars(implode(', ', array_slice(array_keys($ip_counts),0,5)))?></p>
    </div>

    <div class="flex flex-wrap items-center justify-between mb-4">
      <h1 class="text-3xl font-bold flex items-center gap-2">📊 Analytics Dashboard</h1>
      <?php if (!$exclude_ip): ?>
        <a href="?no_me=1"
           class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
          Exclude My IP
        </a>
      <?php else: ?>
        <a href="?show_all=1"
           class="text-sm bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
          Show All
        </a>
      <?php endif; ?>
    </div>

    <p class="text-sm text-gray-600 mb-6">
      Showing data for last <?= $total_hits ?> hit<?= $total_hits===1?'':'s' ?>
      <?= $exclude_ip? "(excluding your IP)" : "" ?>
    </p>

    <!-- summary cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <div class="font-semibold">Total Hits</div>
        <div class="text-2xl"><?= $total_hits ?></div>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <div class="font-semibold">Avg Load Time</div>
        <div class="text-2xl"><?= number_format($avg_time,3) ?>s</div>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <div class="font-semibold">Top Page</div>
        <div class="text-xl"><?= htmlspecialchars(array_keys(top_n($page_hits,1))[0] ?? '-') ?></div>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <div class="font-semibold">Top IPs</div>
        <table class="text-xs w-full">
          <thead>
            <tr><th>IP</th><th>Hits</th></tr>
          </thead>
          <tbody>
            <?php foreach(top_n($ip_counts,5) as $ip=>$cnt): ?>
            <tr>
              <td><?= htmlspecialchars($ip) ?></td>
              <td><?= $cnt ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- hits per day chart -->
    <div class="mb-8 p-4 bg-white dark:bg-gray-800 rounded shadow">
      <canvas id="trafficChart" height="100"></canvas>
      <p class="text-xs text-center text-gray-500 mt-2">Hits per Day</p>
    </div>

    <!-- Top Pages & Referrers -->
    <div class="grid md:grid-cols-2 gap-4 mb-8">
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Top Pages</h2>
        <ol class="list-decimal ml-6 text-sm">
          <?php foreach(top_n($page_hits,7) as $uri=>$c): ?>
            <li><?= htmlspecialchars($uri) ?> (<?= $c ?>)</li>
          <?php endforeach; ?>
        </ol>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Top Referrers</h2>
        <ol class="list-decimal ml-6 text-sm">
          <?php foreach(top_n($referrers,7) as $r=>$c): ?>
            <li><?= htmlspecialchars($r) ?> (<?= $c ?>)</li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>

    <!-- Recent Admin Hits -->
    <div class="grid md:grid-cols-2 gap-4">
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Recent Admin Hits</h2>
        <ul class="text-xs font-mono">
          <?php foreach(array_slice(array_reverse($admin_hits), 0, 10) as $e): ?>
            <li>
              <?= htmlspecialchars($e['ts']) ?> –
              <?= htmlspecialchars($e['ip']) ?> 
              <?= htmlspecialchars($e['page']) ?> 
              (<?= htmlspecialchars($e['status'].'/'.$e['load_time'].'s') ?>)
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Traffic by Date</h2>
        <pre class="text-xs"><?= 
            implode("\n", array_map(
              fn($d,$n) => "$d : $n hits", 
              array_keys($traffic_by_date), 
              array_values($traffic_by_date)
            )) 
        ?></pre>
      </div>
    </div>
  </div>

  <footer class="text-center text-sm text-gray-500 py-4">
    &copy; <?= date('Y') ?> KTP Digital Pty Ltd.
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', ()=> {
    new Chart(document.getElementById('trafficChart'), {
      type: 'line',
      data: {
        labels: <?= json_encode(array_keys($traffic_by_date)) ?>,
        datasets: [{
          data: <?= json_encode(array_values($traffic_by_date)) ?>,
          fill: false,
          tension: 0.1
        }]
      },
      options: {
        plugins:{ legend:{ display:false } },
        scales:{ y:{ beginAtZero:true } }
      }
    });
  });
  </script>
</body>
</html>
