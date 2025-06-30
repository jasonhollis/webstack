<?php
function renderLayout($page_title, $content, $meta = '', $page_desc = '', $canonical = '', $og_image = '') {
    if (!$meta && $page_desc) {
        $meta = <<<HTML
        <meta name="description" content="$page_desc" />
        <meta name="generator" content="KTP Webstack – GPT + BBEdit workflow" />
        <meta name="keywords" content="home automation, Home Assistant, smart home, support, KTP Digital, app fatigue, security, HomeKit, Zigbee, Z-Wave" />
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
    <link rel="stylesheet" href="/assets/css/hass-theme.css" />
        <!-- Cookie banner CSS -->
        <link rel="stylesheet" href="/assets/css/cookie-banner.css" />
        <title><?php echo htmlspecialchars($page_title); ?></title>
        <?php echo $meta; ?>
        <style>
            body {
                background: #f5f8fa;
            }
        </style>
    </head>
    <body class="min-h-0 text-gray-900 bg-[#f5f8fa] px-4 sm:px-6 pt-10 pb-8">
        <!-- Cookie banner JS -->
        <script src="/assets/js/cookie-banner.js"></script>

        <!-- Site header/navigation -->
        <?php if (file_exists(__DIR__ . '/nav.php')) include __DIR__ . '/nav.php'; ?>

        <main>
            <?php echo $content; ?>
        </main>

        <!-- Footer -->
        <footer class="mt-12 text-sm text-gray-900 px-4 sm:px-0">
            <div class="bg-blue-100/90 rounded-xl max-w-xl mx-auto py-4 px-6 text-center space-y-3 shadow-lg">
                <div>
                    &copy; <?php echo date("Y"); ?> KTP Digital Pty Ltd. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center items-center gap-4 text-xs">
                    <span class="flex items-center space-x-1">
                        <a href="https://openai.com/chatgpt" target="_blank" rel="noopener">
                            <img src="/images/icons/chatgpt-mark.png" alt="ChatGPT" class="h-5 w-5" />
                        </a>
                        <span>Powered by GPT</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <a href="https://www.barebones.com/products/bbedit/" target="_blank" rel="noopener">
                            <img src="/images/icons/bbedit.png" alt="BBEdit" class="h-5 w-5" />
                        </a>
                        <span>Crafted in BBEdit</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <a href="https://github.com/jasonhollis/webstack" target="_blank" rel="noopener">
                            <img src="/images/icons/github.png" alt="GitHub" class="h-5 w-5" />
                        </a>
                        <span>Versioned with GitHub</span>
                    </span>
                    <a href="/methodology.php" class="underline hover:text-black whitespace-nowrap">Methodology</a>
                    <a href="/privacy-policy.php" class="underline hover:text-black whitespace-nowrap">Privacy Policy</a>
                </div>
            </div>
        </footer>
    </body>
    </html>
    <?php
    echo ob_get_clean();
}
?>
