<?php
// claude-md.php: View the current CLAUDE.md file securely

require_once 'Parsedown.php';

$page = 'claude_md';
$claude_md_path = '/opt/webstack/CLAUDE.md';

// Handle download request
if (isset($_GET['download']) && file_exists($claude_md_path)) {
    header('Content-Type: text/markdown');
    header('Content-Disposition: attachment; filename="CLAUDE.md"');
    header('Content-Length: ' . filesize($claude_md_path));
    readfile($claude_md_path);
    exit;
}

$content = is_readable($claude_md_path) ? file_get_contents($claude_md_path) : "CLAUDE.md file not found or not readable.";

// Use Parsedown for proper markdown rendering
$Parsedown = new Parsedown();
$html_content = $Parsedown->text($content);
?>
<?php include 'admin_nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CLAUDE.md – KTP Webstack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Claude AI project instructions and guidance for the KTP Webstack system.">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
  <style>
    /* Custom styling for better markdown display */
    .markdown-content {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
      line-height: 1.6;
    }
    .markdown-content h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin: 2rem 0 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #e5e7eb;
    }
    .markdown-content h2 {
      font-size: 2rem;
      font-weight: bold;
      margin: 1.5rem 0 1rem;
      color: #1e40af;
    }
    .markdown-content h3 {
      font-size: 1.5rem;
      font-weight: 600;
      margin: 1.25rem 0 0.75rem;
    }
    .markdown-content h4 {
      font-size: 1.25rem;
      font-weight: 600;
      margin: 1rem 0 0.5rem;
    }
    .markdown-content p {
      margin-bottom: 1rem;
    }
    .markdown-content ul {
      list-style-type: disc;
      padding-left: 2rem;
      margin-bottom: 1rem;
    }
    .markdown-content ol {
      list-style-type: decimal;
      padding-left: 2rem;
      margin-bottom: 1rem;
    }
    .markdown-content li {
      margin-bottom: 0.5rem;
    }
    .markdown-content code {
      background-color: #f3f4f6;
      padding: 0.125rem 0.25rem;
      border-radius: 0.25rem;
      font-family: 'Courier New', Courier, monospace;
      font-size: 0.875rem;
    }
    .markdown-content pre {
      background-color: #1f2937;
      color: #f9fafb;
      padding: 1rem;
      border-radius: 0.5rem;
      overflow-x: auto;
      margin: 1rem 0;
    }
    .markdown-content pre code {
      background-color: transparent;
      padding: 0;
      color: inherit;
    }
    .markdown-content blockquote {
      border-left: 4px solid #3b82f6;
      padding-left: 1rem;
      margin: 1rem 0;
      font-style: italic;
      color: #6b7280;
    }
    .markdown-content hr {
      margin: 2rem 0;
      border-top: 1px solid #e5e7eb;
    }
    .markdown-content a {
      color: #3b82f6;
      text-decoration: underline;
    }
    .markdown-content a:hover {
      color: #2563eb;
    }
    .markdown-content strong {
      font-weight: bold;
    }
    .markdown-content em {
      font-style: italic;
    }
    .markdown-content table {
      width: 100%;
      border-collapse: collapse;
      margin: 1rem 0;
    }
    .markdown-content th {
      background-color: #f3f4f6;
      padding: 0.5rem;
      text-align: left;
      border: 1px solid #e5e7eb;
      font-weight: bold;
    }
    .markdown-content td {
      padding: 0.5rem;
      border: 1px solid #e5e7eb;
    }
    /* Dark mode adjustments */
    @media (prefers-color-scheme: dark) {
      .markdown-content h1 {
        border-bottom-color: #4b5563;
      }
      .markdown-content h2 {
        color: #60a5fa;
      }
      .markdown-content code {
        background-color: #374151;
        color: #f9fafb;
      }
      .markdown-content blockquote {
        color: #9ca3af;
      }
      .markdown-content hr {
        border-top-color: #4b5563;
      }
      .markdown-content th {
        background-color: #374151;
        border-color: #4b5563;
      }
      .markdown-content td {
        border-color: #4b5563;
      }
    }
  </style>
</head>
<body class="bg-white  text-gray-900 ">
  <main class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-4xl font-bold flex items-center">
        <span class="mr-3">🤖</span>CLAUDE.md - AI Project Instructions
      </h1>
      <?php if (file_exists($claude_md_path)): ?>
      <a href="?download=1" 
         class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
         download="CLAUDE.md">
          📥 Download Markdown
      </a>
      <?php endif; ?>
    </div>
    
    <div class="bg-blue-50  border-l-4 border-blue-500 p-4 mb-6 rounded">
      <p class="text-sm">
        This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.
        It contains critical business rules, code standards, and development methodology for the KTP Digital project.
      </p>
    </div>
    
    <div class="markdown-content bg-white  p-6 rounded-lg shadow-lg">
      <?= $html_content ?>
    </div>
    
    <footer class="mt-12 pt-6 border-t border-gray-300 ">
      <div class="flex justify-between items-center text-xs text-gray-500">
        <div>
          <strong>File Location:</strong> <?= $claude_md_path ?>
        </div>
        <div>
          <strong>Last Modified:</strong> <?= date("Y-m-d H:i:s T", filemtime($claude_md_path)) ?>
        </div>
      </div>
      <div class="mt-2 text-xs text-gray-500">
        <strong>File Size:</strong> <?= number_format(filesize($claude_md_path)) ?> bytes
      </div>
    </footer>
  </main>
</body>
</html>