<?php
require __DIR__ . '/layout.php';

$page_title = "Home Automation, Solved | KTP Digital";
$page_description = "Frustrated by smart home tech? KTP Digital fixes app fatigue, security worries, and tech chaos. Discover the most approachable, supported, and future-ready automation in Australia.";
$page_keywords = "Home Assistant, smart home support, automation, app fatigue, Zigbee, Z-Wave, KTP Digital, HomeKit, security, Home Assistant consultant, trusted installer, local support";

// BEGIN LANDING PAGE CONTENT
$content = <<<HTML
<section class="max-w-4xl mx-auto text-center pt-6 pb-8">
    <img src="/images/icons/home-assistant.svg" alt="Home Assistant Logo" class="mx-auto w-16 h-16 mb-4" loading="lazy">
    <h1 class="text-3xl sm:text-5xl font-bold mb-3">Home Automation, Solved</h1>
    <p class="text-lg sm:text-2xl mb-2">
        Frustrated by smart home tech? <span class="text-blue-700 font-semibold">We make your home work for you.</span>
    </p>
    <p class="text-base sm:text-lg text-gray-600 mb-4">
        No more app fatigue. No endless troubleshooting. Just real automation—done right.
    </p>
    <a href="contact.php" class="inline-block px-8 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow hover:bg-blue-800 transition mb-2">
        Book a Free Consult
    </a>
</section>

<section class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-2 pb-10">
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/apps.svg" alt="Too Many Apps" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">Too Many Apps</div>
        <div class="text-sm text-gray-600 mb-2">One app for lights, one for locks, another for cameras? We unify everything into a single, easy dashboard.</div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/disconnect.svg" alt="Devices Don't Talk" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">Devices Don't Talk</div>
        <div class="text-sm text-gray-600 mb-2">We integrate all your brands—old and new. No more islands or incompatibility.</div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/shield.svg" alt="Worried About Security" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">Worried About Security?</div>
        <div class="text-sm text-gray-600 mb-2">Your home is private and secure by design. Every install is locked down and monitored.</div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/support.svg" alt="No Support" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">No Support?</div>
        <div class="text-sm text-gray-600 mb-2">We’re local and real. Help is always just a call away—no call centers, no ghosting.</div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/lightbulb.svg" alt="Lights Don’t Behave" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">Lights Don’t Behave?</div>
        <div class="text-sm text-gray-600 mb-2">Smart lights not responding? Doors don’t lock? We fix and future-proof your system.</div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center text-center border border-gray-100">
        <img src="/images/icons/clock.svg" alt="Wasting Time" class="w-9 h-9 mb-2" loading="lazy">
        <div class="font-semibold text-lg mb-1">Wasting Time</div>
        <div class="text-sm text-gray-600 mb-2">No more lost evenings to tech troubleshooting. We deliver real automation that just works.</div>
    </div>
</section>

<section class="max-w-3xl mx-auto text-center mt-6 mb-8">
    <div class="mb-2 text-base sm:text-lg">
        <span class="text-blue-700 font-semibold">2M+</span> Home Assistant installs • <span class="text-blue-700 font-semibold">15+ years</span> integration expertise • <span class="text-blue-700 font-semibold">No brand lock-in</span>
    </div>
    <div class="text-gray-500 text-sm">KTP Digital is trusted by families and businesses across Australia</div>
</section>
HTML;
// END LANDING PAGE CONTENT

$canonical = "https://www.ktp.digital/home-automation.php";
renderLayout($page_title, $content, '', $page_description, $canonical);
?>
