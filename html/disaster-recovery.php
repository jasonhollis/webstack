<?php
require 'layout.php';

$page_title = "Disaster Recovery & Rapid Restore | KTP Digital";
$page_desc = "Disaster recovery solutions for business and home. Instant restore, ransomware recovery, secure backups, and true business continuity—on-prem, hybrid, and cloud. Get protected now.";

$meta = <<<HTML
<meta name="description" content="Disaster recovery, ransomware recovery, and business continuity for SMB and enterprise. Instant restore, secure cloud and on-prem backups, rapid response, and compliance. QNAP, Synology, Azure, AWS, and more." />
<meta name="keywords" content="disaster recovery, ransomware recovery, business continuity, rapid restore, cloud backup, QNAP, Synology, Azure, AWS, hybrid storage, encrypted backup, cross-site sync, instant restore, failover, IT resilience, SMB, enterprise, KTP Digital, backup strategy, data protection, compliance, incident response" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Disaster Recovery & Rapid Restore | KTP Digital" />
<meta property="og:description" content="Disaster recovery, ransomware protection, and instant restore for business and home. Secure cloud, hybrid, and on-prem solutions—QNAP, Synology, Azure, AWS." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/disaster-recovery.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/disaster-recovery-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Disaster Recovery & Rapid Restore | KTP Digital" />
<meta name="twitter:description" content="Ransomware recovery, disaster recovery, instant restore, and business continuity for SMB and enterprise. Secure, automated, and fully managed." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/disaster-recovery-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 2v6h-6M3 12a9 9 0 1 0 9-9" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Disaster Recovery &amp; Rapid Restore</h1>
  </div>
  <p class="text-lg mb-4">
    When disaster strikes—ransomware, server failure, flood, fire, or user error—your business can’t afford downtime.
    <span class="block mt-2">KTP Digital delivers instant restore, full ransomware recovery, and business continuity for SMB and enterprise—cloud, on-prem, or hybrid.</span>
  </p>
  <div class="flex flex-wrap gap-3 justify-center mb-8">
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Instant Restore</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Ransomware Recovery</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Business Continuity</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Automated Backups</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Multi-Site Sync</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Compliance Ready</span>
  </div>
  <a href="/contact.php" class="inline-block bg-orange-500 hover:bg-orange-700 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Protect My Business</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">Disaster Recovery &amp; Continuity Solutions</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Instant Restore -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#22d3ee" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 17v1a3 3 0 0 0 8 0v-1" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Instant Restore</div>
        <div class="text-xs opacity-80 mt-1">Recover files, servers, or entire sites in minutes—not days</div>
      </div>
      <!-- Ransomware Recovery -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#f43f5e" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Ransomware Recovery</div>
        <div class="text-xs opacity-80 mt-1">Clean recovery from ransomware and cyberattack, every time</div>
      </div>
      <!-- Multi-Site Sync & Offsite Backup -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#facc15" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M8 12h8M12 8v8" /></svg>
        <div class="font-bold">Multi-Site Sync &amp; Offsite Backup</div>
        <div class="text-xs opacity-80 mt-1">Backup to local, cloud, and cross-site storage for total resilience</div>
      </div>
      <!-- Cloud & Hybrid Continuity -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="16" cy="16" rx="14" ry="10" fill="#0891b2"/><path d="M10 16h12" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        <div class="font-bold">Cloud &amp; Hybrid Continuity</div>
        <div class="text-xs opacity-80 mt-1">Azure, AWS, QNAP, Synology—cloud and on-prem DR</div>
      </div>
      <!-- Compliance & Testing -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 17v1a3 3 0 0 0 8 0v-1" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Compliance &amp; Testing</div>
        <div class="text-xs opacity-80 mt-1">Regular testing, audits, and full compliance documentation</div>
      </div>
      <!-- Full Service & Monitoring -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/qnap-white-forcedwhite.svg" class="w-10 h-10 mb-2" alt="QNAP DR" />
        <div class="font-bold">Full Service &amp; Monitoring</div>
        <div class="text-xs opacity-80 mt-1">Managed DR plans, 24/7 monitoring, and human support</div>
      </div>
    </div>
  </div>

  <!-- Expertise Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Disaster Recovery &amp; Continuity Expertise:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">Ransomware Recovery</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Instant Restore</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Business Continuity</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Azure, AWS, QNAP, Synology</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Offsite & Multi-Site Backup</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Regulatory Compliance</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Backup Monitoring</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Automated Testing</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Failover Planning</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">SMB & Enterprise</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">24/7 Response</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Human Support</span>
    </div>
  </div>

  <!-- Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure how resilient you are? We'll assess your risks, test your backups, and get you protected.</div>
    <a href="/contact.php" class="inline-block bg-orange-500 hover:bg-orange-700 text-white px-6 py-2 rounded shadow font-semibold">Talk to a DR expert</a>
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
?>
