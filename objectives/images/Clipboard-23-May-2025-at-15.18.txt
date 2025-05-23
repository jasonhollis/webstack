<?php
session_start();
define('ADMIN_USER', 'admin');
define('ADMIN_PASS_HASH', '$2y$10$K3xIfyU0kam7WoEl2Q.IPOs9sWsimDkz.4OwDgS367EgnWcDj65P2');

// Handle login POST
if (isset($_POST['admin_user'], $_POST['admin_pass'])) {
    if (
        $_POST['admin_user'] === ADMIN_USER &&
        password_verify($_POST['admin_pass'], ADMIN_PASS_HASH)
    ) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ' . ($_GET['redirect'] ?? $_SERVER['PHP_SELF']));
        exit;
    }
    $login_error = "Incorrect username or password.";
}

// If not logged in, show login form and halt
if (empty($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Admin Login – KTP Digital</title>
      <meta name="viewport" content="width=device-width,initial-scale=1.0">
      <link rel="stylesheet" href="/assets/tailwind.min.css">
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white flex items-center justify-center min-h-screen">
      <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg max-w-xs w-full">
        <h1 class="text-2xl font-bold mb-6">🔐 Admin Login</h1>
        <?php if (!empty($login_error)): ?>
          <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-4"><?=htmlspecialchars($login_error)?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
          <label class="block mb-3">
            <span class="text-sm font-medium">Username</span>
            <input type="text" name="admin_user" class="mt-1 w-full px-3 py-2 rounded border focus:outline-none focus:ring" autofocus required>
          </label>
          <label class="block mb-6">
            <span class="text-sm font-medium">Password</span>
            <input type="password" name="admin_pass" class="mt-1 w-full px-3 py-2 rounded border focus:outline-none focus:ring" required>
          </label>
          <button class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition" type="submit">Login</button>
        </form>
      </div>
    </body>
    </html>
    <?php
    exit;
}

// ---- AUTHENTICATED: RENDER PAGE ----
include 'admin_nav.php';

require_once __DIR__ . '/Parsedown.php'; // Make sure Parsedown.php is present

$objectives_dir = '/opt/webstack/objectives';
$images_url = '/admin/objectives/images/';
$version_file = '/opt/webstack/html/VERSION';

$version = isset($_GET['version']) ? basename($_GET['version']) : trim(@file_get_contents($version_file));
$log_file = "$objectives_dir/{$version}_iteration_log.md";

// Find all iteration logs for dropdown
$logs = [];
foreach (glob("$objectives_dir/*_iteration_log.md") as $f) {
    $ver = basename($f, '_iteration_log.md');
    $logs[$ver] = $f;
}
krsort($logs);

$content = @file_get_contents($log_file);

$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true); // Protect against HTML/PHP execution

$html = $Parsedown->text($content);

// Make images clickable if they reference the images folder (extra safety for []() links)
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

// Enhance <pre><code> blocks with copy buttons
$html = preg_replace_callback(
    '#<pre><code( class="[^"]*")?>(.*?)</code></pre>#s',
    function ($m) {
        $lang = isset($m[1]) ? $m[1] : '';
        $code = $m[2];
        $copyBtn = '<button class="copy-btn absolute top-2 right-2 bg-gray-700 text-white rounded px-2 py-1 text-xs opacity-75 hover:opacity-100" title="Copy to clipboard">Copy</button>';
        // Wrap in a relative container so button positions properly
        return '<div class="relative group">' . $copyBtn . '<pre><code' . $lang . '>' . $code . '</code></pre></div>';
    },
    $html
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Iteration Log – KTP Digital</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="/assets/tailwind.min.css">
    <style>
      .markdown-body img { max-width: 100%; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,.15);}
      .markdown-body a img { border: 2px solid #3b82f6; }
      .copy-btn { display: none; }
      .group:hover .copy-btn,
      .group:focus-within .copy-btn { display: block; }
      pre { padding-top: 2rem !important; }
    </style>
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">📝 Iteration Log</h1>
    <form method="get" class="mb-6 flex items-center gap-4">
        <label for="version">Select version:</label>
        <select name="version" id="version" class="border px-2 py-1 rounded" onchange="this.form.submit()">
            <?php foreach ($logs as $ver => $f): ?>
                <option value="<?=htmlspecialchars($ver)?>" <?= $ver === $version ? "selected" : "" ?>>
                    <?=htmlspecialchars($ver)?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow mt-4 markdown-body">
        <?=$html?>
    </div>
</div>
<script>
  // Copy button handler
  document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const code = btn.parentElement.querySelector('code');
      // Decode HTML entities for copy
      const textarea = document.createElement('textarea');
      textarea.value = code.innerText;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      textarea.remove();
      btn.textContent = 'Copied!';
      setTimeout(() => btn.textContent = 'Copy', 1200);
    });
  });
</script>
</body>
</html>
