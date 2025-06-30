<?php
$page_title = "Privacy & Cookie Policy";
$page_desc  = "Our approach to privacy, data collection, and cookie usage at KTP Digital.";
$canonical  = "https://www.ktp.digital/privacy-policy.php";
ob_start();
?>
<div class="max-w-3xl mx-auto py-8">
  <h1 class="text-3xl font-bold mb-4">Privacy & Cookie Policy</h1>

  <h2 class="text-xl font-semibold mt-6 mb-2">1. Introduction</h2>
  <p>We respect your privacy and are committed to protecting your personal data. This policy explains how we collect, use, and safeguard your information.</p>

  <h2 class="text-xl font-semibold mt-6 mb-2">2. Information We Collect</h2>
  <ul class="list-disc list-inside">
    <li><strong>Session Cookies:</strong> Essential for site functionality.</li>
    <li><strong>Analytics Cookies:</strong> Used to understand site usage (e.g., Google Analytics).</li>
    <li><strong>Preference Cookies:</strong> Store your consent choice so we don’t prompt you repeatedly.</li>
  </ul>

  <h2 class="text-xl font-semibold mt-6 mb-2">3. How We Use Cookies</h2>
  <p>Cookies help us analyze site traffic and improve user experience. No personal information is stored in analytics cookies.</p>

  <h2 class="text-xl font-semibold mt-6 mb-2">4. Your Choices</h2>
  <p>You can <strong>Accept</strong> or <strong>Decline</strong> non-essential cookies via our banner. To change your choice later, clear your cookies or visit our <a href="/privacy-policy.php">Privacy Policy</a> page.</p>

  <h2 class="text-xl font-semibold mt-6 mb-2">5. Contact Us</h2>
  <p>If you have questions about this policy, please <a href="/contact.php">get in touch</a>.</p>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical);
