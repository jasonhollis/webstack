<?php
$page_title = "Ubiquiti & UniFi for Small Business – KTP Digital";
$page_desc = "Ubiquiti for SMB: Cloud gateways, WiFi7, UniFi cameras, access control, and full integration—deployed and supported by KTP Digital.";
$canonical = "https://www.ktp.digital/ubiquiti.php";
$og_image = "/images/icons/ubiquiti.png";
ob_start();
?>
<div>
  <h1 class="text-3xl md:text-4xl font-bold mb-5 flex items-center justify-center gap-3">
    <img src="/images/icons/ubiquiti.png" class="h-9 w-9 inline-block" alt="Ubiquiti" onerror="this.style.display='none';">
    Ubiquiti &amp; UniFi for Small Business
  </h1>
  <section class="bg-slate-900/80 rounded-xl p-6 md:p-8 mb-8">
    <div class="flex items-start gap-5 mb-2">
      <img src="/images/icons/gateway.png" class="h-10 w-10" alt="Gateway" onerror="this.style.display='none';">
      <div>
        <h2 class="text-lg font-semibold mb-1">
          <a href="https://ui.com/us/en/cloud-gateways" target="_blank" class="underline text-green-300 hover:text-green-200">Cloud Gateways</a>, Networking,
          <a href="https://ui.com/us/en/wifi" target="_blank" class="underline text-green-300 hover:text-green-200">WiFi7</a>
        </h2>
        <p>
          High-performance <a href="https://ui.com/us/en/cloud-gateways" target="_blank" class="underline text-green-300 hover:text-green-200">UniFi Cloud Gateways</a> deliver fast, secure networking—wired and wireless—across all your sites, with simple remote management. Upgrade to <a href="https://ui.com/us/en/wifi" target="_blank" class="underline text-green-300 hover:text-green-200">WiFi 7</a> for unmatched speed and reliability. Scale from a one-bedroom flat to a full enterprise campus—UniFi switches, wireless mesh, and seamless expansion as your business grows.
        </p>
        <div class="italic text-gray-300 mt-1">More details and SMB case studies coming soon.</div>
      </div>
    </div>
  </section>
  <section class="bg-slate-900/80 rounded-xl p-6 md:p-8 mb-8">
    <div class="flex items-start gap-5 mb-2">
      <img src="/images/icons/camera.png" class="h-10 w-10" alt="Camera" onerror="this.style.display='none';">
      <div>
        <h2 class="text-lg font-semibold mb-1">
          <a href="https://ui.com/us/en/camera-security" target="_blank" class="underline text-green-300 hover:text-green-200">Security Cameras &amp; AI Video</a>
        </h2>
        <p>
          Deploy <a href="https://ui.com/us/en/camera-security" target="_blank" class="underline text-green-300 hover:text-green-200">UniFi Protect</a> with AI-powered cameras—advanced detection, smart alerts, and privacy features. Integrate with NAS (QNAP, Synology) for robust local video storage and long-term retention.
        </p>
        <div class="italic text-gray-300 mt-1">See how we secure real-world SMBs—full demos and recommendations coming soon.</div>
      </div>
    </div>
  </section>
  <section class="bg-slate-900/80 rounded-xl p-6 md:p-8 mb-8">
    <div class="flex items-start gap-5 mb-2">
      <img src="/images/icons/access.png" class="h-10 w-10" alt="Access Control" onerror="this.style.display='none';">
      <div>
        <h2 class="text-lg font-semibold mb-1">
          <a href="https://ui.com/us/en/door-access" target="_blank" class="underline text-green-300 hover:text-green-200">Access Controls, License Plate &amp; Facial Recognition</a>
        </h2>
        <p>
          Modernize your workplace with <a href="https://ui.com/us/en/door-access" target="_blank" class="underline text-green-300 hover:text-green-200">UniFi Access</a>—door readers, mobile entry, and advanced authentication. Enable license plate and facial recognition for security and staff convenience, all managed from a single platform.
        </p>
        <div class="italic text-gray-300 mt-1">Detailed integrations and step-by-step SMB guides coming soon.</div>
      </div>
    </div>
  </section>
  <section class="bg-slate-900/80 rounded-xl p-6 md:p-8 mb-8">
    <h2 class="text-lg font-semibold mb-2">Why Choose KTP Digital?</h2>
    <p>
      We deliver hands-on, local support and custom-tailored Ubiquiti deployments—from first install to ongoing optimization. We don’t just sell hardware; we ensure every system is <b>secure, reliable, and built for your business</b>.
    </p>
  </section>
  <div class="flex flex-wrap gap-4 justify-center mt-8 mb-3">
    <a class="bg-slate-800/80 px-5 py-3 rounded-lg font-semibold hover:bg-green-600 transition" href="/nas.php">NAS Integration</a>
    <a class="bg-slate-800/80 px-5 py-3 rounded-lg font-semibold hover:bg-green-600 transition" href="/nextdns.php">NextDNS</a>
    <a class="bg-slate-800/80 px-5 py-3 rounded-lg font-semibold hover:bg-green-600 transition" href="/tailscale.php">Tailscale VPN</a>
    <a class="bg-slate-800/80 px-5 py-3 rounded-lg font-semibold hover:bg-green-600 transition" href="/smallbiz.php">&larr; Back to Small Business IT</a>
  </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
