<?php
require 'layout.php';

$page_title = "Network & WiFi Problems | KTP Digital";
$page_desc = "Solve your network and WiFi headaches: slow speeds, dropouts, weak coverage, or insecure connections. KTP Digital can fix it all—fast. Expert support for Ubiquiti, Cisco, Juniper, Aruba, Avaya, Fortinet, MikroTik, DrayTek, Netgear, and more.";

$meta = <<<HTML
<meta name="description" content="Network and WiFi solutions for home, small business, and enterprise. Diagnose and fix slow speeds, dropouts, coverage, and security. Experts in Ubiquiti, Cisco, Juniper, Aruba, Avaya, Fortinet, MikroTik, DrayTek, Netgear, pfSense, Home Assistant, and more. Serving all of Australia." />
<meta name="keywords" content="network, wifi, WiFi, slow internet, business WiFi, enterprise WiFi, Ubiquiti, Cisco, Juniper, Aruba, Avaya, Fortinet, MikroTik, DrayTek, Netgear, Sophos, Omada, TP-Link, pfSense, OPNSense, Home Assistant, WPA3, VLAN, VPN, Australia, managed network, remote work, cloud, multi-site, macOS networks, Windows networks, IT support, network troubleshooting, coverage, security" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Network & WiFi Problems Solved | KTP Digital" />
<meta property="og:description" content="Get fast, expert help for slow or unreliable WiFi and networks. We support Ubiquiti, Cisco, Juniper, and all major vendors. SMB, enterprise, and home. Contact us today!" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.ktp.digital/network.php" />
<meta property="og:image" content="https://www.ktp.digital/images/og/network-og.jpg" />
<meta property="og:site_name" content="KTP Digital" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Network & WiFi Problems Solved | KTP Digital" />
<meta name="twitter:description" content="Solve slow, weak, or unreliable WiFi—business, enterprise, or home. Ubiquiti, Cisco, Juniper, and more. Free diagnosis, fast results." />
<meta name="twitter:image" content="https://www.ktp.digital/images/og/network-og.jpg" />
HTML;

$content = <<<HTML
<div class="max-w-3xl mx-auto py-12 px-4">
  <div class="flex items-center mb-6">
    <svg class="w-12 h-12 mr-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9A16 16 0 0 1 22.58 9M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <h1 class="text-3xl font-extrabold">Network & WiFi Problems</h1>
  </div>
  
  <p class="text-lg mb-6">
    Slow speeds? Unreliable or weak WiFi? We deliver expert diagnosis, enterprise-grade solutions, and ongoing support for businesses and homes. Wired or wireless—your network, fixed.
  </p>
  <a href="/contact.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-lg font-semibold px-8 py-3 rounded-lg shadow-lg transition mb-10">Get Your Network Fixed</a>

  <!-- Solution Cards -->
  <div class="mt-12">
    <h2 class="text-xl font-bold mb-6 text-white">How We Solve Network & WiFi Problems</h2>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Ubiquiti & UniFi Card -->
      <a href="/ubiquiti.php" class="bg-slate-800 hover:bg-blue-700 rounded-xl p-5 text-white flex flex-col items-center shadow transition">
        <img src="/images/icons/ubiquiti.svg" class="w-10 h-10 mb-2" alt="Ubiquiti" />
        <div class="font-bold">Ubiquiti & UniFi</div>
        <div class="text-xs opacity-80 mt-1">Cloud Gateways, WiFi7, secure business networking</div>
      </a>
      <!-- NextDNS Card -->
      <a href="/nextdns.php" class="bg-slate-800 hover:bg-blue-700 rounded-xl p-5 text-white flex flex-col items-center shadow transition">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <div class="font-bold">NextDNS Protection</div>
        <div class="text-xs opacity-80 mt-1">Enterprise-grade content filtering, privacy, and security</div>
      </a>
      <!-- Tailscale Card -->
      <a href="/tailscale.php" class="bg-slate-800 hover:bg-blue-700 rounded-xl p-5 text-white flex flex-col items-center shadow transition">
        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M8 12h8M12 8v8" /></svg>
        <div class="font-bold">Tailscale VPN</div>
        <div class="text-xs opacity-80 mt-1">Private, secure access to files, servers, and sites from anywhere</div>
      </a>
    </div>
  </div>

  <!-- Vendor Experience Block -->
  <div class="mt-8 text-center">
    <div class="text-md font-semibold text-white mb-3">Our Networking & WiFi Expertise Includes:</div>
    <div class="flex flex-wrap gap-3 justify-center text-gray-200 text-sm">
      <span class="bg-slate-800/80 rounded px-3 py-1">Ubiquiti/UniFi</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Cisco</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Juniper</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Aruba</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Avaya</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Fortinet</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">MikroTik</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">TP-Link Omada</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">DrayTek</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Netgear</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Sophos</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">pfSense</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">OPNSense</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Home Assistant</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Windows & macOS Networks</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">VLANs & VPNs</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">WPA3 & Enterprise WiFi</span>
      <span class="bg-slate-800/80 rounded px-3 py-1">Multi-Site & Remote Work</span>
    </div>
  </div>

  <!-- Optional: Not Sure CTA -->
  <div class="mt-10 text-center">
    <div class="text-sm text-white/80 mb-2">Not sure which solution fits you?</div>
    <a href="/contact.php" class="inline-block bg-gray-700 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">Talk to a human</a>
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
?>
