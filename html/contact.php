<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Contact KTP Digital";
$page_desc  = "Get in touch with KTP Digital for expert IT consulting, automation, and secure networking solutions.";

$content = <<<HTML
<section class="max-w-4xl mx-auto p-6">
  <h1 class="text-4xl font-bold mb-4">📬 Contact</h1>
  <p class="text-lg mb-4">
    Reach out to us for a consult, project quote, or just to explore ideas. We're happy to help.
  </p>
  <p class="text-lg">
    📧 Email: <a href="mailto:info@ktp.digital" class="underline text-blue-300">info@ktp.digital</a>
  </p>
</section>
HTML;

renderLayout($page_title, $content, '', $page_desc);
