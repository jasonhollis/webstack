<?php
$page_title  = "Awaken your home | KTP Digital";
$page_desc   = "Open source home automation that puts local control and privacy first. One unified dashboard for HomeKit, Google Home, Alexa, Home Assistant, and more.";
$canonical   = "https://www.ktp.digital/landing.php";
$og_image    = "/images/logos/KTP Logo.png";
ob_start();
?>

<!-- Import premium font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

<style>
  body { font-family: 'Inter', sans-serif; }

  /* Use-case marquee */
  .usecase-marquee {
    background: #014c6a;
    padding: 0.5rem 0;
    overflow: hidden;
  }
  .usecase-marquee .marquee-content {
    display: flex;
    width: 300%;
    animation: marquee 12s linear infinite;
  }
  .usecase-marquee span {
    flex: none;
    margin: 0 1.5rem;
    color: #c0e9ff;
    font-weight: 700;
    white-space: nowrap;
    font-size: 1.25rem;
  }
  @keyframes marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-66.666%); }
  }

  /* Hero two-column */
  .hero {
    background: #0288D1;
    color: #fff;
    padding: 4rem 1rem;
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
    font-size: 20rem;           /* 5× previous 4rem */
    font-weight: 900;
    line-height: 1;
    margin-bottom: 1rem;
  }
  .hero p {
    font-size: 2.5rem;          /* larger, bold sub-heading */
    font-weight: 700;
    line-height: 1.4;
    max-width: 700px;
    margin-bottom: 2rem;
    color: #d0eaff;
  }
  .btn-primary {
    background: #fff;
    color: #0288D1;
    font-weight: 700;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    transition: background 0.2s;
  }
  .btn-primary:hover {
    background: #e8f6ff;
  }
  .hero-image img {
    width: 100%;
    border-radius: 1.5rem;
    box-shadow: 0 12px 36px rgba(0,0,0,0.25);
    object-fit: cover;
  }
</style>

<script>
function zoomImage(src) {
  window.open(src, '_blank');
}
</script>

<!-- marquee above hero -->
<div class="usecase-marquee">
  <div class="marquee-content">
    <?php
      $cases = [
        'Gate Automation','Garage Doors','Smart Locks','Security Cameras',
        'Lighting Control','Automated Blinds','Heating & AC','Home Entertainment',
        'Voice Control','Irrigation','Network Monitoring','TV & Media'
      ];
      $loop = array_merge($cases, $cases, $cases);
      foreach ($loop as $c) {
        echo "<span>{$c}</span>";
      }
    ?>
  </div>
</div>

<!-- Hero section -->
<div class="hero">
  <div class="hero-container">
    <div>
      <h1>Awaken your home</h1>
      <p>Open source home automation that puts local control and privacy first. One unified dashboard for HomeKit, Google Home, Alexa, Home Assistant, and more.</p>
      <a href="/lead_form.php" class="btn-primary">Get Started</a>
    </div>
    <div class="hero-image">
      <a href="/images/icons/customer1.png" target="_blank" rel="noopener noreferrer">
        <img src="/images/icons/customer1.png" alt="Home Assistant dashboard screenshot" />
      </a>
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
<div id="integrations" class="w-full max-w-6xl mx-auto mt-8 pb-12">
  <div class="text-center mb-6">
    <span class="text-xl font-semibold text-gray-800">
      We have implemented hundreds of integrations for real customers, including:
    </span>
  </div>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
    <?php foreach ($items as $item): 
      $domain = $item['domain'];
      $name   = $item['name'];
      $url    = $item['url'];
      $svg    = "{$icon_dir}/{$domain}.svg";
      $png    = "{$icon_dir}/{$domain}.png";
      $icon   = file_exists($svg) 
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
        <a href="<?= htmlspecialchars($url) ?>" target="_blank" class="mt-2 text-xs text-blue-600 underline">HA Docs</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
