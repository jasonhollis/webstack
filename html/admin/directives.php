<?php
// directives.php: View the current PROJECT_DIRECTIVES.md securely

$page = 'directives';
$directives_path = '/opt/webstack/objectives/PROJECT_DIRECTIVES.md';
$content = is_readable($directives_path) ? file_get_contents($directives_path) : "Not found or not readable.";

// Simple Markdown rendering (uses <pre> for code, <h1>-<h3>, <ul>, <li>, <b>, <i>)
function markdown($text) {
    // Replace Markdown headers
    $text = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $text);
    $text = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $text);
    $text = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $text);
    // Replace bold
    $text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text);
    // Replace italics
    $text = preg_replace('/\*(.*?)\*/', '<i>$1</i>', $text);
    // Lists
    $text = preg_replace('/^- (.*)$/m', '<li>$1</li>', $text);
    $text = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $text, 1); // only wrap first group for safety
    // Inline code
    $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
    // Horizontal rules
    $text = preg_replace('/^\s*---+\s*$/m', '<hr>', $text);
    // Paragraphs
    $text = preg_replace('/\n{2,}/', "</p><p>", $text);
    $text = '<p>' . $text . '</p>';
    return $text;
}
?>
<?php include 'admin_nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Directives – KTP Webstack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Project directives and workflow policy for the KTP Webstack system.">
  <link rel="stylesheet" href="/assets/tailwind.min.css">
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
  <main class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 flex items-center">
      <span class="mr-2">📚</span>Project Directives
    </h1>
    <div class="prose max-w-none dark:prose-invert">
      <?= markdown($content) ?>
    </div>
    <footer class="mt-12 text-xs text-gray-500">
      Last changed: <?= date("Y-m-d H:i:s T", filemtime($directives_path)) ?>
    </footer>
  </main>
</body>
</html>
