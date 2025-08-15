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

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
    <!-- Home Automation -->
    <a href="/home-automation.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200 flex flex-col items-center">
      <img src="/images/icons/home-assistant.svg" alt="Home Assistant logo" class="w-12 h-12 mb-3" loading="lazy" style="min-width:48px;min-height:48px;">
      <h2 class="text-xl font-semibold mb-2 text-center">🏠 Home Automation</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base text-center">
        Complete smart home solutions with Home Assistant. Control everything from one app. No more app fatigue.
      </p>
    </a>

    <!-- Business Automation -->
    <a href="/smallbiz.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200">
      <h2 class="text-xl font-semibold mb-2">💼 Business Automation</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base">
        Streamline operations with automated workflows, Mac/Windows integration, and cloud services that scale with your business.
      </p>
    </a>

    <!-- Network Infrastructure -->
    <a href="/network.php" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-xl transition duration-200">
      <h2 class="text-xl font-semibold mb-2">🔒 Network & Security</h2>
      <p class="text-gray-700 dark:text-gray-300 text-base">
        Enterprise-grade networking with UniFi, secure VPNs, and bulletproof infrastructure that just works.
      </p>
    </a>
  </div>

  <!-- Additional Service Links -->
  <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 mb-8">
    <h3 class="text-lg font-semibold mb-4 text-center">Explore Our Automation Services</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
      <a href="/success-stories.php" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
        Customer Stories
      </a>
      <a href="/integration.php" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
        Device Integration
      </a>
      <a href="/mac.php" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
        Apple/Mac Automation
      </a>
      <a href="/ubiquiti.php" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
        UniFi Solutions
      </a>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="text-center bg-blue-50 dark:bg-blue-900/20 rounded-lg p-8">
    <h3 class="text-2xl font-semibold mb-4">Ready to Automate?</h3>
    <p class="text-gray-700 dark:text-gray-300 mb-6">
      Whether it's your home, business, or both - we'll design the perfect automation solution for you.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="/home_automation_form.php" class="inline-block px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow hover:bg-blue-800 transition">
        Home Automation Quote
      </a>
      <a href="/small_business_form.php" class="inline-block px-6 py-3 bg-green-700 text-white font-semibold rounded-lg shadow hover:bg-green-800 transition">
        Business IT Quote
      </a>
    </div>
  </div>

  <div class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
    Every automation is tested across macOS, Linux, and embedded environments. Built to deploy. Built to last.
  </div>
</section>
HTML;

$canonical = "https://www.ktp.digital/automation.php";
renderLayout($page_title, $content, '', $page_description, $canonical);
?>
