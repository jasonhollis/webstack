<?php
require 'layout.php';

$page_title = "Websites & Website Services | KTP Digital";
$page_desc = "Get a stunning, reliable website for your business or project. We design, build, host, and support websites with performance, SEO, and support included.";

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
      <line x1="2" y1="12" x2="22" y2="12" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M12 2a15.3 15.3 0 0 1 4 10c0 4-1.6 7.6-4 10-2.4-2.4-4-6-4-10 0-4 1.6-7.6 4-10z" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <h1 class="text-3xl font-extrabold">Websites & Website Services</h1>
  </div>
  <p class="text-lg mb-6">From a simple landing page to a complete, dynamic website—get it built, hosted, and supported by local experts. We handle:</p>
  <p class="mb-8">No jargon, no outsourcing—just direct, hands-on support. <a href="/contact.php" class="text-blue-700 underline hover:text-blue-900">Contact us</a> for a free review or a demo.</p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Request a Website Quote</a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
