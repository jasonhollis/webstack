<?php
require 'layout.php';

$page_title = "Security & Ransomware | KTP Digital";
$page_desc = "Worried about cyberattacks, ransomware, phishing, or compliance? Get expert protection, recovery, and ongoing security support from KTP Digital.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Security & Ransomware</h1>
  </div>
  
<p class="text-lg mb-6">
  From ransomware recovery to advanced threat prevention, we help you lock down your IT and protect your data. Cybersecurity for small business and enterprise—made simple.
</p>
<ul class="list-disc ml-8 mb-6">
  <li>Ransomware prevention, detection &amp; recovery</li>
  <li>Phishing, malware, and scam protection</li>
  <li>Firewall, endpoint, and multi-factor security</li>
  <li>Security awareness and compliance guidance</li>
  <li>24/7 monitoring, alerting, and incident response</li>
</ul>
<a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Secure My Business</a>

</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
