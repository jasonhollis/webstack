<?php include __DIR__."/analytics_logger.php"; ?>
<?php include("nav.php"); ?>
<div class="pt-24 sm:pt-20"></div>
<?php
  $version = trim(file_get_contents('/opt/webstack/html/VERSION'));
  $bg = "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1600&q=80";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="https://cdn.tailwindcss.com/3.4.1"></script>
  <title>KTP Digital | Smarter IT</title>
  <style>
    body {
      background-image: url('<?= $bg ?>');
      background-size: cover;
      background-position: center;
    }
    .backdrop {
      background-color: rgba(0, 0, 0, 0.65);
    }
  </style>
</head>
<body class="min-h-screen text-white block sm:flex sm:items-center sm:justify-center px-4 py-10">
<?php include 'nav.php'; ?>
  <div class="backdrop w-full sm:max-w-3xl p-6 sm:p-8 rounded-xl shadow-lg text-center space-y-6 pt-20">
    <h1 class="text-3xl sm:text-4xl font-bold">Smarter Infrastructure. Safer Systems. Automated Living.</h1>
    <p class="text-base sm:text-lg text-gray-300">
      IT consulting from <strong>Jason Hollis</strong> — trusted by enterprises, small businesses, and home automation power users.
    </p>
    
    <div class="grid gap-6 sm:grid-cols-2 text-left text-gray-200 mt-6 text-sm">
      <div>
        <h2 class="text-lg font-semibold text-green-400 mb-2">Enterprise Consulting</h2>
        <ul class="list-disc list-inside space-y-1">
          <li>Zero Trust & Identity Architecture</li>
          <li>API Security & Governance</li>
          <li>Office365, Endpoint & Compliance</li>
        </ul>
      </div>
      <div>
        <h2 class="text-lg font-semibold text-blue-400 mb-2">Small Business IT</h2>
        <ul class="list-disc list-inside space-y-1">
          <li>Secure Networks & Wi-Fi</li>
          <li>Cloud, Backup & Recovery</li>
          <li>Microsoft 365 / Google Workspace</li>
        </ul>
      </div>
      <div>
        <h2 class="text-lg font-semibold text-purple-400 mb-2">Home Automation</h2>
        <ul class="list-disc list-inside space-y-1">
          <li>Home Assistant configuration</li>
          <li>Zigbee / Z-Wave / Thread / Matter</li>
          <li>Firewalling & smart home security</li>
        </ul>
      </div>
      <div>
        <h2 class="text-lg font-semibold text-yellow-400 mb-2">Why Jason?</h2>
        <ul class="list-disc list-inside space-y-1">
          <li>35+ years in global IT leadership</li>
          <li>Trusted by banks, telcos & startups</li>
          <li>Real references. Real results.</li>
        </ul>
      </div>
    </div>

    <div class="mt-6 text-sm text-gray-400">
      <p><strong>Current Version:</strong> <span class="font-mono text-green-300"><?= htmlspecialchars($version) ?></span></p>
      <p class="text-xs mt-1">Last updated: <?= date('Y-m-d H:i:s') ?></p>
    </div>

    <div class="mt-4">
      <a href="mailto:jason@jasonhollis.com" class="inline-block bg-green-500 hover:bg-green-600 text-white px-5 py-2 sm:px-6 sm:py-3 rounded-lg text-sm font-semibold shadow">
        Contact Jason
      </a>
    </div>
  </div>
  <footer class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
  </footer>
</body>
</html>
