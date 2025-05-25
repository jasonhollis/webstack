<?php
require_once __DIR__.'/layout.php';
$page_title = "Tailscale VPN Solutions";
$page_desc  = "Tailscale mesh VPN for SMB: secure remote access, private networking, and frictionless multi-site connectivity—supported by KTP Digital.";
$canonical = "https://www.ktp.digital/tailscale.php";
$og_image = "/images/icons/tailscale.png";
ob_start();
?>

<div>
  <h1 class="text-3xl md:text-4xl font-bold mb-4 flex items-center gap-2">
    <img src="/images/icons/tailscale.png" alt="Tailscale" class="h-10 w-10" onerror="this.style.display='none';">
    Tailscale VPN Solutions
  </h1>
  <p class="text-lg mb-5">
    <b>Tailscale</b> is a mesh VPN platform that makes secure, private networking effortless for small business, remote teams, and hybrid environments. KTP Digital deploys and supports Tailscale so your staff, systems, and services are always securely connected—wherever you work.
  </p>

  <div class="grid md:grid-cols-2 gap-7 mb-8">
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🔑 Zero Configuration</h2>
      <p>Onboard every device (Mac, PC, NAS, server, even cloud VMs) without port forwarding, static IPs, or firewall pain. Tailscale “just works” from anywhere—no IT hassle.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🔒 Secure by Default</h2>
      <p>Powered by WireGuard, all traffic is end-to-end encrypted. Devices authenticate with SSO or pre-approved keys—no shared secrets or risky public VPNs.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🌍 Access From Anywhere</h2>
      <p>Give your team access to files, NAS shares, remote desktops, and even on-prem web apps as if they were in the same office. Perfect for home office, field staff, or hybrid teams.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🛡️ Centralized Control</h2>
      <p>Manage access with simple web dashboards—control which user or device can reach which service, revoke access instantly, and log all connections for compliance.</p>
    </div>
  </div>

  <div class="my-8 text-left space-y-5 max-w-3xl mx-auto">
    <div class="bg-green-100/90 text-green-900 rounded-lg px-6 py-5 shadow">
      <b>🔗 Why pair Tailscale with KTP’s solutions?</b><br>
      <ul class="list-disc ml-5 mt-2 text-base">
        <li><b>Secure Cloud & NAS access</b> — map Tailscale to QNAP, Synology, or Mac file shares.</li>
        <li><b>Private remote admin</b> — connect to UniFi, NextDNS, or Home Assistant dashboards with no public exposure.</li>
        <li><b>Granular user controls</b> — ensure staff only reach what they’re approved for (least-privilege by default).</li>
        <li><b>Replace legacy VPNs</b> — no hardware boxes, no open firewall ports, and seamless device onboarding.</li>
      </ul>
    </div>
    <div class="mt-8 mb-4 text-lg font-semibold">
      <span class="text-white drop-shadow">See how Tailscale fits into:</span>
      <a href="nas.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">NAS solutions</a>,
      <a href="ubiquiti.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">Ubiquiti networking</a>,
      <a href="nextdns.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">NextDNS security</a>,
      or our
      <a href="smallbiz.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">Small Business IT stack</a>.
    </div>
  </div>

  <a href="https://tailscale.com" target="_blank" class="inline-block my-6 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition">
    Visit tailscale.com &rarr;
  </a>
</div>

<?php
$content = ob_get_clean();
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
