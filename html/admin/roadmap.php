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
    <body class="bg-gray-100  text-gray-900  flex items-center justify-center min-h-screen">
      <div class="bg-white  p-8 rounded-2xl shadow-lg max-w-xs w-full">
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
$page = 'roadmap';
require_once __DIR__ . '/admin_nav.php';

require_once __DIR__ . '/Parsedown.php';
$roadmap_path = '/opt/webstack/objectives/roadmap.md';

$content = is_readable($roadmap_path)
    ? file_get_contents($roadmap_path)
    : "# Roadmap\n\n_Roadmap file not found. Create `/opt/webstack/objectives/roadmap.md` to get started._";

$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

$html = $Parsedown->text($content);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Roadmap – KTP Webstack</title>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
</head>
<body class="bg-white  text-gray-900 ">
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">🛣️ Roadmap</h1>
    <div class="bg-white  rounded-xl p-6 shadow mt-4 markdown-body">
      <?=$html?>
    </div>
  </div>
</body>
</html>
