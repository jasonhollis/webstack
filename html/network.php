<?php
require 'layout.php';

$page_title = "Network & WiFi Problems | KTP Digital";
$page_desc = "Solve your network and WiFi headaches: slow speeds, dropouts, weak coverage, or insecure connections. KTP Digital can fix it all—fast.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9A16 16 0 0 1 22.58 9M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Network & WiFi Problems</h1>
  </div>
  
<p class="text-lg mb-6">
  Slow speeds? Unreliable or weak WiFi? We deliver expert diagnosis, enterprise-grade solutions, and ongoing support for businesses and homes. Wired or wireless—your network, fixed.
</p>
<ul class="list-disc ml-8 mb-6">
  <li>WiFi coverage mapping, troubleshooting &amp; upgrades</li>
  <li>Business, home, and multi-site networking</li>
  <li>Guest networks, VLANs, parental controls, and security</li>
  <li>Enterprise UniFi, Ubiquiti, and mesh deployments</li>
  <li>On-site and remote support, guaranteed results</li>
</ul>
<a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Get Your Network Fixed</a>

</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
