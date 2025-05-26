<?php
require 'layout.php';

$page_title = "Email & Microsoft 365 | KTP Digital";
$page_desc = "Email migrations, Microsoft 365 setup, advanced security, spam filtering, and ongoing support for business and home users. KTP Digital makes email just work.";

$meta = <<<HTML
<meta name="description" content="Email migrations, Microsoft 365 setup, spam filtering, advanced security, and ongoing support. KTP Digital migrates, protects, and manages email for business and home users across Australia." />
<meta name="keywords" content="email migration, Microsoft 365, Office 365, spam filtering, business email, secure email, email support, email setup, mail migration, email compliance, DKIM, SPF, DMARC, anti-phishing, ransomware protection, IT support, KTP Digital" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Email & Microsoft 365 | KTP Digital" />
<meta property="og:description" content="Email migrations, Microsoft 365 setup, spam filtering, and advanced security for business and home. We make email just work." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/email.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/email-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Email & Microsoft 365 | KTP Digital" />
<meta name="twitter:description" content="Migrate to Microsoft 365, block spam, and secure your business email—no hassle, full compliance, real support." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/email-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <img src="/images/icons/microsoft.svg" class="w-12 h-12 mr-4" alt="Microsoft 365" />
    <h1 class="text-3xl font-extrabold">Email & Microsoft 365</h1>
  </div>
  
  <p class="text-lg mb-6">
    Migrate to Microsoft 365, get rid of spam, or secure your email—without the hassle. We handle migration, setup, support, and compliance for business and personal users.
  </p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Fix My Email</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">How We Help with Email &amp; M365</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Microsoft 365 Migration -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/microsoft.svg" class="w-10 h-10 mb-2" alt="Microsoft 365" />
        <div class="font-bold">Microsoft 365 Migration</div>
        <div class="text-xs opacity-80 mt-1">Zero-downtime migrations from Gmail, Exchange, IMAP, and more</div>
      </div>
      <!-- Spam Filtering & Security -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#facc15" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m22 6-8.5 7a2 2 0 0 1-3 0L2 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Spam Filtering & Security</div>
        <div class="text-xs opacity-80 mt-1">Stop spam, phishing, and ransomware before they hit your inbox</div>
      </div>
      <!-- Compliance & Continuity -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="10" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 12h10" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Compliance & Continuity</div>
        <div class="text-xs opacity-80 mt-1">Archiving, eDiscovery, backup, and regulatory compliance (DKIM, SPF, DMARC)</div>
      </div>
      <!-- Ongoing Support -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
        <div class="font-bold">Ongoing Support</div>
        <div class="text-xs opacity-80 mt-1">Local, real-human support—troubleshooting, admin, and upgrades</div>
      </div>
      <!-- Device & App Setup -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="14" x="3" y="5" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 21h8M12 17v4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Device &amp; App Setup</div>
        <div class="text-xs opacity-80 mt-1">We set up Macs, PCs, phones, and Outlook apps so email just works</div>
      </div>
      <!-- Google Workspace & Other Platforms -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#ea4335" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m22 6-8.5 7a2 2 0 0 1-3 0L2 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Google Workspace &amp; More</div>
        <div class="text-xs opacity-80 mt-1">Expert migrations and support for Google, Exchange, IMAP, and legacy systems</div>
      </div>
    </div>
  </div>

  <!-- Expertise Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Email &amp; Collaboration Experience:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">Microsoft 365 / Office 365</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Exchange Online</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Google Workspace</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Spam Filtering</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Anti-Phishing</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">DKIM, SPF, DMARC</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Compliance Archiving</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">eDiscovery</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Multi-device Setup</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Mac, Windows, iOS, Android</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Admin Support</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Migration Planning</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Zero-Downtime Cutovers</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Ransomware Protection</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Personalised Support</span>
    </div>
  </div>

  <!-- Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure what's right for your business or home? We'll make email just work for you.</div>
    <a href="/contact.php" class="inline-block bg-gray-700 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">Talk to an email expert</a>
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
?>
