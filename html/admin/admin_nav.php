<?php
// admin_nav.php: Admin navigation bar for KTP Webstack

$nav = [
    'Objectives'     => 'objectives.php',
    'Iteration Log'  => 'iteration_log.php',
    'Roadmap'        => 'roadmap.php',
    'Analytics'      => 'analytics.php',
    'Maintenance'    => 'maintenance.php',
    'Directives'     => 'directives.php',
    'Back to Site'   => '../index.php',
];
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="flex items-center justify-center gap-4 px-4 py-3 bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-base font-medium">
  <?php foreach ($nav as $label => $url): ?>
    <a href="<?= htmlspecialchars($url) ?>"
      class="px-3 py-1 rounded-xl transition-colors
        <?= ($current === $url) ? 'bg-blue-600 text-white shadow' : 'hover:bg-blue-100 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100' ?>">
      <?= htmlspecialchars($label) ?>
    </a>
  <?php endforeach; ?>
</nav>
<?php
// /opt/webstack/html/admin/admin_nav.php

if (!isset($page)) $page = '';
?>
<nav class="bg-white dark:bg-gray-900 shadow px-4 py-2 flex flex-wrap items-center justify-between">
  <div class="flex items-center space-x-4">
    <a href="/"
      title="Back to Site"
      class="flex items-center text-xl font-bold text-blue-700 dark:text-blue-300 hover:underline">
      <!-- Home/Back Icon (Heroicons outline) -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
      </svg>
      Back to Site
    </a>
    <ul class="flex space-x-4 ml-6">
      <li><a href="/admin/logs.php" class="<?= ($page=='logs') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">Iteration Log</a></li>
      <li><a href="/admin/objectives.php" class="<?= ($page=='objectives') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">Objectives Log</a></li>
      <li><a href="/admin/analytics.php" class="<?= ($page=='analytics') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">Analytics</a></li>
      <li><a href="/admin/maintenance.php" class="<?= ($page=='maintenance') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">Maintenance</a></li>
      <li><a href="/admin/file_stats.php" class="<?= ($page=='file_stats') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">File Stats</a></li>
      <li><a href="/admin/directives.php" class="<?= ($page=='directives') ? 'font-bold text-blue-600 underline' : 'hover:text-blue-600' ?>">AI Directives</a></li>
    </ul>
  </div>
  <div>
    <a href="/admin/logout.php" class="rounded font-bold bg-red-500 hover:bg-red-600 text-white px-4 py-2 transition">Logout</a>
  </div>
</nav>
