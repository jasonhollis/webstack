<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';
$page_title = "NAS & Storage Solutions";
$page_desc  = "QNAP & Synology NAS setup, Time Machine, backup, on-premises storage, hybrid cloud, surveillance, and Docker services for Mac and business.";

// Inject meta tags via layout (if supported)
$meta = <<<HTML
  <meta name="description" content="$page_desc">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="$page_title">
  <meta property="og:description" content="$page_desc">
  <meta property="og:image" content="https://www.ktp.digital/images/nas/qnap-banner.jpg">
  <meta property="og:url" content="https://www.ktp.digital/nas.php">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="$page_title">
  <meta name="twitter:description" content="$page_desc">
  <meta name="twitter:image" content="https://www.ktp.digital/images/nas/qnap-banner.jpg">
HTML;

$content = <<<HTML
<div class="p-8 max-w-5xl mx-auto">
  <img src="images/nas/qnap-banner.jpg" alt="QNAP TS-h1290FX" class="rounded shadow mb-8 w-full max-h-96 object-contain">
  <h1 class="text-3xl font-bold mb-6">NAS & Storage Solutions</h1>
  <p class="text-lg leading-relaxed mb-6">
    We’ve been working with both <strong>QNAP</strong> and <strong>Synology</strong> systems since 2008, helping customers deploy robust, secure, and scalable on-premise storage solutions across mixed Mac and Windows environments.
  </p>
  <p class="text-md mb-6 text-blue-700 dark:text-blue-300">
    Many of our customers operate in regulated industries where cloud storage is either restricted, discouraged, or requires enhanced oversight. We provide trusted alternatives that keep data under your control — with compliance, resilience, and visibility in mind.
  </p>
  <h2 class="text-2xl font-semibold mt-10 mb-4">🖥 Designed for Apple & Creative Workflows</h2>
  <ul class="list-disc ml-6 mb-6">
    <li>Time Machine support for seamless Mac backups</li>
    <li>AFP & SMB for shared drives across Mac and PC</li>
    <li>Direct iCloud offload or sync-to-NAS strategies</li>
  </ul>
  <h2 class="text-2xl font-semibold mt-10 mb-4">🎥 Expand Storage for Surveillance</h2>
  <ul class="list-disc ml-6 mb-6">
    <li>Store video securely onsite for <a href="https://ui.com/camera-security" target="_blank" class="text-blue-600 dark:text-blue-400 underline">UniFi Protect</a></li>
    <li>RAID, SSD caching, hot-swappable expansion</li>
    <li>Integrates into Ubiquiti-based infrastructure</li>
  </ul>
  <h2 class="text-2xl font-semibold mt-10 mb-4">🗄 Centralized File Server</h2>
  <ul class="list-disc ml-6 mb-6">
    <li>Granular permissions and access control</li>
    <li>Secure sync and remote access without public cloud</li>
    <li>Automated backups to cloud or external disks</li>
  </ul>
  <h2 class="text-2xl font-semibold mt-10 mb-4">🔧 Docker & Proxy Services</h2>
  <ul class="list-disc ml-6 mb-6">
    <li>Full Docker support on QNAP NAS for custom containers and apps</li>
    <li>Reverse proxy configuration for clean public URLs</li>
    <li>Private services like Home Assistant, databases, analytics, and monitoring</li>
    <li><strong>Rapid deployment:</strong> We can spin up production-ready stacks in minutes</li>
  </ul>
  <h2 class="text-2xl font-semibold mt-10 mb-4">🔍 QNAP vs Synology</h2>
  <div class="overflow-x-auto mb-6">
    <table class="w-full text-left table-auto border border-gray-300 dark:border-gray-700 text-sm">
      <thead class="bg-gray-100 dark:bg-gray-800">
        <tr><th class="p-2">Feature</th><th class="p-2">QNAP</th><th class="p-2">Synology</th></tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-900">
        <tr class="border-t border-gray-300 dark:border-gray-700">
          <td class="p-2">Virtualization</td>
          <td class="p-2">✅ Native VM Manager</td>
          <td class="p-2">⚠️ Docker only</td>
        </tr>
        <tr class="border-t border-gray-300 dark:border-gray-700">
          <td class="p-2">Surveillance</td>
          <td class="p-2">✅ High camera limits</td>
          <td class="p-2">✅ Polished interface</td>
        </tr>
        <tr class="border-t border-gray-300 dark:border-gray-700">
          <td class="p-2">Mac Support</td>
          <td class="p-2">✅ Time Machine, AFP, SMB</td>
          <td class="p-2">✅ Time Machine, SMB</td>
        </tr>
        <tr class="border-t border-gray-300 dark:border-gray-700">
          <td class="p-2">Ease of Use</td>
          <td class="p-2">⚠️ Advanced users</td>
          <td class="p-2">✅ Beginner-friendly</td>
        </tr>
      </tbody>
    </table>
  </div>
  <p class="text-md mt-8 text-blue-600 dark:text-blue-300">
    🔗 Also see our <a href="mac.php" class="underline">Mac expertise</a>, <a href="smallbiz.php" class="underline">Small Business solutions</a>, and <a href="tailscale.php" class="underline">Tailscale networking</a>.
  </p>
</div>
HTML;

renderLayout($page_title, $content, $meta);
