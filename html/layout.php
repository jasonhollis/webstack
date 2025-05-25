<?php include __DIR__ . "/analytics_logger.php"; ?>
<?php
function renderLayout($page_title, $content, $meta = '', $page_desc = '', $canonical = '', $og_image = '') {
    $version = @trim(file_get_contents(__DIR__ . '/VERSION'));
    $updated = date('Y-m-d H:i:s');

    if (!$meta && $page_desc) {
        $meta = <<<HTML
        <meta name="description" content="$page_desc" />
        <meta name="generator" content="KTP Webstack – GPT + BBEdit workflow" />
        <meta name="keywords" content="automation, macOS, Home Assistant, GPT, HomeKit, BBEdit, PHP, Z-Wave, TailwindCSS" />
        <meta property="og:title" content="$page_title" />
        <meta property="og:description" content="$page_desc" />
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="$page_title" />
        <meta name="twitter:description" content="$page_desc" />
HTML;
        if ($og_image) {
            $meta .= "\n        <meta property=\"og:image\" content=\"$og_image\" />";
            $meta .= "\n        <meta name=\"twitter:image\" content=\"$og_image\" />";
        }
        if ($canonical) {
            $meta .= "\n        <link rel=\"canonical\" href=\"$canonical\" />";
        }
    }

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.tailwindcss.com/3.4.1"></script>
        <title><?php echo htmlspecialchars($page_title); ?></title>
        <?php echo $meta; ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "<?php echo htmlspecialchars($page_title); ?>",
          "description": "<?php echo htmlspecialchars($page_desc); ?>",
          "url": "https://www.ktp.digital<?php echo $_SERVER['REQUEST_URI']; ?>",
          "publisher": {
            "@type": "Organization",
            "name": "KTP Digital",
            "url": "https://www.ktp.digital",
            "logo": {
              "@type": "ImageObject",
              "url": "https://www.ktp.digital/images/ktp-logo-dark.svg"
            }
          }
        }
        </script>
        <style>
            body {
                background-image: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1600&q=80');
                background-size: cover;
                background-position: center;
            }
            .backdrop {
                background-color: rgba(0, 0, 0, 0.65);
            }
        </style>
    </head>
    <body class="min-h-screen text-white px-4 sm:px-6 pt-20 pb-8">
        <?php include __DIR__ . '/nav.php'; ?>

        <main class="flex justify-center mt-12">
            <div class="backdrop w-full max-w-5xl p-6 sm:p-8 rounded-xl shadow-lg text-center space-y-6">
                <?php echo $content; ?>
                <div class="mt-6 text-sm text-gray-200">
                    <p><strong>Current Version:</strong> <span class="font-mono text-blue-600"><?php echo htmlspecialchars($version); ?></span></p>
                    <p class="text-xs mt-1">Last updated: <?php echo $updated; ?></p>
                </div>
            </div>
        </main>

        <footer class="mt-12 text-sm text-gray-900 px-4 sm:px-0">
            <div class="bg-blue-100/90 rounded-xl max-w-xl mx-auto py-4 px-6 text-center space-y-3 shadow-lg">
                <div>
                    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center items-center gap-4 text-xs">
                    <span class="flex items-center space-x-1">
                        <a href="https://openai.com/chatgpt" target="_blank" rel="noopener noreferrer">
                            <img src="/images/icons/chatgpt-mark.png" alt="ChatGPT" class="h-5 w-5" />
                        </a>
                        <span>Powered by GPT</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <a href="https://www.barebones.com/products/bbedit/" target="_blank" rel="noopener noreferrer">
                            <img src="/images/icons/bbedit.png" alt="BBEdit" class="h-5 w-5" />
                        </a>
                        <span>Crafted in BBEdit</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <a href="https://github.com/jasonhollis/webstack" target="_blank" rel="noopener noreferrer">
                            <img src="/images/icons/github.png" alt="GitHub" class="h-5 w-5" />
                        </a>
                        <span>Versioned with GitHub</span>
                    </span>
                    <a href="/methodology.php" class="underline hover:text-black whitespace-nowrap">
                        Methodology
                    </a>
                </div>
            </div>
        </footer>
    </body>
    </html>
    <?php
    echo ob_get_clean();
}
?>
