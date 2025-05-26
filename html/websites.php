<?php
require 'layout.php';

$page_title = "Websites & Website Services | KTP Digital";
$page_desc = "Get a stunning, reliable website for your business or project. KTP Digital designs, builds, hosts, and supports modern, fast websites—with performance, SEO, integration, and local support included.";
$canonical = "https://www.ktp.digital/websites.php";
$og_image = "/images/icons/websites-white.svg";
$meta = <<<HTML
<meta name="description" content="Stunning business websites—design, build, hosting, SEO, integrations, and support. Local, jargon-free service. Request a quote from KTP Digital." />
<meta property="og:title" content="Websites & Website Services | KTP Digital" />
<meta property="og:description" content="Websites built and managed by KTP Digital—fast, secure, SEO-optimized, locally supported. Free review or demo. Request a quote today." />
<meta property="og:image" content="/images/icons/websites-white.svg" />
<link rel="canonical" href="https://www.ktp.digital/websites.php" />
HTML;

$content = <<<HTML
<div class="max-w-4xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <img src="/images/icons/websites-white.svg" alt="Websites" class="w-12 h-12 mr-4">
    <h1 class="text-3xl md:text-4xl font-extrabold">Websites & Website Services</h1>
  </div>
  <p class="text-lg mb-4">
    Your website is your digital front door. Whether you need a simple landing page or a complex, dynamic site—KTP Digital builds, hosts, and supports websites that are <strong>fast, secure, beautiful, and easy to manage</strong>.
  </p>
  <ul class="grid md:grid-cols-2 gap-5 mb-8 text-base">
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <svg class="h-7 w-7 text-blue-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M4 7V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2" />
        <rect x="2" y="7" width="20" height="14" rx="2" />
        <path d="M16 21v2a2 2 0 0 1-4 0v-2" />
      </svg>
      <div>
        <span class="font-bold">Website Design & Build</span><br>
        Modern, mobile-first designs—built to match your brand and make an impression.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <svg class="h-7 w-7 text-green-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M3 6v6a9 9 0 0 0 9 9 9 9 0 0 0 9-9V6" />
        <path d="M9 9l3 3 3-3" />
      </svg>
      <div>
        <span class="font-bold">Australian Hosting & Security</span><br>
        Lightning-fast local hosting, SSL, malware protection, and backups—handled by us.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <svg class="h-7 w-7 text-yellow-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 16v-4m0 0V8m0 4h4m-4 0H8"/>
      </svg>
      <div>
        <span class="font-bold">SEO & Performance</span><br>
        Optimised for Google, mobile, and speed. Get found—and stay fast.
      </div>
    </li>
    <li class="bg-slate-900/90 p-5 rounded-xl flex items-start">
      <svg class="h-7 w-7 text-purple-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <rect x="3" y="7" width="18" height="13" rx="2"/>
        <path d="M8 3h8v4H8z"/>
      </svg>
      <div>
        <span class="font-bold">Support, Changes & Integration</span><br>
        Local support—real people, no jargon. Need a change, blog, booking, or integration? Just ask.
      </div>
    </li>
  </ul>
  <div class="bg-slate-800/90 p-5 md:p-7 rounded-lg mb-6">
    <div class="font-bold mb-1 text-red-400">
      Windows 10 End-of-Life: Is your site ready for 2025?
    </div>
    <div>
      Many businesses are modernising their web presence as they upgrade their devices. If you're moving off Windows 10, it's the perfect time to refresh your site, improve security, and update your business online. <a href="/windows.php" class="text-blue-400 underline hover:text-blue-600">See Windows migration help</a>
    </div>
  </div>
  <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
    <a href="/contact.php" class="bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition">Request a Website Quote</a>
    <a href="/about.php" class="text-blue-600 hover:underline text-lg font-semibold">Why KTP Digital?</a>
  </div>
  <div class="mt-8 text-base text-slate-400">
    <strong>No jargon, no outsourcing</strong>—just direct, hands-on local support. <a href="/contact.php" class="text-blue-400 underline hover:text-blue-600">Contact us</a> for a free review or demo.
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc, $canonical, $og_image);
