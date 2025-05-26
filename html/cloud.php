<?php
require 'layout.php';

$page_title = "Cloud, Backup & NAS | KTP Digital";
$page_desc = "Protect your business or home with secure cloud, backup, and NAS solutions. Fast, reliable storage, backup, and disaster recovery—set up and supported by experts.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <img src="/images/icons/qnap.svg" class="w-12 h-12 mr-4 opacity-90" alt="Cloud, Backup & NAS" />
    <h1 class="text-3xl font-extrabold">Cloud, Backup &amp; NAS</h1>
  </div>
  <p class="text-lg mb-6">
    Safeguard your data with professional-grade cloud, on-site, and hybrid storage solutions. Whether you need backup, recovery, file sharing, or scalable NAS for business or home—we make it simple and secure.
  </p>
  <p class="mb-8">
    - Automated, encrypted cloud & local backups<br>
    - QNAP, Synology, and enterprise NAS deployment<br>
    - Disaster recovery and rapid restore<br>
    - Remote file access, sharing, and collaboration<br>
    - Ongoing monitoring and support from real people
  </p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Protect My Data</a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
