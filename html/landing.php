<?php
$page_title = "Home Automation by KTP Digital";
$page_desc  = "Next-gen smart home, automated: everything connected by KTP Digital and Home Assistant. Blinds, lighting, security, entertainment, irrigation, and more—seamlessly integrated.";
$canonical  = "https://www.ktp.digital/landing.php";
$og_image   = "/images/logos/KTP Logo.png";
ob_start();
?>

<style>
  /* Top network matrix styles */
  .network-matrix { position: relative; width: 480px; height: 480px; margin: 0 auto; }
  .icon-node { position: absolute; width: 84px; height: 84px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 24px rgba(80,80,120,0.08); transition: box-shadow .2s; }
  .icon-node img { width: 56px; height: 56px; }
  .icon-node:hover { box-shadow: 0 6px 32px rgba(80,80,140,0.20); z-index: 2; }
  .center-logo { position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); z-index: 3; display: flex; flex-direction: column; align-items: center; }
  .center-logo img { border-radius: 50%; border: 4px solid #38bdf8; box-shadow: 0 8px 32px rgba(0,60,255,0.10); background: #fff; }
  .network-svg { position: absolute; top: 0; left: 0; pointer-events: none; }

  /* Real-world examples */
  .realworld-title { font-size: 1.2rem; font-weight: 500; color: #334155; margin: 2.5rem 0 1.25rem; text-align: center; }
  .example-img-block { display: flex; flex-direction: column; align-items: center; }
  .example-img-title { font-size: 1rem; font-weight: 600; margin-bottom: .5rem; color: #64748b; }
  .example-img { border-radius: 1rem; box-shadow: 0 2px 12px rgba(80,80,120,0.08); transition: transform .15s, box-shadow .15s; cursor: zoom-in; }
  .example-img:hover { transform: scale(1.06); box-shadow: 0 8px 36px rgba(30,60,160,0.12); }

  /* Integration grid cards */
  .integration-logo { transition: transform .14s, box-shadow .14s; border-radius: .75rem; box-shadow: 0 2px 8px rgba(80,80,120,0.06); background: #fff; }
  .integration-logo:hover { transform: scale(1.1) rotate(-2deg); box-shadow: 0 4px 24px rgba(30,60,160,0.14); }
</style>

<script>
function zoomImage(src) {
  window.open(src, '_blank');
}
</script>

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-2 py-8">

  <!-- Top: Home Assistant network matrix -->
  <div class="network-matrix">
    <svg width="480" height="480" class="network-svg">
      <?php
      $count = 10; $r = 190; $cx = 240; $cy = 240;
      for ($i = 0; $i < $count; $i++) {
        $a = deg2rad((360/$count)*$i - 90);
        $x = $cx + cos($a)*$r; $y = $cy + sin($a)*$r;
        echo "<line x1=\"$cx\" y1=\"$cy\" x2=\"$x\" y2=\"$y\" stroke=\"#a3a3a3\" stroke-width=\"2\" />\n";
      }
      ?>
    </svg>
    <?php
    $icons = ['blind.png','lightbulb.png','garagedoor.png','doorlock.png','gate.png','seccamera.png','entertainment.png','irrigation.png','computer.png','TV.png'];
    foreach ($icons as $i => $icon) {
      $angle = deg2rad((360/count($icons))*$i - 90);
      $x     = $cx + cos($angle)*$r - 42;
      $y     = $cy + sin($angle)*$r - 42;
      echo "<div class=\"icon-node\" style=\"left:{$x}px;top:{$y}px;\"><img src=\"/images/icons/{$icon}\" alt=\"\" /></div>\n";
    }
    ?>
    <div class="center-logo">
      <img
        src="/images/icons/homeassistant/home-assistant-logomark-with-margins-color-on-light.svg"
        alt="Home Assistant"
        style="width:130px;height:130px;margin-bottom:12px;"
      />
      <div class="text-2xl font-semibold text-blue-700" style="letter-spacing:.04em;">Home Assistant</div>
    </div>
  </div>

  <!-- Branding -->
  <div class="flex flex-col items-center mt-10 mb-6">
    <img src="/images/logos/KTP Logo.png" alt="KTP Digital" class="w-20 h-20 rounded-full shadow-md border-2 border-indigo-100 mb-2"/>
    <span class="text-lg font-extrabold text-indigo-900 tracking-tight">Powered by KTP Digital</span>
  </div>

  <!-- Real-world examples -->
  <div class="w-full max-w-3xl mx-auto mt-2 flex flex-col items-center">
    <div class="text-center mb-4">
      <a href="https://www.home-assistant.io/integrations/" target="_blank" rel="noopener noreferrer" class="text-lg font-semibold text-blue-700 underline hover:text-blue-900">
        Home Assistant supports over <strong>3800 integrations</strong>
      </a>
    </div>
    <div class="realworld-title">These are real-world examples of Home Assistant systems we manage:</div>
    <div class="w-full flex justify-center gap-8 mb-10">
      <?php
      $examples = [
        ['Integrations', 'customer1.png'],
        ['Zigbee Network', 'zigbee.png'],
        ['Integrations', 'customer2.png']
      ];
      foreach ($examples as list($title, $img)) : ?>
        <div class="example-img-block">
          <span class="example-img-title"><?= htmlspecialchars($title) ?></span>
          <img src="/images/icons/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($title) ?>" class="example-img h-28 md:h-40" onclick="zoomImage(this.src)"/>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Bottom: Integration Grid -->
  <?php
    $json        = __DIR__ . '/data/ha_integrations.json';
    $icon_dir    = __DIR__ . '/images/icons';
    $fallback    = '/images/icons/home-assistant.svg';
    $items       = file_exists($json) ? json_decode(file_get_contents($json), true) : [];
    $total       = count($items);
  ?>
  <div class="w-full max-w-6xl mx-auto mt-8">
    <div class="text-center mb-6">
      <span class="text-xl font-semibold text-gray-800">
        We have implemented <?= $total ?> integrations including:
      </span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
      <?php foreach ($items as $item):
        $domain = $item['domain'];
        $name   = $item['name'];
        $url    = $item['url'];
        $svg    = "{$icon_dir}/{$domain}.svg";
        $png    = "{$icon_dir}/{$domain}.png";
        $icon   = file_exists($svg) ? "/images/icons/{$domain}.svg"
               : (file_exists($png) ? "/images/icons/{$domain}.png"
               : $fallback);
      ?>
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center">
          <img
            src="<?= htmlspecialchars($icon) ?>"
            alt="<?= htmlspecialchars($name) ?>"
            class="h-20 w-20 object-contain mb-4"
            onerror="this.src='<?= $fallback ?>'"
          />
          <span class="text-center text-base font-medium text-gray-900"><?= htmlspecialchars($name) ?></span>
          <a href="<?= htmlspecialchars($url) ?>" target="_blank" class="mt-2 text-xs text-blue-600 underline">HA Docs</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
