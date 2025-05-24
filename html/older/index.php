<?php
$version = trim(file_get_contents('/opt/webstack/VERSION'));
$backgrounds = [
  "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80", // scuba
  "https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80", // mountain
  "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80"  // night sky
];
$bg = $backgrounds[array_rand($backgrounds)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jason Hollis | IT Consulting & Automation</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
<body class="min-h-screen text-white flex items-center justify-center px-4">
  <div class="backdrop max-w-3xl p-8 rounded-xl shadow-lg text-center space-y-6">
    <h1 class="text-4xl font-bold">Smarter Infrastructure. Safer Systems. Automated Living.</h1>
    <p class="text-lg text-gray-300">IT consulting from <strong>Jason Hollis</strong> — trusted by enterprises, small businesses, and home automation power users.</p>
    
    <div class="grid gap-6 sm:grid-cols-2 text-left text-gray-200 mt-6">
      <div>
        <h2 class="text-xl font-semibold text-green-400 mb-2">Enterprise Consulting</h2>
        <ul class="list-disc list-inside text-sm space-y-1">
          <li>Zero Trust & Identity Architecture</li>
          <li>API Security & Governance</li>
          <li>Office365, Endpoint & Compliance</li>
        </ul>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-blue-400 mb-2">Small Business IT</h2>
        <ul class="list-disc list-inside text-sm space-y-1">
          <li>Secure Networks & Wi-Fi</li>
          <li>Cloud, Backup & Recovery</li>
          <li>Microsoft 365 / Google Workspace</li>
        </ul>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-purple-400 mb-2">Home Automation</h2>
        <ul class="list-disc list-inside text-sm space-y-1">
          <li>Home Assistant configuration</li>
          <li>Zigbee / Z-Wave / Thread / Matter</li>
          <li>Firewalling & smart home security</li>
        </ul>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-yellow-400 mb-2">Why Jason?</h2>
        <ul class="list-disc list-inside text-sm space-y-1">
          <li>35+ years in global IT leadership</li>
          <li>Trusted by banks, telcos & startups</li>
          <li>Real references. Real results.</li>
        </ul>
      </div>
    </div>

    <div class="mt-8 text-sm text-gray-400">
      <p><strong>Current Version:</strong> <span class="font-mono text-green-300"><?= htmlspecialchars($version) ?></span></p>
      <p class="text-xs mt-1">Last updated: <?= date('Y-m-d H:i:s') ?></p>
    </div>

    <div class="mt-6">
      <a href="mailto:jason@jasonhollis.com" class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow">
        Contact Jason
      </a>
    </div>
  </div>
</body>
</html>
