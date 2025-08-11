<?php
include 'admin_auth.php';
include 'admin_nav.php';

$objectives_dir = '/opt/webstack/objectives';
$default_file = 'PROJECT_OBJECTIVES.md';

// Get and sanitize requested file
$file = isset($_GET['file']) && preg_match('/^[\w\-.]+$/', $_GET['file']) ? $_GET['file'] : $default_file;
$full_path = "$objectives_dir/$file";
if (!is_file($full_path)) {
    $file = $default_file;
    $full_path = "$objectives_dir/$default_file";
}

// Markdown viewer (Parsedown)
include_once __DIR__ . '/Parsedown.php';
$parsedown = new Parsedown();

// Read objectives file list
$files = array_reverse(array_values(array_filter(scandir($objectives_dir), function($f) use ($objectives_dir) {
    return preg_match('/\.md$/', $f) && is_file("$objectives_dir/$f");
})));

// Gather file info
$filemeta = [];
foreach ($files as $f) {
    $fpath = "$objectives_dir/$f";
    $filemeta[] = [
        'name' => $f,
        'size' => filesize($fpath),
        'mtime' => filemtime($fpath),
    ];
}
usort($filemeta, fn($a, $b) => $b['mtime'] <=> $a['mtime']); // Most recent first

// Load file content
$text = @file_get_contents($full_path);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Objectives & Change Log – KTP Digital</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
  <style>
    .markdown-body img { max-width: 100%; }
    .file-row.active { background: #2563eb22; font-weight: bold; }
  </style>
</head>
<body class="bg-white text-gray-900  ">
<div class="max-w-6xl mx-auto p-6">
  <div class="mb-4 flex items-center gap-4">
    <h1 class="text-3xl font-bold">Objectives & Change Log</h1>
    <span class="text-sm text-gray-500">(Markdown, versioned, downloadable)</span>
  </div>
  <div class="flex flex-col md:flex-row gap-6">
    <!-- File list/filter -->
    <div class="md:w-1/3">
      <div class="bg-gray-100  rounded p-3 shadow mb-4">
        <div class="font-semibold mb-2 text-lg">Objective & Log Files</div>
        <input type="text" id="fileSearch" class="w-full mb-2 px-2 py-1 rounded border border-gray-300  bg-white " placeholder="Filter files...">
        <div id="fileList" class="space-y-1 max-h-96 overflow-auto">
          <?php foreach ($filemeta as $meta): ?>
            <a class="file-row block px-2 py-1 rounded hover:bg-blue-200 :bg-blue-700<?php echo $meta['name'] === $file ? ' active' : '' ?>"
              href="?file=<?php echo htmlspecialchars($meta['name']); ?>"
              data-name="<?php echo strtolower(htmlspecialchars($meta['name'])); ?>">
              <span class="inline-block w-52 truncate align-middle"><?php echo htmlspecialchars($meta['name']); ?></span>
              <span class="text-xs text-gray-500 align-middle ml-2"><?php echo date('Y-m-d H:i', $meta['mtime']); ?></span>
              <span class="text-xs text-gray-400 align-middle ml-2"><?php echo number_format($meta['size']/1024,1); ?> KB</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <!-- Markdown Viewer -->
    <div class="md:w-2/3">
      <div class="flex justify-between mb-2">
        <a href="#fileList" class="text-blue-600 hover:underline">&larr; Back to file list</a>
        <div>
          <button id="toggleRaw" class="px-3 py-1 rounded bg-gray-200  text-gray-700  hover:bg-blue-500 hover:text-white focus:outline-none text-sm mr-2">Show Raw</button>
          <a href="<?php echo '/objectives/' . rawurlencode($file); ?>" class="inline-block px-3 py-1 rounded bg-blue-600 text-white text-sm hover:bg-blue-700 shadow transition">
            Download
          </a>
        </div>
      </div>
      <div id="rendered" class="markdown-body prose prose-lg  bg-white  rounded p-4 shadow overflow-x-auto"><?php
        echo $parsedown->text($text ?: 'Unable to load objectives file.');
      ?></div>
      <pre id="raw" class="hidden bg-gray-100  text-xs p-4 rounded shadow overflow-x-auto whitespace-pre-wrap"><?php
        echo htmlspecialchars($text ?: 'Unable to load objectives file.');
      ?></pre>
    </div>
  </div>
</div>
<script>
  // Toggle Raw/Rendered View
  document.getElementById('toggleRaw').onclick = function() {
    var r = document.getElementById('rendered');
    var w = document.getElementById('raw');
    if (r.classList.contains('hidden')) {
      r.classList.remove('hidden');
      w.classList.add('hidden');
      this.textContent = 'Show Raw';
    } else {
      r.classList.add('hidden');
      w.classList.remove('hidden');
      this.textContent = 'Show Rendered';
    }
  };
  // Filter file list
  document.getElementById('fileSearch').oninput = function() {
    var val = this.value.toLowerCase();
    document.querySelectorAll('#fileList .file-row').forEach(function(a) {
      a.style.display = a.getAttribute('data-name').includes(val) ? '' : 'none';
    });
  };
</script>
</body>
</html>
