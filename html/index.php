<?php
require 'layout.php';

$page_title = "KTP Digital | White Glove IT Solutions";
$page_desc = "KTP Digital delivers white glove IT consulting, automation, disaster recovery, and secure networking for enterprises, SMBs, and homes across Australia.";

$content = <<<HTML
<h1 class="text-4xl font-bold mb-4">Welcome to KTP Digital</h1>
<p class="text-lg mb-8">White glove IT, automation, disaster recovery, and secure networking solutions—crafted for enterprise, SMB, and home users.</p>

<div class="mt-12 mb-8 text-center">
  <h2 class="text-2xl font-bold mb-4 text-white">What Are You Trying to Fix?</h2>
  <!-- Top Row: 4 cards -->
  <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-4 justify-center">
    <!-- 1: Network & WiFi Problems (Lucide: wifi) -->
    <a href="/network.php" class="bg-slate-900/80 hover:bg-blue-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center">
      <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9A16 16 0 0 1 22.58 9M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <div class="font-semibold mb-1">Network & WiFi Problems</div>
      <div class="text-xs opacity-80">Slow, unreliable, or insecure network?</div>
    </a>
    <!-- 2: Security & Ransomware (Lucide: shield) -->
    <a href="/security.php" class="bg-slate-900/80 hover:bg-red-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center">
      <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <div class="font-semibold mb-1">Security & Ransomware</div>
      <div class="text-xs opacity-80">Worried about cyberattacks, ransomware, or phishing?</div>
    </a>
    <!-- 3: Email & Microsoft 365 (Lucide: mail) -->
    <a href="/email.php" class="bg-slate-900/80 hover:bg-green-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center">
      <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m22 6-8.5 7a2 2 0 0 1-3 0L2 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <div class="font-semibold mb-1">Email & Microsoft 365</div>
      <div class="text-xs opacity-80">Migration, security, or ongoing support.</div>
    </a>
    <!-- 4: Mac & Windows Integration (Lucide: monitor) -->
    <a href="/integration.php" class="bg-slate-900/80 hover:bg-purple-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center">
      <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="3" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 21h8M12 17v4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <div class="font-semibold mb-1">Mac & Windows Integration</div>
      <div class="text-xs opacity-80">Get Macs and PCs working seamlessly together.</div>
    </a>
  </div>

  <!-- Middle Row: 3 cards, centered -->
  <div class="flex justify-center gap-x-8 mt-8">
    <!-- 5: Cloud, Backup & NAS (QNAP official SVG) -->
    <a href="/cloud.php" class="bg-slate-900/80 hover:bg-cyan-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center w-72">
      <img src="/images/icons/qnap-white-forcedwhite.svg" class="w-12 h-12 mb-2 opacity-90" alt="Cloud, Backup & NAS" />
      <div class="font-semibold mb-1">Cloud, Backup & NAS</div>
      <div class="text-xs opacity-80">Storage, backup, and recovery for peace of mind.</div>
    </a>
    <!-- 6: Smart Home & Office (Home Assistant SVG) -->
    <a href="/automation.php" class="bg-slate-900/80 hover:bg-yellow-600 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center w-72">
      <img src="/images/icons/home-assistant.svg" class="w-12 h-12 mb-2 opacity-90" alt="Smart Home & Office" />
      <div class="font-semibold mb-1">Smart Home & Office</div>
      <div class="text-xs opacity-80">Home Assistant, IoT, and custom automation.</div>
    </a>
    <!-- 7: Disaster Recovery (Lucide: rotate-ccw) -->
    <a href="/disaster-recovery.php" class="bg-slate-900/80 hover:bg-orange-500 transition rounded-xl p-5 text-white shadow text-center flex flex-col items-center w-72">
      <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 2v6h-6M3 12a9 9 0 1 0 9-9" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <div class="font-semibold mb-1">Disaster Recovery</div>
      <div class="text-xs opacity-80">Proven solutions for when everything goes wrong.</div>
    </a>
  </div>
</div>

<!-- Centered last row: Small Business, Enterprise, Websites -->
<div class="flex justify-center gap-x-8 mt-12 mb-8">
  <!-- Small Business (Apple SVG) -->
  <a href="/smallbiz.php" class="bg-slate-900/80 hover:bg-blue-600 transition rounded-xl p-6 shadow text-center flex flex-col items-center no-underline text-white w-64">
    <img src="/images/icons/briefcase-white.svg" class="w-12 h-12 mb-2 opacity-90" alt="Small Business" />
    <div class="font-bold mb-1">Small Business</div>
    <div class="text-xs opacity-80">IT, cloud, security, and automation for SMBs.</div>
  </a>
  <!-- Enterprise (Ubiquiti SVG) -->
  <a href="/enterprise.php" class="bg-slate-900/80 hover:bg-blue-600 transition rounded-xl p-6 shadow text-center flex flex-col items-center no-underline text-white w-64">
    <svg class="w-12 h-12 mb-2 opacity-90" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="7" r="3" fill="#89B4FA" stroke="#fff" stroke-width="2"/><circle cx="8" cy="25" r="3" fill="#fff" stroke="#fff" stroke-width="2"/><circle cx="24" cy="25" r="3" fill="#fff" stroke="#fff" stroke-width="2"/><path d="M16 10V16M16 16L8 22M16 16L24 22" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
    <div class="font-bold mb-1">Enterprise</div>
    <div class="text-xs opacity-80">Strategy, compliance, cloud, and large-scale integration.</div>
  </a>
  <!-- Websites (Lucide: globe) -->
  <a href="/websites.php" class="bg-slate-900/80 hover:bg-blue-600 transition rounded-xl p-6 shadow text-center flex flex-col items-center no-underline text-white w-64">
    <svg class="w-12 h-12 mb-2 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
      <line x1="2" y1="12" x2="22" y2="12" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M12 2a15.3 15.3 0 0 1 4 10c0 4-1.6 7.6-4 10-2.4-2.4-4-6-4-10 0-4 1.6-7.6 4-10z" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <div class="font-bold mb-1">Websites</div>
    <div class="text-xs opacity-80">Professional website design, development, hosting, and support for your business or project.</div>
  </a>
</div>

<div class="mt-8">
  <a href="/contact.php" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold px-6 py-3 rounded shadow">Contact Us Today</a>
</div>
HTML;

renderLayout($page_title, $content, '', $page_desc);
