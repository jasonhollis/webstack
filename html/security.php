<?php
require 'layout.php';

$page_title = "Security & Ransomware | KTP Digital";
$page_desc = "Worried about cyberattacks, ransomware, phishing, or compliance? Get expert protection, recovery, and ongoing security support from KTP Digital. Symantec, Microsoft, Cisco, Yubico, Broadcom (CA), multi-factor authentication, privileged access, and more.";

$meta = <<<HTML
<meta name="description" content="Cybersecurity, ransomware recovery, compliance, and protection for home, business, and enterprise. Experts in Symantec, Microsoft, Cisco, Yubico, Broadcom (CA), multi-factor authentication, endpoint security, privileged user management, and more. Serving all of Australia." />
<meta name="keywords" content="cybersecurity, security, ransomware, endpoint security, privileged access, multifactor authentication, phishing, threat protection, compliance, incident response, Symantec, Microsoft, Cisco, Yubico, Broadcom, CA Technologies, identity management, Office 365 Security, API security, network security, vulnerability, risk, security operations, data protection, disaster recovery, managed services, zero trust, NIST, Essential Eight, APRA, Australia, IT security" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Security & Ransomware | KTP Digital" />
<meta property="og:description" content="Worried about cyberattacks or ransomware? We deliver advanced protection, incident response, and compliance for business and enterprise. Symantec, Cisco, Microsoft, and more." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/security.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/security-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Security & Ransomware | KTP Digital" />
<meta name="twitter:description" content="Get advanced cybersecurity, ransomware protection, and compliance solutions for home, business, and enterprise. Symantec, Cisco, Microsoft, and more." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/security-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Security & Ransomware</h1>
  </div>
  
  <p class="text-lg mb-6">
    From ransomware recovery to advanced threat prevention, we help you lock down your IT and protect your data. Cybersecurity for home, business, and enterprise—made simple.
  </p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Secure My Business</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">How We Protect You</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Symantec Endpoint Security -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/symantec.svg" class="w-10 h-10 mb-2" alt="Symantec" />
        <div class="font-bold">Symantec Endpoint Security</div>
        <div class="text-xs opacity-80 mt-1">Ransomware defense, endpoint protection, threat detection</div>
      </div>
      <!-- Microsoft Defender/Office 365 Security -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/microsoft.svg" class="w-10 h-10 mb-2" alt="Microsoft" />
        <div class="font-bold">Microsoft 365 & Defender</div>
        <div class="text-xs opacity-80 mt-1">Email security, compliance, and identity management</div>
      </div>
      <!-- Yubico / MFA -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/yubico.svg" class="w-10 h-10 mb-2" alt="Yubico" />
        <div class="font-bold">Multi-Factor Authentication</div>
        <div class="text-xs opacity-80 mt-1">YubiKey and Broadcom (CA) for secure access</div>
      </div>
      <!-- Privileged Access Management -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 17v1a3 3 0 0 0 6 0v-1" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Privileged Access Management</div>
        <div class="text-xs opacity-80 mt-1">Protect admin/root access for servers, cloud, and apps</div>
      </div>
      <!-- NextDNS/Content Filtering -->
      <a href="/nextdns.php" class="bg-slate-800 hover:bg-blue-700 rounded-xl p-5 text-white flex flex-col items-center shadow transition">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">NextDNS Protection</div>
        <div class="text-xs opacity-80 mt-1">Content filtering, privacy, and zero-trust network security</div>
      </a>
      <!-- Identity & Access Governance (User Shield Icon) -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Z" stroke="#38bdf8" />
          <path d="M6 20v-1c0-2.21 1.79-4 4-4s4 1.79 4 4v1" stroke="#38bdf8" />
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#38bdf8" />
        </svg>
        <div class="font-bold">Identity & Access Governance</div>
        <div class="text-xs opacity-80 mt-1">Broadcom (CA), Azure AD, Okta—compliance & SSO</div>
      </div>
    </div>
  </div>

  <!-- Vendor/Experience Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Our Security Expertise Includes:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">Symantec</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Microsoft 365 & Defender</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Cisco Security</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Yubico/YubiKey</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Broadcom (CA)</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Okta</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Azure AD</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Fortinet</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Sophos</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Privileged User Management</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Multi-factor Authentication</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Identity Management</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Endpoint Security</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">API Security</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Zero Trust</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">NIST/Essential Eight</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">APRA Compliance</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Disaster Recovery</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Incident Response</span>
    </div>
  </div>

  <!-- Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure which solution fits you?</div>
    <a href="/contact.php" class="inline-block bg-gray-700 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">Talk to a human</a>
  </div>
</div>
HTML;

$canonical = "https://www.ktp.digital/security.php";
renderLayout($page_title, $content, $meta, $page_desc, $canonical);
?>
