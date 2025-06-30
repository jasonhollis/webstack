<?php
$page_title = "Awaken your home | KTP Digital";
$page_desc  = "Open source home automation that puts local control and privacy first. One unified dashboard for HomeKit, Google Home, Alexa, Home Assistant, and more.";
$canonical  = "https://www.ktp.digital/landing.php";
$og_image   = "/images/logos/KTP Logo.png";
ob_start();
?>

<style>
  /* Hero: two-column, Home Assistant style */
  .hero {
    background: #0288D1;
    color: white;
    padding: 6rem 1rem;
  }
  .hero-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: center;
  }
  @media (min-width: 768px) {
    .hero-container { grid-template-columns: 1fr 1fr; }
  }
  .hero h1 {
    font-size: 4rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1rem;
  }
  .hero p {
    font-size: 1.25rem;
    line-height: 1.6;
    max-width: 600px;
    margin-bottom: 2rem;
  }
  .hero .btn-primary {
    background: white;
    color: #0288D1;
    font-weight: 600;
    padding: .75rem 1.5rem;
    border-radius: .5rem;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: background .2s;
  }
  .hero .btn-primary:hover {
    background: #f0f0f0;
  }
  .hero-image img {
    width: 100%;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    object-fit: cover;
  }
</style>

<div class="hero">
  <div class="hero-container">
    <div>
      <h1>Awaken your home</h1>
      <p>Open source home automation that puts local control and privacy first. One unified dashboard for HomeKit, Google Home, Alexa, Home Assistant, and more.</p>
      <a href="/lead_form.php" class="btn-primary">Get Started</a>
    </div>
    <div class="hero-image">
      <img src="/images/icons/customer1.png" alt="Home Assistant dashboard screenshot">
    </div>
  </div>
</div>

<!-- Real-world examples (unchanged) -->
<div class="w-full max-w-3xl mx-auto mt-8 flex flex-col items-center">
  <div class="text-center mb-4">
    <a href="https://www.home-assistant.io/integrations/" target="_blank" rel="noopener noreferrer"
       class="text-lg font-semibold text-blue-700 underline hover:text-blue-900">
      Home Assistant supports over <strong>3800 integrations</strong>
    </a>
  </div>
  <div class="realworld-title">These are real-world examples of Home Assistant systems we manage:</div>
  <div class="w-full flex justify-center gap-8 mb-10">
    <?php
      $examples = [
        ['Integrations','customer1.png'],
        ['Zigbee Network','zigbee.png'],
        ['Integrations','customer2.png']
      ];
      foreach ($examples as list($title, $img)) : ?>
        <div class="example-img-block">
          <img src="/images/icons/<?= htmlspecialchars($img) ?>"
               alt="<?= htmlspecialchars($title) ?>"
               class="example-img h-28 md:h-40"
               onclick="zoomImage(this.src)" />
        </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Integration grid (unchanged) -->
<?php
  $json     = __DIR__ . '/data/ha_integrations.json';
  $icon_dir = __DIR__ . '/images/icons';
  $fallback = '/images/icons/home-assistant.svg';
  $items    = file_exists($json) ? json_decode(file_get_contents($json), true) : [];
  usort($items, function($a, $b) { return strcasecmp($a['name'], $b['name']); });
?>
<div class="w-full max-w-6xl mx-auto mt-8 pb-12">
  <div class="text-center mb-6">
    <span class="text-xl font-semibold text-gray-800">
      We have implemented hundreds of integrations for real customers, including:
    </span>
  </div>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    <?php foreach ($items as $item):
      $domain = $item['domain']; $name = $item['name']; $url = $item['url'];
      $svg  = "{$icon_dir}/{$domain}.svg";
      $png  = "{$icon_dir}/{$domain}.png";
      $icon = file_exists($svg)
            ? "/images/icons/{$domain}.svg"
            : (file_exists($png)
               ? "/images/icons/{$domain}.png"
               : $fallback);
    ?>
      <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center">
        <img src="<?= htmlspecialchars($icon) ?>"
             alt="<?= htmlspecialchars($name) ?>"
             class="h-20 w-20 object-contain mb-4"
             onerror="this.src='<?= $fallback ?>'" />
        <span class="text-center text-base font-medium text-gray-900"><?= htmlspecialchars($name) ?></span>
        <a href="<?= htmlspecialchars($url) ?>" target="_blank"
           class="mt-2 text-xs text-blue-600 underline">HA Docs</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
