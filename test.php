<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Webstack Test Environment</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
  <div class="p-6 text-center">
    <h1 class="text-3xl font-bold mb-4">Webstack Test Environment</h1>
    <p class="text-xl font-mono text-green-600">
      <?= trim(file_get_contents("VERSION")) ?>
    </p>
  </div>
</body>
</html>
