<?php
require 'layout.php';

$page_title = "Small Business IT Solutions";
$page_desc = "Expert IT, networking, and automation solutions for small businesses—security, cloud, and ongoing support from KTP Digital.";

$content = <<<HTML
<h1 class="text-3xl font-bold mb-6">Small Business IT Solutions</h1>
<p class="mb-4">Running a small business doesn’t mean compromising on IT, security, or support. KTP Digital brings enterprise-level solutions and true white glove service to the SMB sector.</p>
<ul class="list-disc list-inside space-y-2 text-base text-gray-300 mb-6">
  <li>Network design, upgrades, and troubleshooting</li>
  <li>Cloud migrations, Office 365/Google Workspace</li>
  <li>Cybersecurity audits, compliance, and ongoing protection</li>
  <li>Automation—save time and money with integrated tools</li>
  <li>Disaster recovery, backup, and peace of mind</li>
  <li>Remote support and on-call assistance</li>
</ul>
<div class="mt-6">
  <a href="/contact.php" class="inline-block bg-green-600 hover:bg-green-800 text-white font-bold px-6 py-3 rounded shadow">Talk to Our Experts</a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
