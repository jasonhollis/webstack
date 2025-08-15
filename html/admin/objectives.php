<?php
ini_set('display_errors', 1); error_reporting(E_ALL);
include_once 'admin_auth.php';
include_once 'admin_nav.php';

$objectives_dir = '/opt/webstack/objectives';
$images_url = '/admin/objectives/images/';
$version_file = '/opt/webstack/html/VERSION';

$version = isset($_GET['version']) ? basename($_GET['version']) : trim(@file_get_contents($version_file));
$obj_file = "$objectives_dir/{$version}_objectives.md";

// Handle download request
if (isset($_GET['download']) && file_exists($obj_file)) {
    header('Content-Type: text/markdown');
    header('Content-Disposition: attachment; filename="' . basename($obj_file) . '"');
    header('Content-Length: ' . filesize($obj_file));
    readfile($obj_file);
    exit;
}

// Find all objectives logs for dropdown
$objs = [];
foreach (glob("$objectives_dir/*_objectives.md") as $f) {
    $ver = basename($f, '_objectives.md');
    $objs[$ver] = $f;
}
krsort($objs);

$content = false;
if (is_readable($obj_file)) {
    $content = file_get_contents($obj_file);
}

$html = '';
if ($content !== false && strlen(trim($content)) > 0) {
    if (file_exists('Parsedown.php')) {
        require_once 'Parsedown.php';
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($content);
        // Make images clickable if they reference the images folder
        $html = preg_replace_callback(
            '/<img\s+[^>]*src="([^"]+)"[^>]*>/i',
            function ($matches) use ($images_url) {
                $src = $matches[1];
                // Only link images from /admin/objectives/images/
                if (strpos($src, $images_url) === 0 || preg_match('#^/?admin/objectives/images/#', $src)) {
                    return '<a href="'.$src.'" target="_blank">'.$matches[0].'</a>';
                }
                return $matches[0];
            },
            $html
        );
    } else {
        // Fallback: plain pre
        $html = '<pre>' . htmlspecialchars($content) . '</pre>';
    }
} else {
    $html = "<em>No objectives for this version, or file not readable.</em>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Objectives – KTP Digital</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="/assets/tailwind.min.css">
    <style>
      .markdown-body img { max-width: 100%; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,.15);}
      .markdown-body a img { border: 2px solid #3b82f6; }
    </style>
</head>
<body class="bg-white text-gray-900  ">
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">🎯 Objectives</h1>
    <form method="get" class="mb-6 flex items-center gap-4">
        <label for="version">Select version:</label>
        <select name="version" id="version" class="border px-2 py-1 rounded" onchange="this.form.submit()">
            <?php foreach ($objs as $ver => $f): ?>
                <option value="<?=htmlspecialchars($ver)?>" <?= $ver === $version ? "selected" : "" ?>>
                    <?=htmlspecialchars($ver)?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (file_exists($obj_file)): ?>
        <a href="?version=<?=urlencode($version)?>&download=1" 
           class="ml-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
           download="<?=htmlspecialchars($version)?>_objectives.md">
            📥 Download Markdown
        </a>
        <?php endif; ?>
    </form>
    <div class="bg-white  rounded-xl p-6 shadow mt-4 markdown-body">
        <?=$html?>
    </div>
</div>
</body>
</html>
