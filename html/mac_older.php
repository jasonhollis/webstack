<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';
$page_title = "Apple Technology Consulting – Since 1984";
$page_desc  = "Mac, iPhone, iPad, Apple Silicon consulting and business support in Australia – KTP Digital, experts since the original Macintosh.";

// Inject meta tags via layout (if supported)
$meta = <<<HTML
  <meta name="description" content="$page_desc">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:title" content="$page_title">
  <meta property="og:description" content="$page_desc">
  <meta property="og:image" content="https://www.ktp.digital/images/mac/hero.jpg">
  <meta property="og:url" content="https://www.ktp.digital/mac.php">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="$page_title">
  <meta name="twitter:description" content="$page_desc">
  <meta name="twitter:image" content="https://www.ktp.digital/images/mac/hero.jpg">
HTML;

$content = <<<HTML
<div class="min-h-screen px-6 py-10 flex items-center justify-center" style="background: url('images/mac/hero.jpg') no-repeat center center fixed; background-size: cover;">
  <div class="bg-black bg-opacity-70 rounded-lg p-8 max-w-4xl">
    <h1 class="text-4xl font-extrabold mb-6 text-blue-200">Apple Technology — Since 1984</h1>
    <p class="text-lg mb-4 leading-relaxed text-white">
      I’ve been working with Apple technology since the original Macintosh launch in 1984. From the first GUI to Apple Silicon, I’ve seen — and supported — every generation.
    </p>
    <p class="mt-6 text-lg text-blue-300 italic">
      “On January 24th, Apple Computer will introduce Macintosh. And you'll see why 1984 won't be like '1984.'”
    </p>
  </div>
</div>
HTML;

renderLayout($page_title, $content, $meta);
