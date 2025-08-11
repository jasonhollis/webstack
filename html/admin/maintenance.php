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
    <h1 class="text-3xl font-bold mb-6">🛠️ Maintenance & Snapshots</h1>
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
</body>
</html>
EOF
