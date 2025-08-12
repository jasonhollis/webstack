<?php
// Function to render the layout
function renderLayout($page_title, $content, $extra_styles = '', $page_desc = '') {
    // Set default values
    if (!isset($GLOBALS['fullbleed'])) $GLOBALS['fullbleed'] = false;
    if (!isset($GLOBALS['use_orbitron'])) $GLOBALS['use_orbitron'] = false;
    if (!isset($GLOBALS['hide_nav'])) $GLOBALS['hide_nav'] = false;
    if (!isset($GLOBALS['meta'])) $GLOBALS['meta'] = '';
    if (!isset($GLOBALS['canonical'])) $GLOBALS['canonical'] = '';
    if (!isset($GLOBALS['og_image'])) $GLOBALS['og_image'] = '';
    
    $fullbleed = $GLOBALS['fullbleed'];
    $use_orbitron = $GLOBALS['use_orbitron'];
    $hide_nav = $GLOBALS['hide_nav'];
    $meta = $GLOBALS['meta'];
    $canonical = $GLOBALS['canonical'];
    
    // Generate meta tags if not provided
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
HTML;
    }
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?></title>
  <?php if ($canonical): ?><link rel="canonical" href="<?= htmlspecialchars($canonical) ?>" /><?php endif; ?>
  <?= $meta ?>
  <link rel="icon" type="image/png" href="/images/logos/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=<?= $use_orbitron ? 'Orbitron:wght@400;700' : 'Inter:wght@400;700;900' ?>&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <style>
    :root {
      --bg: #f6f9fc;
      --dark: #000;
      --white: #fff;
      --primary: #308dff;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: <?= $use_orbitron ? "'Orbitron', sans-serif" : "'Inter', sans-serif" ?>;
      background: var(--bg);
      color: var(--dark);
      padding-top: 60px; /* Account for fixed nav */
    }
    main {
      max-width: <?= $fullbleed ? '100%' : '1200px' ?>;
      margin: 0 auto;
      padding: <?= $fullbleed ? '0' : '2rem' ?>;
      min-height: calc(100vh - 200px);
    }
    header, footer {
      background: var(--white);
      padding: 1rem 2rem;
    }
    footer {
      background: #1e293b;
      color: white;
      font-size: 0.9rem;
      text-align: center;
      margin-top: 3rem;
    }
    .cookie-banner {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #1e293b;
      color: var(--white);
      padding: 1rem;
      text-align: center;
      font-size: 0.85rem;
      z-index: 9999;
      box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
    }
    .cookie-banner button {
      margin-left: 1rem;
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      cursor: pointer;
      font-family: inherit;
    }
    .cookie-banner button:hover {
      background: #2070df;
    }
    <?= $extra_styles ?>
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (!localStorage.getItem('cookiesAccepted')) {
        const banner = document.getElementById('cookieBanner');
        if (banner) {
          banner.style.display = 'block';
          document.getElementById('acceptCookies').onclick = function () {
            localStorage.setItem('cookiesAccepted', 'true');
            banner.style.display = 'none';
          };
        }
      }
    });
  </script>
</head>
<body>

<?php if (!$hide_nav): ?>
  <?php include 'nav_enhanced.php'; ?>
<?php endif; ?>

<main>
<?= $content ?>
</main>

<footer>
  <p>&copy; <?= date('Y') ?> KTP Digital - Premium IT Solutions</p>
  <p>Melbourne | Enterprise | Automation | Security</p>
</footer>

<div id="cookieBanner" class="cookie-banner" style="display:none;">
  <p>We use cookies to improve your experience. <button id="acceptCookies">Accept</button></p>
</div>

</body>
</html>
<?php
}
?>