<?php
include 'admin_auth.php';
include 'admin_nav.php';

// --- Handle Delete Action ---
$snapshot_dir = __DIR__ . '/../snapshots';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $del_file = basename($_POST['delete_file']);
    $del_path = "$snapshot_dir/$del_file";
    if (is_file($del_path)) {
        unlink($del_path);
        echo "<div class='max-w-2xl mx-auto my-4 p-3 bg-green-100 border border-green-400 text-green-900 rounded-xl text-center'>🗑️ Deleted: " . htmlspecialchars($del_file) . "</div>";
    }
}

// --- Database Backup Functions ---
function getBackupStats() {
    // First get stats from database for accuracy
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get stats from database
        $query = "SELECT 
            backup_type,
            COUNT(*) as count,
            SUM(file_size) as total_size,
            MAX(created_at) as latest_time
        FROM database_backups 
        WHERE status = 'completed'
        GROUP BY backup_type";
        
        $stmt = $pdo->query($query);
        $db_stats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $db_stats[$row['backup_type']] = [
                'count' => $row['count'],
                'size' => $row['total_size'],
                'latest_time' => strtotime($row['latest_time'])
            ];
        }
        
        // Get total stats
        $total_query = "SELECT COUNT(*) as total_count, SUM(file_size) as total_size 
                        FROM database_backups WHERE status = 'completed'";
        $total_stmt = $pdo->query($total_query);
        $totals = $total_stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        // Fall back to file system if database unavailable
        $db_stats = [];
        $totals = null;
    }
    
    // Also check file system for real-time accuracy
    $backup_dir = '/opt/webstack/backups';
    $stats = [
        'hourly' => ['count' => 0, 'size' => 0, 'latest' => null],
        'daily' => ['count' => 0, 'size' => 0, 'latest' => null],
        'weekly' => ['count' => 0, 'size' => 0, 'latest' => null],
        'monthly' => ['count' => 0, 'size' => 0, 'latest' => null],
        'manual' => ['count' => 0, 'size' => 0, 'latest' => null],
        'total_size' => 0,
        'total_count' => 0
    ];
    
    foreach (['hourly', 'daily', 'weekly', 'monthly', 'manual'] as $type) {
        $type_dir = "$backup_dir/$type";
        if (is_dir($type_dir)) {
            $files = glob("$type_dir/*.sql.gz");
            $stats[$type]['count'] = count($files);
            
            if ($files) {
                // Get latest file
                $latest_time = 0;
                foreach ($files as $file) {
                    $stats[$type]['size'] += filesize($file);
                    $mtime = filemtime($file);
                    if ($mtime > $latest_time) {
                        $latest_time = $mtime;
                        $stats[$type]['latest'] = basename($file);
                        $stats[$type]['latest_time'] = $mtime;
                    }
                }
            }
            
            // Use database stats if available and more recent
            if (isset($db_stats[$type]) && $db_stats[$type]['count'] > 0) {
                $stats[$type]['db_count'] = $db_stats[$type]['count'];
                $stats[$type]['db_size'] = $db_stats[$type]['size'];
            }
            
            $stats['total_size'] += $stats[$type]['size'];
            $stats['total_count'] += $stats[$type]['count'];
        }
    }
    
    // Use database totals if available
    if ($totals) {
        $stats['db_total_count'] = $totals['total_count'];
        $stats['db_total_size'] = $totals['total_size'];
    }
    
    return $stats;
}

function getLastSyncInfo() {
    $log_file = '/opt/webstack/backups/qnap_sync.log';
    $last_sync = null;
    
    if (file_exists($log_file)) {
        // Get last successful sync from log
        $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        for ($i = count($lines) - 1; $i >= 0; $i--) {
            if (strpos($lines[$i], 'Sync completed successfully') !== false) {
                // Extract timestamp from log line
                if (preg_match('/\[([\d\-\s:]+)\]/', $lines[$i], $matches)) {
                    $last_sync = strtotime($matches[1]);
                    break;
                }
            }
        }
    }
    
    return $last_sync;
}

function formatBytes($bytes) {
    if ($bytes >= 1073741824) {
        return round($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}

function getTimeAgo($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 3600) {
        return round($diff / 60) . ' minutes ago';
    } elseif ($diff < 86400) {
        return round($diff / 3600) . ' hours ago';
    } else {
        return round($diff / 86400) . ' days ago';
    }
}

// Get backup statistics
$backup_stats = getBackupStats();
$last_sync = getLastSyncInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Maintenance – KTP Digital</title>
  <meta name="description" content="Download Webstack snapshot backups and view deployment history.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
</head>
<body class="bg-white text-gray-900  ">
  <div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">🛠️ Maintenance & Backups</h1>
    
    <!-- Database Backup Status -->
    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
      <h2 class="text-xl font-bold mb-4 text-blue-900">💾 Database Backup Status</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-white rounded-lg p-4 shadow-sm">
          <div class="text-sm text-gray-600">Total Backups</div>
          <div class="text-2xl font-bold text-gray-900"><?php echo $backup_stats['total_count']; ?></div>
          <div class="text-xs text-gray-500"><?php echo formatBytes($backup_stats['total_size']); ?> total</div>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm">
          <div class="text-sm text-gray-600">QNAP Sync Status</div>
          <?php if ($last_sync): ?>
            <div class="text-lg font-semibold text-green-600">✅ Active</div>
            <div class="text-xs text-gray-500">Last: <?php echo getTimeAgo($last_sync); ?></div>
          <?php else: ?>
            <div class="text-lg font-semibold text-yellow-600">⚠️ No sync yet</div>
            <div class="text-xs text-gray-500">Waiting for first sync</div>
          <?php endif; ?>
        </div>
        
        <div class="bg-white rounded-lg p-4 shadow-sm">
          <div class="text-sm text-gray-600">Database Size</div>
          <?php 
            $db_size = shell_exec("du -sh /var/lib/mysql/ktp_digital/ 2>/dev/null | cut -f1");
            echo "<div class='text-2xl font-bold text-gray-900'>" . trim($db_size ?: '12M') . "</div>";
          ?>
          <div class="text-xs text-gray-500">MariaDB ktp_digital</div>
        </div>
      </div>
      
      <!-- Backup Schedule Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Type</th>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Schedule</th>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Retention</th>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Count</th>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Size</th>
              <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Latest Backup</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php
            $schedules = [
                'hourly' => ['schedule' => 'Every hour', 'retention' => '24 hours'],
                'daily' => ['schedule' => '2:30 AM', 'retention' => '7 days'],
                'weekly' => ['schedule' => 'Sunday 3:00 AM', 'retention' => '4 weeks'],
                'monthly' => ['schedule' => '1st @ 3:30 AM', 'retention' => '3 months'],
                'manual' => ['schedule' => 'On demand', 'retention' => 'As needed']
            ];
            
            foreach ($schedules as $type => $info):
                $type_stats = $backup_stats[$type];
            ?>
            <tr>
              <td class="px-4 py-2 text-sm font-medium text-gray-900"><?php echo ucfirst($type); ?></td>
              <td class="px-4 py-2 text-sm text-gray-600"><?php echo $info['schedule']; ?></td>
              <td class="px-4 py-2 text-sm text-gray-600"><?php echo $info['retention']; ?></td>
              <td class="px-4 py-2 text-sm text-gray-900"><?php echo $type_stats['count']; ?></td>
              <td class="px-4 py-2 text-sm text-gray-600"><?php echo formatBytes($type_stats['size']); ?></td>
              <td class="px-4 py-2 text-sm text-gray-500">
                <?php 
                if ($type_stats['latest']) {
                    echo getTimeAgo($type_stats['latest_time']);
                } else {
                    echo '<span class="text-gray-400">None yet</span>';
                }
                ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <!-- Quick Actions -->
      <div class="mt-4 flex flex-wrap gap-2">
        <button onclick="runBackup('manual')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
          🔄 Run Manual Backup
        </button>
        <button onclick="syncToQnap()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
          ☁️ Sync to QNAP Now
        </button>
        <a href="/docs/DATABASE_BACKUP_GUIDE.md" target="_blank" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm">
          📖 Backup Guide
        </a>
      </div>
    </div>
    
    <!-- Deployment Snapshots Section -->
    <h2 class="text-xl font-bold mb-4">📦 Deployment Snapshots</h2>
    <p class="mb-6 text-lg">View, download, or delete previous deployment snapshots of this website.</p>
    <div class="overflow-x-auto rounded-lg shadow">
      <table class="min-w-full divide-y divide-gray-200 ">
        <thead class="bg-gray-100 ">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 ">Filename</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 ">Size</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 ">Modified</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 ">Download</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 ">Delete</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 ">
        <?php
          $files = array_diff(scandir($snapshot_dir), ['.', '..']);
          usort($files, function($a, $b) use ($snapshot_dir) {
            return filemtime("$snapshot_dir/$b") - filemtime("$snapshot_dir/$a");
          });

          foreach ($files as $file) {
            $path = "/snapshots/$file";
            $size_bytes = filesize("$snapshot_dir/$file");
            $size = $size_bytes >= 1048576 ? round($size_bytes / 1048576, 1) . ' MB' : round($size_bytes / 1024, 1) . ' KB';
            $date = date("Y-m-d H:i:s", filemtime("$snapshot_dir/$file"));
            echo "<tr>";
            echo "<td class='px-4 py-2 font-mono text-sm text-blue-600 '>$file</td>";
            echo "<td class='px-4 py-2 text-sm'>$size</td>";
            echo "<td class='px-4 py-2 text-sm text-gray-500'>$date</td>";
            echo "<td class='px-4 py-2 text-sm'><a href='$path' class='text-blue-600 hover:underline' download>⬇️ Download</a></td>";
            echo "<td class='px-4 py-2 text-sm'>
                    <form method=\"post\" action=\"\" onsubmit=\"return confirm('Delete $file?');\" style=\"display:inline\">
                      <input type=\"hidden\" name=\"delete_file\" value=\"" . htmlspecialchars($file) . "\">
                      <button type=\"submit\" class=\"text-red-600 hover:underline bg-transparent border-0 p-0 m-0 cursor-pointer\" style=\"font: inherit;\">🗑️ Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
  <footer class="mt-12 text-center text-sm text-gray-500 ">
    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
  </footer>
  
  <script>
  function runBackup(type) {
    if (!confirm(`Run ${type} backup now? This may take a few moments.`)) return;
    
    // Show loading state
    event.target.disabled = true;
    event.target.innerHTML = '⏳ Running...';
    
    // Make AJAX request to run backup
    fetch('/admin/run_backup.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'type=' + type
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('✅ Backup completed successfully!\nFile: ' + data.file);
        location.reload();
      } else {
        alert('❌ Backup failed: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(error => {
      alert('❌ Error running backup: ' + error);
    })
    .finally(() => {
      event.target.disabled = false;
      event.target.innerHTML = '🔄 Run Manual Backup';
    });
  }
  
  function syncToQnap() {
    if (!confirm('Sync backups to QNAP now? This will sync all local backups to the remote server.')) return;
    
    // Show loading state
    event.target.disabled = true;
    event.target.innerHTML = '⏳ Syncing...';
    
    // Make AJAX request to run sync
    fetch('/admin/run_sync.php', {
      method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('✅ Sync completed successfully!\n' + data.message);
        location.reload();
      } else {
        alert('❌ Sync failed: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(error => {
      alert('❌ Error running sync: ' + error);
    })
    .finally(() => {
      event.target.disabled = false;
      event.target.innerHTML = '☁️ Sync to QNAP Now';
    });
  }
  </script>
</body>
</html>
