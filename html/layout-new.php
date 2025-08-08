<?php
// Default variables
if (!isset($fullbleed)) $fullbleed = false;
if (!isset($use_bank_gothic)) $use_bank_gothic = false;
if (!isset($hide_nav)) $hide_nav = false;
if (!isset($hide_footer)) $hide_footer = false;
if (!isset($dark_mode)) $dark_mode = false;
if (!isset($meta)) $meta = '';
if (!isset($canonical)) $canonical = '';
if (!isset($og_image)) $og_image = '/images/logos/KTP Logo.png';
if (!isset($page_desc)) $page_desc = 'Premium IT consulting and home automation for Melbourne\'s finest properties';
if (!isset($page_title)) $page_title = 'KTP Digital';
if (!isset($extra_css)) $extra_css = '';
if (!isset($extra_js)) $extra_js = '';

// Generate meta tags if not provided
if (!$meta && $page_desc) {
  $meta = <<<HTML
  <meta name="description" content="$page_desc" />
  <meta name="generator" content="KTP Webstack" />
  <meta name="keywords" content="home automation, enterprise IT, networking, Melbourne, Toorak, Brighton, smart home, UniFi, Tesla, Sonos" />
  <meta property="og:title" content="$page_title" />
  <meta property="og:description" content="$page_desc" />
  <meta property="og:image" content="$og_image" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="$page_title" />
  <meta name="twitter:description" content="$page_desc" />
HTML;
}

// Start output buffering to capture content
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?></title>
  <?php if ($canonical): ?><link rel="canonical" href="<?= htmlspecialchars($canonical) ?>" /><?php endif; ?>
  <?= $meta ?>
  <link rel="icon" type="image/png" href="/images/logos/favicon.png">
  
  <!-- Fonts -->
  <?php if ($use_bank_gothic): ?>
  <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
  <?php endif; ?>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS for modern styling -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <style>
    :root {
      --bg-light: #f8fafc;
      --bg-dark: #0f172a;
      --text-light: #1e293b;
      --text-dark: #f1f5f9;
      --primary: #3b82f6;
      --secondary: #06b6d4;
      --accent: #fbbf24;
    }
    
    * { 
      box-sizing: border-box; 
    }
    
    body {
      margin: 0;
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: <?= $dark_mode ? 'var(--bg-dark)' : 'var(--bg-light)' ?>;
      color: <?= $dark_mode ? 'var(--text-dark)' : 'var(--text-light)' ?>;
      <?php if ($dark_mode): ?>
      background-image: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      <?php endif; ?>
    }
    
    <?php if ($use_bank_gothic): ?>
    .bank-gothic {
      font-family: 'bank-gothic-bt', 'Orbitron', sans-serif;
      font-weight: 500;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }
    <?php endif; ?>
    
    main {
      <?php if (!$fullbleed): ?>
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1rem;
      <?php endif; ?>
      min-height: calc(100vh - 200px);
    }
    
    /* Cookie Banner Styles */
    .cookie-banner {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(135deg, #1e3a8a 0%, #1e293b 100%);
      color: white;
      padding: 1rem;
      text-align: center;
      font-size: 0.875rem;
      z-index: 9999;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
      display: none;
    }
    
    .cookie-banner button {
      margin-left: 1rem;
      background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
      color: white;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 9999px;
      cursor: pointer;
      font-weight: 600;
      transition: transform 0.2s;
    }
    
    .cookie-banner button:hover {
      transform: translateY(-2px);
    }
    
    /* Navigation adjustments for fixed header */
    body.has-fixed-nav {
      padding-top: 60px;
    }
    
    <?= $extra_css ?>
  </style>
  
  <?= $extra_js ?>
</head>
<body class="<?= $dark_mode ? 'dark' : '' ?> <?= !$hide_nav ? 'has-fixed-nav' : '' ?>">

<?php if (!$hide_nav): ?>
  <?php include __DIR__ . '/nav.php'; ?>
<?php endif; ?>

<main class="<?= $fullbleed ? 'fullbleed' : '' ?>">
  <!-- Content will be inserted here -->
  <?php 
  // This is where the magic happens - we'll capture the content
  // The page using this layout will set $content variable
  ?>
</main>

<?php if (!$hide_footer): ?>
<footer class="bg-slate-900 text-white py-12 mt-20">
  <div class="container mx-auto px-4">
    <div class="grid md:grid-cols-4 gap-8 mb-8">
      <!-- Company -->
      <div>
        <h3 class="font-bold text-lg mb-4">KTP Digital</h3>
        <p class="text-gray-400 text-sm">
          Premium IT consulting and home automation for Melbourne's elite.
        </p>
      </div>
      
      <!-- Services -->
      <div>
        <h3 class="font-bold text-lg mb-4">Services</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><a href="/automation.php" class="hover:text-cyan-400 transition">Home Automation</a></li>
          <li><a href="/network.php" class="hover:text-cyan-400 transition">Enterprise Networking</a></li>
          <li><a href="/security.php" class="hover:text-cyan-400 transition">Cybersecurity</a></li>
          <li><a href="/enterprise.php" class="hover:text-cyan-400 transition">Managed IT</a></li>
        </ul>
      </div>
      
      <!-- Locations -->
      <div>
        <h3 class="font-bold text-lg mb-4">Service Areas</h3>
        <ul class="space-y-2 text-sm text-gray-400">
          <li>Toorak</li>
          <li>Brighton</li>
          <li>Armadale</li>
          <li>South Yarra</li>
        </ul>
      </div>
      
      <!-- Contact -->
      <div>
        <h3 class="font-bold text-lg mb-4">Contact</h3>
        <p class="text-sm text-gray-400 mb-2">
          <a href="tel:1300587348" class="hover:text-cyan-400 transition">1300 KTP DIG</a>
        </p>
        <p class="text-sm text-gray-400">
          <a href="/contact.php" class="hover:text-cyan-400 transition">Get a Quote</a>
        </p>
      </div>
    </div>
    
    <div class="border-t border-slate-800 pt-8 text-center text-sm text-gray-400">
      <p>&copy; <?= date('Y') ?> KTP Digital. All rights reserved. | 
        <a href="/privacy-policy.php" class="hover:text-cyan-400 transition">Privacy Policy</a>
      </p>
    </div>
  </div>
</footer>
<?php endif; ?>

<!-- Cookie Banner -->
<div id="cookieBanner" class="cookie-banner">
  <p>We use cookies to improve your experience. By continuing, you agree to our use of cookies.
    <button id="acceptCookies">Accept</button>
  </p>
</div>

<!-- Analytics Logger -->
<?php include __DIR__ . '/analytics_logger.php'; ?>

<script>
  // Cookie acceptance
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

</body>
</html>
<?php
// Get the buffered content
$layout_content = ob_get_clean();

// Now the page needs to output its content
// The page will define $content and then include this file
// After including, we'll output everything

// Function to render the layout with content
function render_layout($content) {
    global $layout_content;
    
    // Replace the placeholder with actual content
    $final_output = str_replace(
        '<!-- Content will be inserted here -->',
        $content,
        $layout_content
    );
    
    echo $final_output;
}

// If $content is already defined, render immediately
if (isset($content)) {
    render_layout($content);
}
?>