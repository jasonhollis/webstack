<?php
$page_title = "Windows Desktop & Laptop Support – KTP Digital";
$page_desc = "Windows 10 end-of-life is approaching—get expert Windows migration, deployment, security, patching, and Microsoft 365 support for your business PCs with KTP Digital.";
$canonical = "https://www.ktp.digital/windows.php";
$og_image = "/images/icons/windows-white-forcedwhite.svg";
$meta = <<<HTML
<meta name="description" content="Windows 10 end-of-life is coming—plan your Windows 11 migration with KTP Digital. Complete Windows PC support: rollout, patching, security, remote help, Microsoft 365, backup, and compliance for SMB." />
<meta property="og:title" content="Windows Desktop & Laptop Support – KTP Digital" />
<meta property="og:description" content="Windows 10 end-of-life: plan your Windows 11 migration. Business-class Windows support: secure deployment, patching, Microsoft 365, security, backup, and remote help for SMB." />
<meta property="og:image" content="/images/icons/windows-white-forcedwhite.svg" />
<link rel="canonical" href="https://www.ktp.digital/windows.php" />
HTML;
ob_start();
?>
<div>
  <h1 class="text-3xl md:text-4xl font-bold mb-4 flex items-center">
    <img src="/images/icons/windows-white-forcedwhite.svg" alt="Windows Support" class="h-10 w-10 mr-3">
    Windows Desktop & Laptop Support
  </h1>
  <div class="mb-5 text-lg font-medium">
    <span class="inline-block px-3 py-1 bg-red-600 text-white font-semibold rounded mr-2">Windows 10 End of Life</span>
    <span class="font-bold text-white">Is your business ready for Windows 11?</span>
    <br>
    Windows 10 will reach end of support soon—now is the time to plan your migration and future-proof your business devices. KTP Digital offers expert guidance, hands-on migration, deployment, patching, and Microsoft 365 support for all your Windows desktops and laptops.
  </div>
  <ul class="text-left max-w-2xl mx-auto mb-6 list-disc list-inside space-y-1 text-base">
    <li><span class="font-bold">Windows 10/11 migration and zero-touch deployment</span>—secure rollout, OS imaging, device refresh, and upgrades</li>
    <li>Device management—updates, patching, asset tracking, and policy enforcement (Intune/Endpoint)</li>
    <li>Microsoft 365/Office: Outlook, Teams, OneDrive, SharePoint setup & troubleshooting</li>
    <li>Remote and onsite support: business continuity, malware cleanup, hardware issues</li>
    <li>Security: BitLocker, MFA, encryption, antivirus, and compliance</li>
    <li>Data migration, backup/restore, device replacement and business continuity</li>
    <li>Printer, network, and remote access integration for Windows devices</li>
  </ul>
  <div class="flex flex-wrap justify-center gap-5 md:gap-7 my-8">
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/mac.php">
      <img src="/images/icons/apple-white-forcedwhite.svg" alt="Mac" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">Mac Integration</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/nas.php">
      <img src="/images/icons/qnap-white-forcedwhite.svg" alt="NAS" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">NAS & Storage</span>
    </a>
    <a class="flex flex-col items-center bg-slate-900/90 hover:bg-green-700 transition rounded-xl p-4 w-36 shadow group no-underline text-white" href="/nextdns.php">
      <img src="/images/icons/nextdns-white-forcedwhite.svg" alt="NextDNS" class="h-10 w-10 mb-2" onerror="this.style.display='none';">
      <span class="font-semibold">NextDNS Security</span>
    </a>
  </div>
  <a href="/contact.php" class="inline-block my-6 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">Book a Windows Support Assessment</a>
  <div class="bg-slate-800/80 p-5 md:p-7 rounded-lg max-w-2xl mx-auto mt-8 text-left relative">
    <img src="/images/icons/windows-white-forcedwhite.svg" alt="Windows" class="absolute top-5 right-5 h-8 w-8 opacity-80" onerror="this.style.display='none';">
    <div class="font-bold mb-1 text-blue-300">Windows 10 End-of-Life: Don’t Get Caught Out</div>
    <div>
      Microsoft will soon end support for Windows 10. KTP Digital can help you upgrade, migrate, and secure your devices before time runs out—protecting your business from compliance and security risks.
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, $meta, $page_desc, $canonical, $og_image);
