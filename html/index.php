<?php
require 'layout.php';

$page_title = "KTP Digital | White Glove IT Solutions";
$page_desc = "KTP Digital delivers white glove IT consulting, automation, and secure networking for enterprises, SMBs, and homes across Australia.";

$content = <<<HTML
<h1 class="text-4xl font-bold mb-4">Welcome to KTP Digital</h1>
<p class="text-lg mb-8">White glove IT, automation, and secure networking solutions—crafted for enterprise, SMB, and home users.</p>
<div class="grid gap-8 sm:grid-cols-2 text-left text-gray-200 text-base">
  <div>
    <h2 class="text-xl font-semibold text-blue-300 mb-2">Why KTP?</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>Decades of real-world expertise in IT, networking, and cybersecurity</li>
      <li>Personal, transparent, and truly white glove service</li>
      <li>Solutions for business and home—no job too complex</li>
      <li>Automation, cloud, networking, and security done right</li>
    </ul>
  </div>
  <div>
    <h2 class="text-xl font-semibold text-green-400 mb-2">Our Approach</h2>
    <ul class="list-disc list-inside space-y-1">
      <li>Consultative, no-BS advice and design</li>
      <li>Enterprise-grade automation and integration</li>
      <li>Hands-on support—deployments, migrations, and rescue jobs</li>
      <li>Security, privacy, and data protection at the core</li>
    </ul>
  </div>
</div>
<div class="mt-8">
  <a href="/contact.php" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold px-6 py-3 rounded shadow">Contact Us Today</a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
