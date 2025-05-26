<?php
require 'layout.php';

$page_title = "Email & Microsoft 365 | KTP Digital";
$page_desc = "Email migrations, Microsoft 365 setup, advanced security, spam filtering, and ongoing support for business and home users. KTP Digital makes email just work.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m22 6-8.5 7a2 2 0 0 1-3 0L2 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Email & Microsoft 365</h1>
  </div>
  
<p class="text-lg mb-6">
  Migrate to Microsoft 365, get rid of spam, or secure your email—without the hassle. We handle migration, setup, support, and compliance for business and personal users.
</p>
<a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Fix My Email</a>

</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
