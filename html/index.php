<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "KTP Digital | Smarter IT";

$content = <<<HTML
<h1 class="text-3xl sm:text-4xl font-bold">Smarter Infrastructure. Safer Systems. Automated Living.</h1>
<p class="text-base sm:text-lg text-gray-300">
  <strong>KTP Digital</strong> delivers white glove IT consulting, automation, and secure networking—trusted by enterprises, small businesses, and home automation power users.<br>
  Experience truly personal, tailored, and expert service—every step of the way.
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
    <h2 class="text-lg font-semibold text-yellow-400 mb-2">Why KTP Digital?</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>35+ years in global IT leadership</li>
      <li>Trusted by banks, telcos & startups</li>
      <li>Real references. Real results.</li>
      <li>White glove service for every client</li>
    </ul>
  </div>
</div>

<div class="mt-4">
  <a href="mailto:info@ktp.digital" class="inline-block bg-green-500 hover:bg-green-600 text-white px-5 py-2 sm:px-6 sm:py-3 rounded-lg text-sm font-semibold shadow">
    Contact Our Team
  </a>
</div>
HTML;

renderLayout($page_title, $content);
