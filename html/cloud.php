<?php
require 'layout.php';

$page_title = "Cloud, Backup & NAS | KTP Digital";
$page_desc = "Protect your business or home with secure cloud, backup, NAS, and disaster recovery solutions. Experts in QNAP, Synology, Azure, AWS, local storage, hybrid sync, and compliance for regulated industries.";

$meta = <<<HTML
<meta name="description" content="Cloud, backup, NAS, and disaster recovery—secure, automated, and fully supported. QNAP, Synology, Azure, AWS, secure cross-site sync, regulatory compliance, and on-prem hybrid solutions for business, enterprise, and home." />
<meta name="keywords" content="cloud backup, NAS, QNAP, Synology, disaster recovery, local storage, hybrid storage, business backup, encrypted backup, remote file access, cross-site sync, secure storage, compliance, regulated industries, Azure, AWS, on-premise, file sharing, home backup, ransomware recovery, storage, SMB, enterprise IT, managed backup, KTP Digital" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Cloud, Backup & NAS | KTP Digital" />
<meta property="og:description" content="Protect your business or home with secure, automated backup, disaster recovery, and enterprise-class storage. QNAP, Synology, cloud, hybrid, and local solutions." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/cloud.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/cloud-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Cloud, Backup & NAS | KTP Digital" />
<meta name="twitter:description" content="Cloud, backup, NAS, and disaster recovery for business and home. Fully managed, secure, and compliance-ready. QNAP, Synology, Azure, AWS." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/cloud-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <img src="/images/icons/qnap-white-forcedwhite.svg" class="w-12 h-12 mr-4 opacity-90" alt="Cloud, Backup & NAS" />
    <h1 class="text-3xl font-extrabold">Cloud, Backup &amp; NAS</h1>
  </div>
  <p class="text-lg mb-4">
    Safeguard your data with professional-grade cloud, on-site, and hybrid storage solutions.
    <span class="block mt-2">We support local, cloud, and fully compliant cross-site synchronisation for regulated industries, as well as small business and home.</span>
  </p>
  <div class="flex flex-wrap gap-3 justify-center mb-8">
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Automated Backups</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Disaster Recovery</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Ransomware Protection</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Cross-Site Sync</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Compliant Storage</span>
    <span class="bg-slate-800/80 rounded px-3 py-1 text-xs font-semibold text-white">Remote File Access</span>
  </div>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Protect My Data</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">Our Cloud, Backup &amp; NAS Solutions</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- QNAP NAS -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/qnap-white-forcedwhite.svg" class="w-10 h-10 mb-2" alt="QNAP NAS" />
        <div class="font-bold">QNAP NAS & Hybrid Backup</div>
        <div class="text-xs opacity-80 mt-1">High-speed, reliable, and flexible storage with hybrid cloud integration</div>
      </div>
      <!-- Synology NAS -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/synology-white.svg" class="w-10 h-10 mb-2" alt="Synology NAS" />
        <div class="font-bold">Synology NAS</div>
        <div class="text-xs opacity-80 mt-1">Easy-to-manage, secure, and scalable—ideal for homes and SMBs</div>
      </div>
      <!-- Cloud Storage (Azure, AWS, etc.) -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="16" cy="16" rx="14" ry="10" fill="#0891b2"/><path d="M10 16h12" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        <div class="font-bold">Cloud Storage (Azure, AWS)</div>
        <div class="text-xs opacity-80 mt-1">Fully managed cloud storage, backup, and multi-region sync</div>
      </div>
      <!-- Cross-Site Sync -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#facc15" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M8 12h8M12 8v8" /></svg>
        <div class="font-bold">Cross-Site Sync</div>
        <div class="text-xs opacity-80 mt-1">Sync data between sites securely—ideal for regulated and distributed teams</div>
      </div>
      <!-- Disaster Recovery -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M21 2v6h-6M3 12a9 9 0 1 0 9-9" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Disaster Recovery</div>
        <div class="text-xs opacity-80 mt-1">Instant restore, offsite backup, ransomware resilience</div>
      </div>
      <!-- Hybrid & Local Storage -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 17v1a3 3 0 0 0 8 0v-1" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Hybrid & Local Storage</div>
        <div class="text-xs opacity-80 mt-1">Best of both worlds: ultra-fast local, secure cloud, and full automation</div>
      </div>
    </div>
  </div>

  <!-- Expertise Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Our Backup & Storage Experience Includes:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">QNAP</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Synology</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Azure</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">AWS</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Google Cloud</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Hybrid Cloud Storage</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Encrypted Local Backup</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Cross-Site Sync</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Disaster Recovery</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Ransomware Protection</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">SMB & Enterprise Storage</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Compliance Solutions</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Remote File Access</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">On-premise & Multi-site</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Automated Monitoring</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Full Support & Management</span>
    </div>
  </div>

  <!-- Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure what's right for your business or home? Let's design a backup and storage plan you can trust.</div>
    <a href="/contact.php" class="inline-block bg-gray-700 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">Talk to a backup expert</a>
  </div>
</div>
HTML;

$canonical = "https://www.ktp.digital/cloud.php";
renderLayout($page_title, $content, $meta, $page_desc, $canonical);
?>
