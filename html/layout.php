<?php
if (!isset($fullbleed)) $fullbleed = false;
if (!isset($use_orbitron)) $use_orbitron = false;
if (!isset($hide_nav)) $hide_nav = false;
if (!isset($meta)) $meta = '';
if (!isset($canonical)) $canonical = '';
if (!isset($og_image)) $og_image = '';
if (!isset($page_desc)) $page_desc = '';

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
    }
    main {
      max-width: <?= $fullbleed ? '100%' : '1200px' ?>;
      margin: 0 auto;
      padding: <?= $fullbleed ? '0' : '2rem' ?>;
    }
    header, footer {
      background: var(--white);
      padding: 1rem 2rem;
      border-bottom: 1px solid #ccc;
    }
    footer {
      border-top: 1px solid #ccc;
      border-bottom: none;
      font-size: 0.9rem;
      text-align: center;
    }
    .cookie-banner {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: var(--dark);
      color: var(--white);
      padding: 1rem;
      text-align: center;
      font-size: 0.85rem;
      z-index: 9999;
    }
    .cookie-banner button {
      margin-left: 1rem;
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 0.5rem 1rem;
      cursor: pointer;
      font-family: inherit;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (!localStorage.getItem('cookiesAccepted')) {
        const banner = document.getElementById('cookieBanner');
        banner.style.display = 'block';
        document.getElementById('acceptCookies').onclick = function () {
          localStorage.setItem('cookiesAccepted', 'true');
          banner.remove();
        };
      }
    });
  </script>
</head>
<body>

<?php if (!$hide_nav): ?>
<header>
  <?php include 'nav.php'; ?>
</header>
<?php endif; ?>

<main>
<?php ob_start(); ?>
