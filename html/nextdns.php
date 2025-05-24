<?php include __DIR__."/analytics_logger.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NextDNS – KTP Digital</title>
  <meta name="description" content="NextDNS filtering and privacy solutions by KTP Digital – secure DNS for home and business.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com/3.4.1"></script>
</head>
<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-white">
<?php include 'nav.php'; ?>
  <div class="max-w-5xl mx-auto p-6 pt-20">
    <h1 class="text-4xl font-bold mb-4">🛡️ NextDNS Protection</h1>
    <p class="mb-6 text-lg">
      NextDNS brings enterprise-grade content filtering, analytics, and security to your network with no hardware required.
    </p>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Real-Time Filtering</h2>
        <p>Block trackers, malware, ads, and adult content in real time at the DNS level.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Visibility & Logs</h2>
        <p>See which devices are making what queries – ideal for security, compliance, or parenting.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Per-Device Profiles</h2>
        <p>Apply different filtering rules to different users or devices with ease.</p>
      </div>
      <div class="p-4 border rounded-lg dark:border-gray-700 shadow">
        <h2 class="text-2xl font-semibold mb-2">Works Anywhere</h2>
        <p>Use it at home, at work, or on the go – compatible with any OS or router.</p>
      </div>
    </div>

    <a href="https://nextdns.io" target="_blank" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
      Visit nextdns.io →
    </a>
  </div>
  <footer class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
  </footer>
</body>
</html>
