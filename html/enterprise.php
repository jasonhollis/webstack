<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Enterprise Consulting";
$page_desc  = "Vendor-agnostic enterprise consulting for Zero Trust, IAM, API security, and hybrid cloud. Experienced delivery across government, finance, and global business.";

$content = <<<HTML
<section class="max-w-6xl mx-auto p-6">
  <h1 class="text-4xl font-bold mb-4">🏢 Enterprise Consulting</h1>
  <p class="mb-6 text-lg">
    With decades of leadership across APJ, EMEA, and the US, we bring a pragmatic, outcome-driven approach to complex enterprise IT challenges.
  </p>
  <ul class="list-disc list-inside text-left text-lg space-y-2">
    <li>Identity Management & Zero Trust Architecture</li>
    <li>API security, governance, and integration</li>
    <li>Endpoint, data, and infrastructure protection</li>
    <li>IAM, PAM, CMDB, and ITSM strategy</li>
    <li>Vendor-agnostic recommendations and hands-on deployment</li>
  </ul>
  <p class="mt-6 text-lg">
    We've delivered outcomes for governments, financial institutions, healthcare providers, and major multinationals.
  </p>
</section>
HTML;

renderLayout($page_title, $content, '', $page_desc);
