<?php
require_once __DIR__.'/layout.php';
$page_title = "NextDNS Protection";
$page_desc  = "NextDNS DNS filtering, analytics, privacy, and security—enterprise-grade, zero-hardware, fully managed by KTP Digital for home or business.";
$canonical = "https://www.ktp.digital/nextdns.php";
$og_image = "/images/icons/nextdns.png";
ob_start();
?>

<div>
  <h1 class="text-3xl md:text-4xl font-bold mb-4 flex items-center gap-2">
    <img src="/images/icons/nextdns.png" alt="NextDNS" class="h-10 w-10" onerror="this.style.display='none';">
    NextDNS Protection
  </h1>
  <p class="text-lg mb-5">
    <b>NextDNS</b> brings enterprise-grade content filtering, privacy, and security to your network with <b>zero hardware</b> and instant deployment. KTP Digital configures NextDNS for your business, family, or remote workforce—protecting every device, anywhere.
  </p>

  <!-- Why NextDNS Section -->
  <div class="bg-blue-900/90 text-blue-100 rounded-lg px-6 py-5 shadow text-base mb-8">
    <b>Why is NextDNS the best-kept secret in network security?</b>
    <ul class="list-disc ml-6 mt-2 space-y-1">
      <li><b>No hardware required:</b> Nothing to buy, install, or update. NextDNS lives in the cloud—no boxes or dongles, ever.</li>
      <li><b>Zero maintenance:</b> No patches, no firmware updates, and no admin headaches. Just change your DNS settings once and you’re done.</li>
      <li><b>Protects everything:</b> Instantly blocks ads, tracking, and malware for every device—even TVs, lights, and smart home gadgets.</li>
      <li><b>Great for home automation:</b> Block your smart TV, speakers, bulbs, and cameras from reporting back to the vendor. <a href="automation.php" class="underline text-green-300 hover:text-green-200">See our automation & privacy tips</a>.</li>
      <li><b>Affordable and powerful:</b> Get enterprise-grade privacy and security—without the enterprise price tag.</li>
    </ul>
  </div>

  <div class="grid md:grid-cols-2 gap-7 mb-8">
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🛡️ Real-Time Filtering</h2>
      <p>Block trackers, malware, ads, and unwanted content for every user—at the DNS level, with no software to install. Ideal for business, schools, and home.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">📊 Visibility & Logs</h2>
      <p>See exactly which devices are making what queries—crucial for security, compliance, and even parental controls.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">👥 Per-Device Profiles</h2>
      <p>Apply different filtering rules or access levels to each device, group, or staff member. Easily isolate risky or guest devices.</p>
    </div>
    <div class="bg-slate-900/90 rounded-xl p-5 shadow text-left">
      <h2 class="text-xl font-semibold mb-2">🌐 Works Anywhere</h2>
      <p>Protect your team in the office, at home, or on the road—NextDNS works with any OS, device, or router. Great for BYOD or hybrid workforces.</p>
    </div>
  </div>

  <div class="my-8 text-left space-y-5 max-w-3xl mx-auto">
    <div class="mt-8 mb-4 text-lg font-semibold">
      <span class="text-white drop-shadow">See how NextDNS fits with:</span>
      <a href="tailscale.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">Tailscale VPN</a>,
      <a href="ubiquiti.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">Ubiquiti networking</a>,
      <a href="nas.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">NAS storage</a>,
      or our
      <a href="smallbiz.php" class="ml-2 text-green-300 hover:text-green-200 underline transition">Small Business IT stack</a>.
    </div>
  </div>

  <a href="https://nextdns.io" target="_blank" class="inline-block my-6 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition">
    Visit nextdns.io &rarr;
  </a>
</div>

<?php
$content = ob_get_clean();
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
