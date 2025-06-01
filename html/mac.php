<?php
require __DIR__ . '/layout.php';

$page_title = "Apple Support, Automation & Integration – Mac, iPhone, iPad, Apple TV, HomePod | KTP Digital";
$page_desc  = "Unlock the full power of your Apple devices—Mac, iPhone, iPad, Apple TV, HomePod, and Apple Watch—with expert support, automation, and business integration from KTP Digital. Certified Apple specialists since 1984.";
$canonical = "https://www.ktp.digital/mac.php";
$og_image = "/images/mac/hero.jpg";

$meta = <<<HTML
    <meta name="description" content="$page_desc" />
    <meta name="generator" content="KTP Webstack – GPT + BBEdit workflow" />
    <meta name="keywords" content="Apple, Mac, iPhone, iPad, Apple TV, HomePod, Apple Watch, HomeKit, AirDrop, Handoff, iCloud, Apple Silicon, Apple Shortcuts, device management, business, security, automation, support, KTP Digital" />
    <meta property="og:title" content="$page_title" />
    <meta property="og:description" content="$page_desc" />
    <meta property="og:image" content="https://www.ktp.digital/images/mac/hero.jpg" />
    <meta property="og:url" content="https://www.ktp.digital/mac.php" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="$page_title" />
    <meta name="twitter:description" content="$page_desc" />
    <meta name="twitter:image" content="https://www.ktp.digital/images/mac/hero.jpg" />
    <link rel="canonical" href="https://www.ktp.digital/mac.php" />
HTML;

$content = <<<HTML
<!-- Hero Section -->
<div class="relative w-full min-h-[330px] md:min-h-[420px] flex items-center justify-center overflow-hidden mb-10 rounded-xl shadow-xl"
     style="background: url('/images/mac/hero.jpg') center center / cover no-repeat;">
  <div class="absolute inset-0 bg-black bg-opacity-60"></div>
  <div class="relative z-10 max-w-2xl mx-auto p-6 md:p-12 text-center">
    <h1 class="text-3xl md:text-4xl font-extrabold mb-4 text-white drop-shadow">Apple Technology — Since 1984</h1>
    <p class="text-lg md:text-xl mb-3 text-blue-100 drop-shadow">
      I’ve been working with Apple technology since the original Macintosh launch in 1984.<br>
      From the first GUI to Apple Silicon, I’ve seen — and supported — every generation.
    </p>
    <p class="mt-4 text-base md:text-lg text-blue-200 italic">
      “On January 24th, Apple Computer will introduce Macintosh. And you’ll see why 1984 won’t be like '1984.'”
    </p>
  </div>
</div>

<!-- Expanded Modern Apple Ecosystem Coverage -->
<div class="p-2 sm:p-8 max-w-5xl mx-auto">
  <p class="text-lg mb-6">
    <span class="font-semibold">KTP Digital helps you unlock the full power of your Apple devices—<span class="text-blue-800">Mac, iPhone, iPad, Apple TV, HomePod, and Apple Watch</span>—with expert support, automation, and seamless ecosystem integration.</span> Whether you're a business, a family, or a power user, we make Apple work for you—securely, efficiently, and creatively.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold mb-2">Mac & macOS</h2>
      <ul class="list-disc pl-5 text-base mb-1">
        <li>Apple Silicon upgrades, migration & virtualization (Parallels, UTM)</li>
        <li>macOS automation (Shortcuts, scripting, Automator, AppleScript)</li>
        <li>Remote management (MDM), security hardening, device backup</li>
        <li>Seamless networking (AirDrop, AirPlay, iCloud Drive)</li>
        <li>Zero-downtime support for creative, business & technical workflows</li>
      </ul>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold mb-2">iPhone, iPad & Mobile</h2>
      <ul class="list-disc pl-5 text-base mb-1">
        <li>Setup, migration, family & device sharing, iCloud</li>
        <li>Backup, privacy, device security, parental controls</li>
        <li>App automation (Shortcuts), workflow integration</li>
        <li>Cross-device syncing & business tool deployment</li>
      </ul>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold mb-2">Apple Watch, HomePod & Apple TV</h2>
      <ul class="list-disc pl-5 text-base mb-1">
        <li>Apple Watch setup, health, automation & notifications</li>
        <li>HomePod & Apple TV integration (entertainment, smart home, HomeKit)</li>
        <li>Multi-room audio, media & family controls</li>
      </ul>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold mb-2">Apple Ecosystem & Automation</h2>
      <ul class="list-disc pl-5 text-base mb-1">
        <li>Handoff, AirDrop, AirPlay, Universal Clipboard, Sidecar</li>
        <li>iCloud for business, family, and backup/recovery</li>
        <li>HomeKit, smart home, and advanced Shortcuts automations</li>
        <li>Support for schools, creative teams, business & SMB</li>
      </ul>
    </div>

  </div>

  <div class="bg-blue-50 rounded-xl p-5 mb-8">
    <h3 class="text-lg font-semibold mb-2">Why Choose KTP Digital for Apple?</h3>
    <ul class="list-disc pl-5 text-base">
      <li>35+ years in IT & Apple technology leadership</li>
      <li>Certified Apple consultant experience—business & home</li>
      <li>Seamless migrations, repairs, upgrades, and custom automations</li>
      <li>Expertise in security, compliance, and integration with Windows or cloud</li>
      <li>Personal, remote, and on-site support—across Australia</li>
    </ul>
  </div>

  <div class="flex flex-col md:flex-row gap-4 mb-6">
    <a href="/contact.php" class="bg-blue-700 hover:bg-blue-900 text-white font-semibold rounded-xl px-6 py-3 text-center shadow">
      Book a Free Consultation
    </a>
    <a href="/automation.php" class="bg-white border border-blue-700 text-blue-700 hover:bg-blue-50 font-semibold rounded-xl px-6 py-3 text-center shadow">
      Learn More About Automation
    </a>
  </div>

  <p class="text-base text-gray-600 mb-2">From business IT to family tech, Apple is better with KTP Digital. <strong>Ask us how we can automate your world!</strong></p>
</div>
HTML;

renderLayout($page_title, $content, $meta, $page_desc, $canonical, $og_image);
