<?php
include 'admin_auth.php';
include 'admin_nav.php';

$log_file = '/opt/webstack/logs/web_analytics.log';
$lines = @file($log_file) ?: [];
$total_lines = count($lines);

$limit = isset($_GET['all']) ? $total_lines : max(10, intval($_GET['n'] ?? 200));
$recent = array_slice($lines, -$limit);

$exclude_ip = !empty($_GET['no_me']) ? '103.224.53.7' : null;

$total_hits = 0;
$total_load_time = 0;
$page_hits = [];
$ip_hits = [];
$referrers = [];
$user_agents = [];
$admin_hits = [];
$dates = [];

foreach ($recent as $line) {
    $data = @json_decode(trim($line), true);
    if (!$data || ($exclude_ip && $data['ip'] === $exclude_ip)) continue;

    $total_hits++;
    $total_load_time += $data['load_time'] ?? 0;
    $page = $data['page'] ?? 'unknown';
    $ip = $data['ip'] ?? 'unknown';
    $ref = $data['referer'] ?? '-';
    $ua = $data['ua'] ?? 'unknown';
    $ts = $data['ts'] ?? '';

    $page_hits[$page] = ($page_hits[$page] ?? 0) + 1;
    $ip_hits[$ip] = ($ip_hits[$ip] ?? 0) + 1;
    if ($ref !== '-') $referrers[$ref] = ($referrers[$ref] ?? 0) + 1;
    $user_agents[$ua] = ($user_agents[$ua] ?? 0) + 1;

    if (strpos($page, 'admin/') !== false) {
        $admin_hits[] = $page;
    }

    if ($ts) {
        $date = substr($ts, 0, 10);
        $dates[$date] = ($dates[$date] ?? 0) + 1;
    }
}

arsort($page_hits);
arsort($ip_hits);
arsort($referrers);
arsort($user_agents);

$avg_load = $total_hits ? round($total_load_time / $total_hits, 4) : 0;
$top_ips = array_slice($ip_hits, 0, 5, true);

$geo_cache = [];
function lookup_ip($ip) {
    global $geo_cache;
    if (isset($geo_cache[$ip])) return $geo_cache[$ip];
    $json = @file_get_contents("http://ip-api.com/json/{$ip}");
    return $geo_cache[$ip] = $json ? @json_decode($json, true) : null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Analytics Dashboard – KTP Digital</title>
  <meta name="description" content="KTP Webstack traffic monitoring with IP, referrer, user agent, and load time breakdown.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">

<div class="max-w-6xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-4">📊 Analytics Dashboard</h1>

  <form method="get" class="mb-6 flex flex-wrap items-center gap-4 text-sm">
    <div>
      <label for="n" class="mr-2 font-semibold">Hits to Analyze:</label>
      <input type="number" id="n" name="n" value="<?= htmlspecialchars($limit) ?>" min="10" max="<?= $total_lines ?>" class="border px-2 py-1 rounded w-24 dark:bg-gray-800 dark:border-gray-600">
    </div>
    <label class="flex items-center space-x-2">
      <input type="checkbox" name="no_me" value="1" <?= $exclude_ip ? 'checked' : '' ?> class="rounded border-gray-400">
      <span>Exclude My IP</span>
    </label>
    <button type="submit" class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">Apply</button>
  </form>

  <p class="text-sm mb-4">
    <strong>Detected IP:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? 'Unknown' ?> |
    <strong>Total Log Entries:</strong> <?= $total_lines ?> |
    <strong>Sample Log IPs:</strong> <?= implode(', ', array_keys($top_ips)) ?>
  </p>

  <div class="grid md:grid-cols-2 gap-6 text-center text-xl font-semibold mb-8">
    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">Hits in View<br><span class="text-3xl"><?= $total_hits ?></span></div>
    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">Avg Load Time<br><span class="text-3xl"><?= $avg_load ?>s</span></div>
  </div>

  <div class="overflow-x-auto mb-10">
    <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700 text-sm text-left">
      <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
        <tr>
          <th class="px-4 py-2">IP</th>
          <th class="px-4 py-2">Hits</th>
          <th class="px-4 py-2">Location</th>
          <th class="px-4 py-2">ASN</th>
          <th class="px-4 py-2">ASN Name</th>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
      <?php foreach ($top_ips as $ip => $hits):
          $info = lookup_ip($ip); ?>
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
          <td class="px-4 py-2 text-blue-600"><a href="http://ip-api.com/<?= $ip ?>" target="_blank"><?= $ip ?></a></td>
          <td class="px-4 py-2"><?= $hits ?></td>
          <td class="px-4 py-2"><?= $info['city'] ?? '-' ?>, <?= $info['countryCode'] ?? '-' ?></td>
          <td class="px-4 py-2"><?= $info['as'] ?? '-' ?></td>
          <td class="px-4 py-2"><?= $info['org'] ?? '-' ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="grid md:grid-cols-2 gap-6 mb-10">
    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">
      <h2 class="font-bold mb-2">Top Pages</h2>
      <ul class="text-sm text-gray-800 dark:text-gray-200">
        <?php foreach (array_slice($page_hits, 0, 10) as $page => $count): ?>
        <li><?= htmlspecialchars($page) ?> (<?= $count ?>)</li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">
      <h2 class="font-bold mb-2">Top Referrers</h2>
      <?php if (count($referrers) === 0): ?>
        <p class="text-sm italic text-gray-500">No referring traffic yet.</p>
      <?php else: ?>
        <ul class="text-sm text-gray-800 dark:text-gray-200">
          <?php foreach (array_slice($referrers, 0, 10) as $ref => $count): ?>
          <li><?= htmlspecialchars($ref) ?> (<?= $count ?>)</li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

  <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow mb-10">
    <h2 class="font-bold mb-2">Top User Agents</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-200 dark:bg-gray-700">
          <tr>
            <th class="text-left py-1 px-2">User Agent Substring</th>
            <th class="text-right py-1 px-2">Hits</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900">
          <?php foreach ($user_agents as $ua => $count): ?>
            <?php $is_ai = preg_match('/(curl|python|openai|chatgpt|go-http|httpx|aiohttp|node)/i', $ua); ?>
            <tr class="border-t">
              <td class="py-1 px-2 font-mono"><?= $is_ai ? '🤖 ' : '' ?><?= htmlspecialchars($ua) ?></td>
              <td class="py-1 px-2 text-right"><?= $count ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow">
    <h2 class="font-bold mb-2">Traffic by Date</h2>
    <ul class="text-sm">
      <?php foreach ($dates as $day => $n): ?>
      <li>[<?= $day ?>] : <?= $n ?> hits</li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

</body>
</html>
