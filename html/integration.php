<?php
require 'layout.php';

$page_title = "Mac & Windows Integration | KTP Digital";
$page_desc = "Seamlessly connect Macs, PCs, and mobile devices—sharing files, printers, email, and cloud services. Experts in Office 365, Azure, AWS, Docker, scripting, and automation for home and enterprise.";

$meta = <<<HTML
<meta name="description" content="Mac and Windows integration made simple. Network, file sharing, email, Office 365, Azure, AWS, Docker, Excel macros, macOS Shortcuts, scripting, and enterprise cloud integration. Seamless results for home, business, and enterprise. KTP Digital." />
<meta name="keywords" content="Mac integration, Windows integration, Office 365, Azure, AWS, Docker, automation, Excel macros, macOS Shortcuts, scripting, file sharing, Active Directory, cloud, network, printers, mobile, device management, Apple, Microsoft, enterprise IT, business IT, MDM, cross-platform, IT support, SMB, enterprise, workflow automation, digital transformation, identity management, home office, KTP Digital" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Mac & Windows Integration | KTP Digital" />
<meta property="og:description" content="Macs, PCs, and cloud in perfect sync. Office 365 admin since launch, Azure, AWS, Docker, automation, scripting—home to enterprise." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/integration.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/integration-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Mac & Windows Integration | KTP Digital" />
<meta name="twitter:description" content="Experts in Mac, PC, Office 365, Azure, AWS, Docker, and automation. Make your tech just work—at home, business, or enterprise." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/integration-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="3" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 21h8M12 17v4" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Mac & Windows Integration</h1>
  </div>
  
  <p class="text-lg mb-6">
    Need your Mac and PC systems to play nicely together? We make everything work—networks, files, printers, email, cloud, automation, and more. 
    <span class="block mt-2">From Office 365 (since 2011) to Azure, AWS, and Docker, we connect the pieces that others can’t.</span>
  </p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Make My Devices Work Together</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">How We Integrate Everything</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Office 365 & Microsoft 365 -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/microsoft.svg" class="w-10 h-10 mb-2" alt="Office 365" />
        <div class="font-bold">Office 365 & Azure</div>
        <div class="text-xs opacity-80 mt-1">Email, Teams, OneDrive, SharePoint, SSO & identity—expert admin since launch</div>
      </div>
      <!-- Apple & Mac Device Management -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <img src="/images/icons/apple.svg" class="w-10 h-10 mb-2" alt="Apple" />
        <div class="font-bold">Apple & Mac Integration</div>
        <div class="text-xs opacity-80 mt-1">macOS deployment, profiles, iCloud, MDM, seamless with Windows</div>
      </div>
      <!-- AWS & Cloud Services -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="16" cy="16" rx="14" ry="10" fill="#F7A80D"/><path d="M10 16h12" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        <div class="font-bold">AWS, Azure & Cloud</div>
        <div class="text-xs opacity-80 mt-1">Hybrid identity, secure storage, automated backup, cloud migration</div>
      </div>
      <!-- Docker & Modern Apps -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="14" width="20" height="6" rx="2" fill="#2496ED"/><rect x="10" y="10" width="4" height="4" rx="1" fill="#2496ED"/><rect x="18" y="10" width="4" height="4" rx="1" fill="#2496ED"/></svg>
        <div class="font-bold">Docker & App Integration</div>
        <div class="text-xs opacity-80 mt-1">Containers, automation, and microservices that “just work”</div>
      </div>
      <!-- Automation & Scripting -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#facc15" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 17v1a3 3 0 0 0 6 0v-1" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 10l-2-2-2 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Automation & Scripting</div>
        <div class="text-xs opacity-80 mt-1">macOS Shortcuts, Automator, Excel macros, PowerShell, Bash, and workflow integration</div>
      </div>
      <!-- Network, File, Printer Sharing -->
      <div class="bg-slate-800 rounded-xl p-5 text-white flex flex-col items-center shadow">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="#38bdf8" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="12" x="3" y="7" rx="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 17v1a3 3 0 0 0 8 0v-1" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">Network, Files & Printing</div>
        <div class="text-xs opacity-80 mt-1">Cross-platform file shares, printers, and fast, secure WiFi</div>
      </div>
    </div>
  </div>

  <!-- Expertise Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Our Integration Experience Includes:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">Office 365 Admin (since 2011)</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Azure AD & Hybrid Identity</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">AWS</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Docker</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Apple macOS & MDM</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Windows Server & AD</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Mobile Device Management</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Bash, PowerShell, Zsh</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Excel Macros & VBA</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">macOS Shortcuts & Automator</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">OneDrive & SharePoint</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">File/Print Sharing</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Cross-platform SSO</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Network Integration</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Cloud Automation</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Enterprise IT Projects</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Home/SMB Solutions</span>
    </div>
  </div>

  <!-- Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure what’s possible? Most IT teams call us when others have failed.</div>
    <a href="/contact.php" class="inline-block bg-gray-700 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">Let’s Integrate Everything</a>
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
?>
