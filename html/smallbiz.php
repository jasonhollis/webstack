<?php
$page_title = "Small Business IT Solutions";
$page_desc = "SMB IT solutions from KTP Digital: networking, cloud, Ubiquiti/UniFi, Mac integration, Windows support, NextDNS, Tailscale, NAS, backup, and expert support.";
$canonical = "https://www.ktp.digital/smallbiz.php";
$og_image = "/images/logos/KTP%20Logo.png";
ob_start();
?>
<div>
  <h1 class="text-3xl md:text-4xl font-bold mb-4">Small Business IT Solutions</h1>
  <div class="mb-5 text-lg font-medium">
    Running a small business doesn’t mean compromising on IT, security, or support. KTP Digital brings <strong>enterprise-level</strong> solutions and true white glove service to the SMB sector—covering <b>networking, cloud, Mac, Windows, remote access, security, and more.</b>
  </div>
  <ul class="text-left max-w-2xl mx-auto mb-6 list-disc list-inside space-y-1 text-base">
    <li>Network design, upgrades, troubleshooting, and <b>WiFi7</b> performance</li>
    <li>Cloud migrations – Office 365, Google Workspace, integrated Mac &amp; Windows support</li>
    <li>Cybersecurity audits, compliance, and proactive protection</li>
    <li>Automation – save time &amp; money with integrated tools and remote access</li>
    <li>Disaster recovery, backup, and business continuity</li>
    <li>Remote support and on-call assistance—no jargon, just results</li>
  </ul>
  <div class="flex flex-wrap justify-center gap-5 md:gap-7 my-8">
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/mac.php">
      <img src="/images/icons/apple-white-forcedwhite.svg" alt="Mac" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">Mac Integration</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-blue-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/windows.php">
      <img src="/images/icons/windows-white-forcedwhite.svg" alt="Windows" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">Windows Support</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/macos-tools.php">
      <img src="/images/icons/macos-tools-white-forcedwhite.svg" alt="macOS Tools" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">macOS Tools</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/nas.php">
      <img src="/images/icons/qnap-white-forcedwhite.svg" alt="NAS" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">NAS &amp; Storage</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/ubiquiti.php">
      <img src="/images/icons/ubiquiti-white-forcedwhite.svg" alt="Ubiquiti" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">Ubiquiti Networks</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/nextdns.php">
      <img src="/images/icons/nextdns-white-forcedwhite.svg" alt="NextDNS" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">NextDNS Security</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/tailscale.php">
      <img src="/images/icons/tailscale-white-forcedwhite.svg" alt="Tailscale" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">Tailscale VPN</span>
    </a>
  </div>
  <a href="/contact.php" class="inline-block my-6 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition">Talk to Our Experts</a>
  <div class="bg-slate-800/80 p-5 md:p-7 rounded-lg max-w-2xl mx-auto mt-8 text-left relative">
    <img src="/images/icons/ubiquiti-white-forcedwhite.svg" alt="Ubiquiti" class="absolute top-5 right-5 h-8 w-8 opacity-80" onerror="this.style.display='none';">
    <div class="font-bold mb-1 text-green-300">Ubiquiti/UniFi for SMBs</div>
    <div>
      Next-generation networking—<b>Cloud Gateways, WiFi 7, and AI-powered Security Cameras</b>—with bulletproof reliability and intuitive management. Whether you need secure Wi-Fi, multi-site remote admin, or deep integration with NAS and cloud, KTP Digital deploys <b>Ubiquiti’s proven platform</b> for Australian business, including smart access controls with facial/plate recognition and advanced surveillance.
      <a href="/ubiquiti.php" class="ml-3 underline text-green-300 font-semibold">Learn more &raquo;</a>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
