<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Small Business IT & Apple Device Solutions – KTP Digital";
$page_desc  = "Apple business IT experts: Setup, security, Mac, iPhone, iPad, NAS, VPN, DNS, remote support, and enterprise-grade automation for small businesses in Australia.";

$content = <<<HTML
<section class="max-w-4xl mx-auto p-6 rounded-2xl shadow-xl bg-black/70 backdrop-blur-md mt-12">
  <h1 class="text-4xl font-bold mb-4 text-white drop-shadow">🏢 Small Business & Apple IT Solutions</h1>
  <p class="mb-6 text-lg text-gray-100 drop-shadow">
    We help small businesses <strong>secure, monitor, and connect</strong> their Apple and cross-platform environments using the best technology — simply and affordably.<br><br>
    <strong>Specialists in Mac, iPhone, iPad, and Apple integration.</strong> We support Apple devices in retail, clinics, creative studios, and remote-first offices.
  </p>
  <ul class="list-disc list-inside text-left text-lg space-y-2 text-gray-100 drop-shadow">
    <li>Apple Business Manager, MDM, and zero-touch onboarding</li>
    <li>Cloud Gateway routing and VPN (<a href="tailscale.php" class="text-blue-300 underline">Tailscale</a>)</li>
    <li>Next-gen DNS security & filtering (<a href="nextdns.php" class="text-blue-300 underline">NextDNS</a>)</li>
    <li>Ubiquiti Protect camera systems</li>
    <li>Access Control with facial and license plate recognition</li>
    <li>Local backup, monitoring, and alerting</li>
    <li>NAS integration — <a href="nas.php" class="text-blue-300 underline">QNAP, Synology, and Docker services</a></li>
    <li>Remote support and enterprise-grade automation</li>
  </ul>
  <p class="mt-6 text-lg text-gray-100 drop-shadow">
    Want to know more about our <a href="mac.php" class="text-blue-300 underline">Mac & Apple device expertise</a>?<br>
    Whether you're a retail shop, clinic, or remote-first office — we help you operate like an enterprise without the overhead.<br><br>
    <a href="contact.php" class="text-green-400 underline font-semibold">Contact us today</a> for advice, a site audit, or to book support.
  </p>
</section>

HTML;

renderLayout($page_title, $content);
