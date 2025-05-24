<?php
// roadmap.php: Admin Roadmap Page – KTP Webstack

include 'admin_auth.php';
include 'admin_nav.php';

$roadmap_path = '/opt/webstack/objectives/roadmap.md';

$content = is_readable($roadmap_path)
    ? file_get_contents($roadmap_path)
    : "# Roadmap\n\n_Roadmap file not found. Create `/opt/webstack/objectives/roadmap.md` to get started._";

if (!class_exists('Parsedown')) {
    require_once __DIR__ . '/Parsedown.php';
}
$Parsedown = new Parsedown();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Roadmap – KTP Webstack</title>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
  <?= $Parsedown->text($content) ?>
</body>
</html>
