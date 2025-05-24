<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "KTP Digital | Automation Hub";
$page_description = "Explore how KTP Digital builds automation into every layer—from macOS workflows and smart homes to custom cross-platform logic.";
$page_keywords = "automation, Home Assistant, macOS Shortcuts, Z-Wave, Apple Automator, custom scripting, HomeKit, platform automation, smart home, business automation";

$content = <<<HTML
<section class="px-6 py-16 max-w-5xl mx-auto">
  <h1 class="text-4xl font-bold mb-4">⚙️ Automation Hub</h1>
  <p class="text-lg mb-8">
    At KTP Digital, automation isn’t an add-on—it’s in our DNA. From macOS power workflows to enterprise triggers and smart home intelligence, we build systems that think ahead, respond instantly, and scale smoothly.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <a href="platform-automation.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200">
      <h2 class="text-xl font-semibold mb-2">🖥️ Platform & Productivity</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base">
        From Shortcuts and shell scripts to SSH deploys and webhooks—KTP creates seamless digital workflows for devs, creators, and teams.
      </p>
    </a>

    <a href="home-automation.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200">
      <h2 class="text-xl font-semibold mb-2">🏡 Home & Environmental</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base">
        With deep expertise in Home Assistant, Fibaro, HomeKit, and smart sensors, KTP delivers rock-solid home automation for any environment.
      </p>
    </a>

    <a href="custom-automation.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200">
      <h2 class="text-xl font-semibold mb-2">🧠 Custom Logic & Agents</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base">
        Need to automate something unique? KTP engineers bespoke solutions—cross-platform, agent-assisted, and battle-tested.
      </p>
    </a>
  </div>

  <div class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
    Every automation is tested across macOS, Linux, and embedded environments. Built to deploy. Built to last.
  </div>
</section>
HTML;

renderLayout($page_title, $content, '', $page_description);
?>
