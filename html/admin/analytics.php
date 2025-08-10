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

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Build query with optional IP exclusion
$exclude_clause = $exclude_ip ? "AND ip != :exclude_ip" : "";

// Get recent analytics data (last 1000 records)
$stmt = $pdo->prepare("
    SELECT * FROM web_analytics 
    WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    $exclude_clause
    ORDER BY timestamp DESC 
    LIMIT 1000
");

if ($exclude_ip) {
    $stmt->bindParam(':exclude_ip', $exclude_ip);
}
$stmt->execute();
$recent_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// aggregate structures
$total_hits       = count($recent_data);
$traffic_by_date  = [];
$page_hits        = [];
$referrers        = [];
$user_agents      = [];
$response_times   = [];
$admin_hits       = [];
$public_hits      = [];
$ip_counts        = [];
$device_stats     = [];
$browser_stats    = [];
$os_stats         = [];
$bot_stats        = [];

// process database records
foreach ($recent_data as $entry) {
    $ip = $entry['ip'];
    $date = substr($entry['timestamp'], 0, 10);
    
    // Traffic by date
    $traffic_by_date[$date] = ($traffic_by_date[$date] ?? 0) + 1;
    
    // Page hits
    $page_hits[$entry['page']] = ($page_hits[$entry['page']] ?? 0) + 1;
    
    // Referrers
    $referer = $entry['referer'] ?: '-';
    $referrers[$referer] = ($referrers[$referer] ?? 0) + 1;
    
    // User agents
    $user_agents[$entry['user_agent']] = ($user_agents[$entry['user_agent']] ?? 0) + 1;
    
    // Response times (convert from ms to seconds for compatibility)
    $load_time_seconds = ($entry['load_time_ms'] ?? 0) / 1000;
    $response_times[] = $load_time_seconds;
    
    // IP counts
    $ip_counts[$ip] = ($ip_counts[$ip] ?? 0) + 1;
    
    // Device statistics
    if ($entry['device_type']) {
        $device_stats[$entry['device_type']] = ($device_stats[$entry['device_type']] ?? 0) + 1;
    }
    
    // Browser statistics
    if ($entry['browser']) {
        $browser_stats[$entry['browser']] = ($browser_stats[$entry['browser']] ?? 0) + 1;
    }
    
    // OS statistics
    if ($entry['os']) {
        $os_stats[$entry['os']] = ($os_stats[$entry['os']] ?? 0) + 1;
    }
    
    // Bot statistics
    if ($entry['is_bot']) {
        $bot_stats['bots'] = ($bot_stats['bots'] ?? 0) + 1;
    } else {
        $bot_stats['humans'] = ($bot_stats['humans'] ?? 0) + 1;
    }
    
    // Admin vs Public (infer from page)
    if (strpos($entry['page'], '/admin/') !== false) {
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
      Showing data for last <?= $total_hits ?> hit<?= $total_hits===1?'':'s' ?> (last 30 days)
      <?= $exclude_ip? "(excluding your IP)" : "" ?>
      | Bots: <?= $bot_stats['bots'] ?? 0 ?> | Humans: <?= $bot_stats['humans'] ?? 0 ?>
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

    <!-- Device & Browser Stats -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Device Types</h2>
        <div class="text-sm">
          <?php foreach($device_stats as $device=>$count): ?>
            <div class="flex justify-between py-1">
              <span><?= ucfirst($device) ?>:</span>
              <span><?= $count ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Top Browsers</h2>
        <div class="text-sm">
          <?php foreach(top_n($browser_stats,5) as $browser=>$count): ?>
            <div class="flex justify-between py-1">
              <span><?= htmlspecialchars($browser) ?>:</span>
              <span><?= $count ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Top Operating Systems</h2>
        <div class="text-sm">
          <?php foreach(top_n($os_stats,5) as $os=>$count): ?>
            <div class="flex justify-between py-1">
              <span><?= htmlspecialchars($os) ?>:</span>
              <span><?= $count ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Recent Admin Hits -->
    <div class="grid md:grid-cols-2 gap-4">
      <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
        <h2 class="font-bold mb-2">Recent Admin Hits</h2>
        <ul class="text-xs font-mono">
          <?php foreach(array_slice(array_reverse($admin_hits), 0, 10) as $e): ?>
            <li>
              <?= htmlspecialchars($e['timestamp']) ?> –
              <?= htmlspecialchars($e['ip']) ?> 
              <?= htmlspecialchars($e['page']) ?> 
              (<?= htmlspecialchars($e['status_code'].'/'.(($e['load_time_ms'] ?? 0)/1000).'s') ?>)
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
