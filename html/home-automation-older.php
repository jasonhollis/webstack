<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Home Automation, Solved with Home Assistant | KTP Digital";
$page_description = "How KTP Digital transforms real homes with Home Assistant: seamless control, legacy integration, video security, and a network you can trust.";
$page_keywords = "Home Assistant, home automation, C-Bus, Zigbee, Z-Wave, Sonos, HomeKit, Ubiquiti, Dream Machine Pro, KTP Digital, QNAP, NAS, video backup, Unifi Protect, real stories, network upgrade, geolocation, lighting, voice control, Tesla Battery Wall, Zigbee2MQTT, POE Switch, air conditioning, heating, Miele appliances, garage door, gate automation, Ubiquiti AI, legacy integration, flood sensor, integrations, open source, 2 million installs";

$content = <<<HTML
<section class="px-6 py-16 max-w-4xl mx-auto">
  <div class="flex flex-col items-center mb-8">
    <img src="/images/icons/home-assistant.svg" alt="Home Assistant Logo" class="w-16 h-16 mb-4" loading="lazy">
    <h1 class="text-4xl font-bold mb-2 text-center">Home Automation, Solved</h1>
    <p class="text-lg text-center mb-2">
      Most people don’t want more gadgets—they want peace of mind.
    </p>
    <p class="font-semibold text-center mb-4">
      Here’s how KTP Digital puts Home Assistant at the heart of truly smart homes.
    </p>
  </div>

  <!-- Customer Story 1 -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 mb-10">
    <h2 class="text-2xl font-semibold mb-4">Customer Story #1: From App Fatigue to Effortless Living</h2>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      When we first met our client, their home was a showcase for every kind of smart tech—Philips Hue for lighting, Sonos for sound, B&O speakers, SmartThings for appliances, HomeKit bridges, robot vacuums, <strong>Miele appliances</strong>, a <strong>Tesla Battery Wall</strong>, garage doors, driveway gates, and a solar system. It all worked, but only just. <strong>The real pain?</strong> Every device lived in its own app. The customer’s phone had nearly 25 different smart home apps, each with its own quirks, logins, and limitations. Lights were smart, but scenes didn’t sync. The security system was reliable, but not integrated. There was no single place to see what was happening or to control everything—at home or away.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      That changed the day we introduced Home Assistant. <strong>Step one was fixing the network foundation</strong>: we replaced aging WiFi with a Ubiquiti Dream Machine Pro, a rock-solid POE switch, and two new Ubiquiti access points, giving the home full coverage and stability. Only then could we start to unify the smart home experience.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      With KTP Digital’s help, every device—Philips Hue, Sonos, Miele appliances, Tesla Battery Wall, air conditioning, heating, garage doors, gates, and nearly <strong>200 Zigbee devices</strong> (using Zigbee2MQTT), plus cutting-edge Z-Wave 800 sensors—were brought together under <strong>one interface</strong>. Now, the family manages everything from a single app: <strong>Home Assistant</strong>. No more juggling logins or troubleshooting scenes; just seamless, reliable control. Everything is voice-integrated for natural commands, and geolocation now drives three types of dynamic lighting scenes: coming home, night mode, and energy-saving. Even remote control and monitoring are effortless, whether they’re home or halfway around the world.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      <strong>Result?</strong> The family enjoys real automation that “just works.” They feel secure, every device is visible and connected, and they have peace of mind—no drama, no endless app-switching. It’s smart home living, finally delivered.
    </p>
  </div>

  <!-- Customer Story 2 -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 mb-10">
    <h2 class="text-2xl font-semibold mb-4">Customer Story #2: Legacy Unlocked—C-Bus and Modern Smart Control</h2>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      Our second customer had invested in a premium C-Bus lighting system nearly 20 years ago, but without a true controller or usable access. Making changes meant calling a specialist at $600 an hour. Smart, but stuck in the past.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      KTP Digital put Home Assistant in front of their C-Bus system—unlocking full control and automation through a simple app and dashboard. We replaced their expensive alarm panel with a new one for just \$400, then implemented Ubiquiti AI-powered security cameras and Ubiquiti Access on the doors and gates. <strong>All camera footage is securely backed up to a fully managed QNAP NAS, so nothing is ever lost.</strong> Air conditioning and heating now work right from the app. We added new Z-Wave sensors for motion, lighting, and water leaks. If a leak is detected in a critical area, an alert is sent and the mains water is automatically disabled—no more flood risk.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      The customer can finally use their C-Bus lighting investment to the fullest, managed directly through the Home Assistant app and UI. Their favourite new feature? <strong>Remote unlocking of the front door via facial recognition</strong>. Now, with an armful of groceries, they simply walk up and nudge the door open—no keys, no fuss. And for visitors or family who might be confused at the door, our system detects when someone is “lingering” at the front entrance and provides an audio announcement with instructions to ring the doorbell.
    </p>
    <p class="text-base text-gray-700 dark:text-gray-300 mb-4">
      We have yet to find a smart home integration challenge we couldn't solve with Home Assistant. It works seamlessly with HomeKit, Google Home, and Alexa—often as subcomponents that Home Assistant polishes and controls. Our only limit is your imagination.
    </p>
  </div>

  <div class="mb-10 text-center">
    <a href="contact.php" class="inline-block px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow hover:bg-blue-800 transition">
      Book a Home Automation Consult
    </a>
  </div>

  <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-lg shadow mt-10">
    <h2 class="font-semibold text-lg mb-4 text-center">Why Home Assistant and KTP?</h2>
    <div class="text-base text-gray-700 dark:text-gray-300 mb-4 text-center">
      With KTP Digital, Home Assistant becomes more than an app—it’s the open-source heart of a secure, flexible, future-ready home. We build systems for real life, not just for show.
    </div>
    <div class="text-base text-gray-700 dark:text-gray-300 mb-2 text-center">
      <strong>Connect it all, with confidence.</strong> Home Assistant supports <a href="https://www.home-assistant.io/integrations/" class="underline text-blue-600 dark:text-blue-400" target="_blank" rel="noopener">over 3,200 integrations</a>—more than any other platform. That means you can connect nearly any device, brand, or service, all in one place.
    </div>
    <div class="text-base text-gray-700 dark:text-gray-300 mb-2 text-center">
      <strong>Join a global movement.</strong> With over <strong>2 million installs worldwide</strong>, Home Assistant is trusted and actively developed by a worldwide community of tinkerers and pros. You’re never alone—and your system only gets better.
    </div>
    <div class="text-base text-gray-700 dark:text-gray-300 mb-2 text-center">
      <strong>No brand lock-in.</strong> Mix and match the best gear for your needs—never limited to a single vendor.
    </div>
    <div class="text-base text-gray-700 dark:text-gray-300 mb-2 text-center">
      <strong>Ongoing support, troubleshooting, and upgrades.</strong> KTP Digital is with you every step of the way—so you’re never left stranded.
    </div>
    <div class="text-base text-gray-700 dark:text-gray-300 text-center">
      <strong>Privacy and security first.</strong> Every install is secure, private, and ready for whatever comes next.
    </div>
  </div>

  <div class="mt-12 text-sm text-gray-500 dark:text-gray-400 text-center">
    No more “just Google it.” KTP Digital delivers real-life automation—done right, for your family.
  </div>
</section>
HTML;

renderLayout($page_title, $content, '', $page_description);
?>
