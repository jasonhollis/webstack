<?php
require 'layout.php';

$page_title = "Mac & Windows Integration | KTP Digital";
$page_desc = "Seamlessly connect Macs, PCs, and mobile devices—sharing files, printers, email, and cloud services. KTP Digital makes everything just work.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="3" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 21h8M12 17v4" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Mac & Windows Integration</h1>
  </div>
  
<p class="text-lg mb-6">
  Need your Mac and PC systems to play nicely together? We’ll get your network, files, printers, and cloud services in sync, at home or in the office.
</p>
<ul class="list-disc ml-8 mb-6">
  <li>File, printer, and network sharing (cross-platform)</li>
  <li>Cloud service &amp; device integration (iCloud, OneDrive, Google, Dropbox)</li>
  <li>Shared calendars, contacts, and apps</li>
  <li>Email, remote access, and security setup</li>
  <li>On-site &amp; remote support for all users</li>
</ul>
<a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Make My Devices Work Together</a>

</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
