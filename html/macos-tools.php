<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "macOS Tools | KTP Digital";
$page_desc  = "Explore how we use Shortcuts, Automator, Yoink, SSH, SCP, Homebrew, and full Xcode workflows to automate our web platform. No cPanel. No GUI. Just code.";

$meta = <<<HTML
<meta name="description" content="$page_desc" />
<meta name="generator" content="KTP Webstack – macOS automation, CLI-first deployment, AI-powered workflows" />
<meta property="og:title" content="$page_title" />
<meta property="og:description" content="$page_desc" />
<meta property="og:url" content="https://www.ktp.digital/macos-tools.php" />
<meta property="og:type" content="article" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="$page_title" />
<meta name="twitter:description" content="$page_desc" />
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TechArticle",
  "headline": "$page_title",
  "author": { "@type": "Organization", "name": "KTP Digital" },
  "publisher": { "@type": "Organization", "name": "KTP Digital" },
  "datePublished": "2025-05-23",
  "description": "$page_desc",
  "url": "https://www.ktp.digital/macos-tools.php"
}
</script>
HTML;

$content = <<<HTML
<section class="max-w-4xl mx-auto p-6">
  <h1 class="text-4xl font-bold mb-6">🍎 macOS Tools at KTP Digital</h1>
  <p class="text-lg mb-6">
    We use macOS not just as a development platform — but as an orchestrated, secure dispatch system. From screenshots to text capture, every asset is logged, staged, and delivered using battle-tested tools and a custom automation pipeline.
  </p>

  <h2 class="text-2xl font-semibold mt-10 mb-4">📸 Apple Shortcuts + Automator</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>Capture screenshots, clipboard, or text — and dispatch with a single trigger</li>
    <li>Shortcuts and legacy Automator scripts route content to SCP pushers</li>
    <li>Integrated with our shell scripts for append, upload, and log injection</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🪄 Yoink Clipboard Layer</h2>
  <div class="flex items-center space-x-2 mb-4">
    <img src="/images/icons/yoink.png" alt="Yoink" class="h-6 w-6" />
    <a href="https://eternalstorms.at/yoink/mac/" target="_blank" rel="noopener" class="text-blue-400 underline text-lg">Yoink for Mac</a>
  </div>
  <p class="text-lg mb-6">
    Yoink acts as our visual clipboard queue — screenshots, logs, images, and drag-and-drop snippets are staged here before dispatch to the server.
  </p>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🔐 Secure Upload via SSH + SCP</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>Key-only SSH is enforced across all SCP transactions</li>
    <li>Shortcuts call CLI wrappers with file and log payloads</li>
    <li>Scripts like <code>add_image_to_iteration_log.sh</code> and <code>append_objective.sh</code> handle ingest</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🍺 CLI Power with Homebrew</h2>
  <div class="flex items-center space-x-2 mb-4">
    <img src="/images/icons/homebrew.svg" alt="Homebrew" class="h-6 w-6" />
    <a href="https://brew.sh" target="_blank" rel="noopener" class="text-blue-400 underline text-lg">Homebrew</a>
  </div>
  <p class="text-lg mb-6">
    We use Homebrew to manage <code>pngpaste</code>, <code>jq</code>, <code>curl</code>, and other essentials. It ensures our automation stack is portable, lightweight, and script-friendly.
  </p>

  <h2 class="text-2xl font-semibold mt-10 mb-4">📦 Xcode Workflows (Coming Soon)</h2>
  <p class="text-lg mb-6">
    We're already developing secure, signed macOS CLI agents using Xcode and Swift — designed to complement our shell-based automation for even faster, more secure interaction with our platform.
  </p>

  <h2 class="text-2xl font-semibold mt-10 mb-4">💡 Why It Matters</h2>
  <p class="text-lg mb-6">
    We don't rely on GUIs or browser upload forms. Everything is logged, versioned, and visible — because that's how modern web engineering should work. All of it begins here, on the Mac.
  </p>

  <p class="text-sm text-gray-400 mt-8">
    Last updated: <?php echo date("Y-m-d H:i:s"); ?> AEST
  </p>
</section>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
