<?php include __DIR__."/analytics_logger.php"; ?>
<?php include __DIR__."/analytics_logger.php"; ?>
<?php
require 'layout.php';

$page_title = "Our Methodology | KTP Digital";
$page_desc  = "Explore how KTP Digital builds secure, AI-assisted, handcrafted web systems using a directive-driven, version-controlled CLI workflow and macOS automation.";

$meta = <<<HTML
<meta name="description" content="$page_desc" />
<meta name="generator" content="KTP Webstack – GPT + BBEdit workflow" />
<meta property="og:title" content="$page_title" />
<meta property="og:description" content="$page_desc" />
<meta property="og:url" content="https://www.ktp.digital/methodology.php" />
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
  "url": "https://www.ktp.digital/methodology.php"
}
</script>
HTML;

$content = <<<HTML
<section class="max-w-4xl mx-auto p-6">
  <h1 class="text-4xl font-bold mb-6">🛠️ Our Methodology</h1>
  <p class="text-lg mb-6">
    KTP Digital combines handcrafted development, AI-assisted iteration, and secure automation to build modern web systems with clarity, control, and precision.
  </p>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🤝 Human + AI Pairing (Live)</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>ChatGPT 4-turbo is used as a tactical assistant — never blindly</li>
    <li>All code is reviewed, refined, and tested by a human before deployment</li>
    <li>AI helps accelerate clean thinking, not just faster typing</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">📜 Directive-Based AI Governance</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li><code>PROJECT_DIRECTIVES.md</code> governs all workflow rules</li>
    <li>No GUI merges, no drag-and-drop, no partial edits</li>
    <li>EOF replacements or sed-safe single-line changes only</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🚀 Agile Without the Ceremony</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>Each version has scoped, logged objectives in Markdown</li>
    <li>Every bump triggers git + ZIP snapshot with time-indexed rollback</li>
    <li>Deliverables are deployed live — nothing is hypothetical</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🖋 100% Handcrafted HTML, PHP, and Bash</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>No CMS, no frameworks — just clean, readable, battle-tested code</li>
    <li>Tailwind, PHP, and Bash are used natively</li>
    <li>Everything deploys via CLI — no web editors, no cPanel</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🔒 Secure CLI Upload & macOS Automation</h2>
  <ul class="list-disc list-inside mb-6 space-y-2 text-lg">
    <li>Apple Shortcuts trigger screenshot and clipboard capture</li>
    <li>Yoink enables drag-based asset staging before upload (<a href="https://eternalstorms.at/yoink/mac/" target="_blank" rel="noopener" class="underline text-blue-400">Yoink for Mac</a>)</li>
    <li>Key-only SSH + SCP dispatch sends content directly to server endpoints</li>
    <li>Scripts like <code>append_objective.sh</code> and <code>add_image_to_iteration_log.sh</code> log inputs securely</li>
  </ul>

  <h2 class="text-2xl font-semibold mt-10 mb-4">🧰 Mac Tools & Open Source Preferences</h2>
  <p class="text-lg mb-6">
    We use <a href="https://brew.sh" class="underline text-blue-400" target="_blank" rel="noopener">Homebrew</a> to manage terminal utilities like <code>jq</code>, <code>pngpaste</code>, and <code>curl</code>. Our entire stack leans heavily on open-source tooling — portable, scriptable, and inspectable. Look out for public releases of our own Mac automation helpers soon at <a href="/macos-tools.php" class="underline">/macos-tools</a>.
  </p>

  <p class="text-sm text-gray-400 mt-8">
    Last updated: <?php echo date("Y-m-d H:i:s"); ?> AEST
  </p>
</section>
HTML;

renderLayout($page_title, $content, $meta, $page_desc);
