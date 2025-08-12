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

// Also check GET parameter for form persistence
if (isset($_GET['exclude_ip']) && $_GET['exclude_ip'] == '1' && $exclude_ip) {
    // Keep the excluded IP active
} elseif (isset($_GET['exclude_ip']) && $_GET['exclude_ip'] == '0') {
    $exclude_ip = null;
}

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get parameters for date range and limit
$days = isset($_GET['days']) ? intval($_GET['days']) : 30;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 1000;
$days = max(1, min(365, $days)); // Constrain between 1-365 days
$limit = max(100, min(10000, $limit)); // Constrain between 100-10000 records

// Build query with optional IP exclusion
$exclude_clause = $exclude_ip ? "AND ip != :exclude_ip" : "";

// Get recent analytics data
$stmt = $pdo->prepare("
    SELECT * FROM web_analytics 
    WHERE timestamp >= DATE_SUB(NOW(), INTERVAL :days DAY)
    $exclude_clause
    ORDER BY timestamp DESC 
    LIMIT :limit
");
$stmt->bindParam(':days', $days, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

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
$utm_sources      = [];
$utm_campaigns    = [];
$utm_mediums      = [];
$countries        = [];
$cities           = [];
$session_stats    = [];
$unique_sessions  = [];
$ip_locations     = [];

// IP geolocation with database caching
function lookup_ip($ip, $pdo = null) {
    static $geo_cache = [];
    if (isset($geo_cache[$ip])) return $geo_cache[$ip];
    
    // Skip local IPs
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return $geo_cache[$ip] = ['city' => 'Local', 'country' => 'Local', 'countryCode' => 'XX', 'org' => 'Private Network'];
    }
    
    // Check database cache first (7 day expiry)
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM ip_geolocation_cache WHERE ip = ? AND lookup_date > DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stmt->execute([$ip]);
        $cached = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cached) {
            return $geo_cache[$ip] = [
                'country' => $cached['country'],
                'countryCode' => $cached['country_code'],
                'city' => $cached['city'],
                'org' => $cached['organization'],
                'as' => $cached['asn']
            ];
        }
    }
    
    // Lookup from API (rate limited to avoid abuse)
    $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city,regionName,org,as");
    if ($json) {
        $data = json_decode($json, true);
        if ($data && $data['status'] === 'success') {
            // Store in database cache
            if ($pdo) {
                try {
                    $stmt = $pdo->prepare("REPLACE INTO ip_geolocation_cache 
                        (ip, country_code, country, city, region, organization, asn) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $ip,
                        $data['countryCode'] ?? null,
                        $data['country'] ?? null,
                        $data['city'] ?? null,
                        $data['regionName'] ?? null,
                        $data['org'] ?? null,
                        $data['as'] ?? null
                    ]);
                } catch (Exception $e) {
                    // Silently fail cache write
                }
            }
            return $geo_cache[$ip] = $data;
        }
    }
    return $geo_cache[$ip] = null;
}

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
    
    // UTM tracking
    if (!empty($entry['utm_source'])) {
        $utm_sources[$entry['utm_source']] = ($utm_sources[$entry['utm_source']] ?? 0) + 1;
    }
    if (!empty($entry['utm_campaign'])) {
        $utm_campaigns[$entry['utm_campaign']] = ($utm_campaigns[$entry['utm_campaign']] ?? 0) + 1;
    }
    if (!empty($entry['utm_medium'])) {
        $utm_mediums[$entry['utm_medium']] = ($utm_mediums[$entry['utm_medium']] ?? 0) + 1;
    }
    
    // Geographic data - try database first, then lookup
    if (!empty($entry['ip_country'])) {
        $countries[$entry['ip_country']] = ($countries[$entry['ip_country']] ?? 0) + 1;
    } else {
        // Lookup IP location for frequent IPs (3+ hits to reduce API calls)
        if ($ip_counts[$ip] >= 3) {
            $geo = lookup_ip($ip, $pdo);
            if ($geo && isset($geo['countryCode'])) {
                $countries[$geo['countryCode']] = ($countries[$geo['countryCode']] ?? 0) + 1;
                if (isset($geo['city']) && $geo['city']) {
                    $cities[$geo['city']] = ($cities[$geo['city']] ?? 0) + 1;
                }
                $ip_locations[$ip] = $geo;
            }
        }
    }
    if (!empty($entry['ip_city'])) {
        $cities[$entry['ip_city']] = ($cities[$entry['ip_city']] ?? 0) + 1;
    }
    
    // Session tracking
    if (!empty($entry['session_id'])) {
        $unique_sessions[$entry['session_id']] = true;
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
<body class="bg-white text-gray-900  ">
  <div class="max-w-6xl mx-auto p-6">


    <div class="flex flex-wrap items-center justify-between mb-4">
      <div>
        <h1 class="text-3xl font-bold flex items-center gap-2">📊 Analytics Dashboard</h1>
        <p class="text-sm text-gray-600 mt-1">Showing data for last <?= $days ?> days (<?= count($recent_data) ?> hits, limit: <?= $limit ?>)</p>
      </div>
      <div class="flex gap-2 items-center flex-wrap">
        <form method="get" class="flex gap-2 items-center" id="analytics-form">
          <?php if ($exclude_ip): ?>
            <input type="hidden" name="exclude_ip" value="1">
          <?php endif; ?>
          <select name="days" class="px-2 py-1 border rounded text-sm" onchange="this.form.submit()">
            <option value="7" <?= $days == 7 ? 'selected' : '' ?>>Last 7 days</option>
            <option value="30" <?= $days == 30 ? 'selected' : '' ?>>Last 30 days</option>
            <option value="90" <?= $days == 90 ? 'selected' : '' ?>>Last 90 days</option>
            <option value="365" <?= $days == 365 ? 'selected' : '' ?>>Last year</option>
          </select>
          <select name="limit" class="px-2 py-1 border rounded text-sm" onchange="this.form.submit()">
            <option value="500" <?= $limit == 500 ? 'selected' : '' ?>>500 hits</option>
            <option value="1000" <?= $limit == 1000 ? 'selected' : '' ?>>1000 hits</option>
            <option value="2500" <?= $limit == 2500 ? 'selected' : '' ?>>2500 hits</option>
            <option value="5000" <?= $limit == 5000 ? 'selected' : '' ?>>5000 hits</option>
            <option value="10000" <?= $limit == 10000 ? 'selected' : '' ?>>10000 hits</option>
          </select>
        </form>
        <?php if (!$exclude_ip): ?>
          <a href="?no_me=1&days=<?=$days?>&limit=<?=$limit?>"
             class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm">
            Exclude My IP
          </a>
        <?php else: ?>
          <a href="?show_all=1&days=<?=$days?>&limit=<?=$limit?>"
             class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
            Show All IPs
          </a>
          <span class="text-xs text-gray-600">(Excluding <?=htmlspecialchars($exclude_ip)?>)</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- summary cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="p-4 bg-white  rounded shadow">
        <div class="font-semibold">Total Hits</div>
        <div class="text-2xl"><?= $total_hits ?></div>
      </div>
      <div class="p-4 bg-white  rounded shadow">
        <div class="font-semibold">Avg Load Time</div>
        <div class="text-2xl"><?= number_format($avg_time,3) ?>s</div>
      </div>
      <div class="p-4 bg-white  rounded shadow">
        <div class="font-semibold">Top Page</div>
        <div class="text-xl"><?= htmlspecialchars(array_keys(top_n($page_hits,1))[0] ?? '-') ?></div>
      </div>
      <div class="p-4 bg-white  rounded shadow">
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
    <div class="mb-8 p-4 bg-white  rounded shadow">
      <canvas id="trafficChart" height="100"></canvas>
      <p class="text-xs text-center text-gray-500 mt-2">Hits per Day</p>
    </div>

    <!-- Top IPs with Geolocation -->
    <div class="p-4 bg-white rounded shadow mb-8">
      <h2 class="font-bold mb-3">Top IP Addresses</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-3 py-2 text-left">IP Address</th>
              <th class="px-3 py-2 text-left">Hits</th>
              <th class="px-3 py-2 text-left">Location</th>
              <th class="px-3 py-2 text-left">Organization</th>
              <th class="px-3 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $top_ips = top_n($ip_counts, 10);
            foreach($top_ips as $ip => $hits): 
              $geo = isset($ip_locations[$ip]) ? $ip_locations[$ip] : lookup_ip($ip, $pdo);
            ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-3 py-2 font-mono"><?= htmlspecialchars($ip) ?></td>
                <td class="px-3 py-2"><?= $hits ?></td>
                <td class="px-3 py-2">
                  <?php if ($geo): ?>
                    <?= htmlspecialchars($geo['city'] ?? '-') ?>, <?= htmlspecialchars($geo['country'] ?? $geo['countryCode'] ?? '-') ?>
                  <?php else: ?>
                    <span class="text-gray-500">Unknown</span>
                  <?php endif; ?>
                </td>
                <td class="px-3 py-2 text-xs">
                  <?php if ($geo && isset($geo['org'])): ?>
                    <?= htmlspecialchars(substr($geo['org'], 0, 40)) ?>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
                <td class="px-3 py-2">
                  <a href="http://ip-api.com/<?= urlencode($ip) ?>" target="_blank" class="text-blue-600 hover:underline text-xs">Details</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Top Pages & Referrers -->
    <div class="grid md:grid-cols-2 gap-4 mb-8">
      <div class="p-4 bg-white  rounded shadow">
        <h2 class="font-bold mb-2">Top Pages</h2>
        <ol class="list-decimal ml-6 text-sm">
          <?php foreach(top_n($page_hits,7) as $uri=>$c): ?>
            <li><?= htmlspecialchars($uri) ?> (<?= $c ?>)</li>
          <?php endforeach; ?>
        </ol>
      </div>
      <div class="p-4 bg-white  rounded shadow">
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
      <div class="p-4 bg-white  rounded shadow">
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
      <div class="p-4 bg-white  rounded shadow">
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
      <div class="p-4 bg-white  rounded shadow">
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

    <!-- UTM Campaign Tracking -->
    <?php if (!empty($utm_sources) || !empty($utm_campaigns) || !empty($utm_mediums)): ?>
    <div class="grid md:grid-cols-3 gap-4 mb-8">
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">UTM Sources</h2>
        <div class="text-sm">
          <?php if (empty($utm_sources)): ?>
            <p class="text-gray-500">No UTM source data</p>
          <?php else: ?>
            <?php foreach(top_n($utm_sources, 5) as $source=>$count): ?>
              <div class="flex justify-between py-1">
                <span><?= htmlspecialchars($source) ?>:</span>
                <span><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">UTM Campaigns</h2>
        <div class="text-sm">
          <?php if (empty($utm_campaigns)): ?>
            <p class="text-gray-500">No campaign data</p>
          <?php else: ?>
            <?php foreach(top_n($utm_campaigns, 5) as $campaign=>$count): ?>
              <div class="flex justify-between py-1">
                <span><?= htmlspecialchars($campaign) ?>:</span>
                <span><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">UTM Mediums</h2>
        <div class="text-sm">
          <?php if (empty($utm_mediums)): ?>
            <p class="text-gray-500">No medium data</p>
          <?php else: ?>
            <?php foreach(top_n($utm_mediums, 5) as $medium=>$count): ?>
              <div class="flex justify-between py-1">
                <span><?= htmlspecialchars($medium) ?>:</span>
                <span><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Geographic Analytics -->
    <div class="grid md:grid-cols-2 gap-4 mb-8">
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">Top Countries</h2>
        <div class="text-sm">
          <?php if (empty($countries)): ?>
            <p class="text-gray-500">No geographic data available</p>
          <?php else: ?>
            <?php foreach(top_n($countries, 10) as $country=>$count): ?>
              <div class="flex justify-between py-1">
                <span><?= htmlspecialchars($country) ?>:</span>
                <span><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">Top Cities</h2>
        <div class="text-sm">
          <?php if (empty($cities)): ?>
            <p class="text-gray-500">No city data available</p>
          <?php else: ?>
            <?php foreach(top_n($cities, 10) as $city=>$count): ?>
              <div class="flex justify-between py-1">
                <span><?= htmlspecialchars($city) ?>:</span>
                <span><?= $count ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Session Analytics -->
    <div class="grid md:grid-cols-3 gap-4 mb-8">
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">Session Stats</h2>
        <div class="text-sm">
          <div class="flex justify-between py-1">
            <span>Unique Sessions:</span>
            <span class="font-bold"><?= count($unique_sessions) ?></span>
          </div>
          <div class="flex justify-between py-1">
            <span>Total Page Views:</span>
            <span class="font-bold"><?= $total_hits ?></span>
          </div>
          <div class="flex justify-between py-1">
            <span>Pages per Session:</span>
            <span class="font-bold"><?= count($unique_sessions) > 0 ? round($total_hits / count($unique_sessions), 1) : 0 ?></span>
          </div>
        </div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">Traffic Type</h2>
        <div class="text-sm">
          <div class="flex justify-between py-1">
            <span>Human Traffic:</span>
            <span><?= $bot_stats['humans'] ?? 0 ?></span>
          </div>
          <div class="flex justify-between py-1">
            <span>Bot Traffic:</span>
            <span><?= $bot_stats['bots'] ?? 0 ?></span>
          </div>
          <div class="flex justify-between py-1">
            <span>Bot Percentage:</span>
            <span><?= $total_hits > 0 ? round((($bot_stats['bots'] ?? 0) / $total_hits) * 100, 1) : 0 ?>%</span>
          </div>
        </div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-bold mb-2">Performance</h2>
        <div class="text-sm">
          <div class="flex justify-between py-1">
            <span>Avg Load Time:</span>
            <span class="font-bold"><?= number_format($avg_time, 3) ?>s</span>
          </div>
          <div class="flex justify-between py-1">
            <span>Admin Pages:</span>
            <span><?= count($admin_hits) ?></span>
          </div>
          <div class="flex justify-between py-1">
            <span>Public Pages:</span>
            <span><?= count($public_hits) ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Admin Hits -->
    <div class="grid md:grid-cols-2 gap-4">
      <div class="p-4 bg-white  rounded shadow">
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
      <div class="p-4 bg-white  rounded shadow">
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
