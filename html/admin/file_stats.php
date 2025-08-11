<?php
include 'admin_auth.php';
include 'admin_nav.php';

// -------- CONFIG ---------
$logfile = '/opt/webstack/logs/web_analytics.log';
$version_file = '/opt/webstack/html/VERSION';
$scan_dirs = ['/opt/webstack/html', '/opt/webstack/bin', '/opt/webstack/objectives'];
$since_ts = time() - 86400;


// --------- HITS TODAY ---------
$hits_today = 0;
$today = date('Y-m-d');
if (file_exists($logfile)) {
    foreach (file($logfile) as $line) {
        if (strpos($line, "[$today") === 0) $hits_today++;
    }
}

// --------- CURRENT VERSION ---------
$current_version = file_exists($version_file) ? trim(file_get_contents($version_file)) : 'Unknown';

// --------- GIT COMMIT COUNTS ---------
function count_commits($since) {
    $cmd = 'HOME=/tmp bash -c "cd /opt/webstack && /usr/bin/git rev-list --count --all --since=\'' . $since . '\'"';
    exec($cmd, $out, $code);
    return ($code === 0 && isset($out[0])) ? intval($out[0]) : -1;
}



$commits_24h = count_commits("24 hours ago");
$commits_7d  = count_commits("7 days ago");
$commits_30d = count_commits("30 days ago");
$commits_365d = count_commits("1 year ago");

// --------- VERSION BUMPS ---------
function count_version_bumps($since) {
    $cmd = 'HOME=/tmp bash -c "cd /opt/webstack && /usr/bin/git log --since=\'' . $since . '\' --pretty=format:\'%s\'"';
    exec($cmd, $lines, $code);
    if ($code !== 0) return -1;
    return count(array_filter($lines, fn($line) => strpos($line, '⬆️ Version bump') === 0));
}



$bumps_24h = count_version_bumps("24 hours ago");
$bumps_7d  = count_version_bumps("7 days ago");
$bumps_30d = count_version_bumps("30 days ago");
$bumps_365d = count_version_bumps("1 year ago");

// ---- UNTRACKED/OTHER FILE CHANGES ----
$untracked_files = [];
foreach ($scan_dirs as $dir) {
    if (!is_dir($dir)) continue;
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($rii as $file) {
        if ($file->isFile() && $file->getMTime() >= $since_ts) {
            $untracked_files[] = [
                'file' => $file->getPathname(),
                'mtime' => date('Y-m-d H:i:s', $file->getMTime())
            ];
        }
    }
}
$total_untracked = count($untracked_files);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>File Stats — KTP File Change Digest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
</head>
<body class="bg-white text-gray-900   min-h-screen">
  <div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-2">📈 File & Git Activity Summary</h1>

    <div class="mb-4 p-4 bg-gray-100  rounded-xl shadow">
      <div class="flex justify-between items-center">
        <div class="text-lg font-semibold">Current Version</div>
        <div class="text-xl font-mono"><?=htmlspecialchars($current_version)?></div>
      </div>
    </div>

    <div class="mb-4 p-4 bg-gray-100  rounded-xl shadow flex items-center justify-between">
      <div class="text-lg font-semibold">Web Hits Today</div>
      <div class="text-3xl font-mono"><?=number_format($hits_today)?></div>
    </div>

    <div class="mb-4 p-4 bg-gray-100  rounded-xl shadow">
      <div class="text-lg font-semibold mb-2">Git Commits</div>
      <ul class="text-sm font-mono grid grid-cols-2 gap-y-1">
        <li>Last 24h: <strong><?= $commits_24h ?></strong></li>
        <li>Last 7d: <strong><?= $commits_7d ?></strong></li>
        <li>Last 30d: <strong><?= $commits_30d ?></strong></li>
        <li>Last 365d: <strong><?= $commits_365d ?></strong></li>
      </ul>
    </div>

    <div class="mb-4 p-4 bg-gray-100  rounded-xl shadow">
      <div class="text-lg font-semibold mb-2">Version Bumps</div>
      <ul class="text-sm font-mono grid grid-cols-2 gap-y-1">
        <li>Last 24h: <strong><?= $bumps_24h ?></strong></li>
        <li>Last 7d: <strong><?= $bumps_7d ?></strong></li>
        <li>Last 30d: <strong><?= $bumps_30d ?></strong></li>
        <li>Last 365d: <strong><?= $bumps_365d ?></strong></li>
      </ul>
    </div>

    <div class="mb-6 p-4 bg-gray-100  rounded-xl shadow">
      <div class="text-lg font-semibold mb-2">Untracked File Changes (Past 24h)</div>
      <?php if ($total_untracked): ?>
        <ul class="text-xs font-mono">
          <?php foreach ($untracked_files as $uf): ?>
            <li><?=htmlspecialchars($uf['file'])?> <span class="text-gray-400">(<?=htmlspecialchars($uf['mtime'])?>)</span></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="text-gray-400">No untracked or out-of-git file changes detected.</div>
      <?php endif; ?>
    </div>

    <div class="text-gray-400 text-xs">Generated at <?=date('H:i:s')?> AEST</div>
  </div>
</body>
</html>
