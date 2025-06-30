<?php
$page_title = "Home Automation by KTP Digital";
$page_desc  = "Next-gen smart home, automated: everything connected by KTP Digital and Home Assistant. Blinds, lighting, security, entertainment, irrigation, and more—seamlessly integrated.";
$canonical = "https://www.ktp.digital/landing.php";
$og_image = "/images/logos/KTP Logo.png";
ob_start();
?>

<style>
  .network-matrix { position: relative; width: 480px; height: 480px; margin: 0 auto; }
  .icon-node { position: absolute; width: 84px; height: 84px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 24px 0 rgba(80,80,120,0.08); transition: box-shadow .2s; }
  .icon-node img { width: 56px; height: 56px; }
  .icon-node:hover { box-shadow: 0 6px 32px 0 rgba(80,80,140,0.20); z-index: 2; }
  .center-logo { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 3; display: flex; flex-direction: column; align-items: center; }
  .center-logo img { border-radius: 50%; border: 4px solid #38bdf8; box-shadow: 0 8px 32px 0 rgba(0,60,255,0.10); background: #fff; }
  .network-svg { position: absolute; top: 0; left: 0; pointer-events: none; }
  .realworld-title { font-size: 1.2rem; font-weight: 500; color: #334155; margin-bottom: 1.25rem; margin-top: 2.5rem; text-align: center; }
  .example-img-block { display: flex; flex-direction: column; align-items: center; }
  .example-img-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: #64748b; }
  .example-img { border-radius: 1rem; box-shadow: 0 2px 12px 0 rgba(80,80,120,0.08); transition: transform .15s, box-shadow .15s; cursor: zoom-in; }
  .example-img:hover { transform: scale(1.06); box-shadow: 0 8px 36px 0 rgba(30,60,160,0.12); }
  .integration-logo { transition: transform .14s, box-shadow .14s; border-radius: 0.75rem; box-shadow: 0 2px 8px 0 rgba(80,80,120,0.06); background: #fff; }
  .integration-logo:hover { transform: scale(1.1) rotate(-2deg); box-shadow: 0 4px 24px 0 rgba(30,60,160,0.14); }
</style>
<script>
function zoomImage(src) {
  window.open(src, '_blank');
}
</script>

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-2 py-8">
  <div class="network-matrix">
    <svg width="480" height="480" class="network-svg">
      <?php
      $icon_count = 10;
      $radius = 190;
      $center_x = 240;
      $center_y = 240;
      for ($i = 0; $i < $icon_count; $i++) {
        $angle = deg2rad((360/$icon_count)*$i - 90);
        $x = $center_x + cos($angle) * $radius;
        $y = $center_y + sin($angle) * $radius;
        echo "<line x1=\"$center_x\" y1=\"$center_y\" x2=\"$x\" y2=\"$y\" stroke=\"#a3a3a3\" stroke-width=\"2\" />\n";
      }
      ?>
    </svg>
    <?php
    $icons = [
      'blind.png','lightbulb.png','garagedoor.png','doorlock.png','gate.png',
      'seccamera.png','entertainment.png','irrigation.png','computer.png','TV.png'
    ];
    $icon_count = count($icons);
    $radius = 190;
    $center_x = 240;
    $center_y = 240;

    for ($i = 0; $i < $icon_count; $i++) {
      $angle = deg2rad((360/$icon_count)*$i - 90);
      $x = $center_x + cos($angle) * $radius - 42;
      $y = $center_y + sin($angle) * $radius - 42;
      $src = "/images/icons/" . $icons[$i];
      echo "<div class=\"icon-node\" style=\"left:{$x}px;top:{$y}px;\"><img src=\"$src\" alt=\"\" /></div>\n";
    }
    ?>
    <div class="center-logo">
      <img src="/images/icons/homeassistant/home-assistant-logomark-with-margins-color-on-light.svg" alt="Home Assistant" style="width:130px;height:130px;margin-bottom:12px;border:4px solid #38bdf8;background:#fff;">
      <div class="text-2xl font-semibold text-blue-700" style="letter-spacing:0.04em;">Home Assistant</div>
    </div>
  </div>
  <div class="flex flex-col items-center mt-10 mb-6">
    <img src="/images/logos/KTP Logo.png" alt="KTP Digital" class="w-20 h-20 rounded-full shadow-md border-2 border-indigo-100 mb-2" />
    <span class="text-lg font-extrabold text-indigo-900 tracking-tight">Powered by KTP Digital</span>
  </div>
  <div class="w-full max-w-3xl mx-auto mt-2 flex flex-col items-center">
    <div class="text-center mb-4">
      <span class="text-lg font-semibold text-gray-800">
        <a href="https://www.home-assistant.io/integrations/" target="_blank" rel="noopener noreferrer" class="text-blue-700 underline hover:text-blue-900">
          Home Assistant supports over <strong>3800 integrations</strong>
        </a>
      </span>
    </div>
    <div class="realworld-title">
      These are real-world examples of Home Assistant systems we manage:
    </div>
    <div class="w-full flex flex-row items-center justify-center gap-8 mb-10">
      <div class="example-img-block">
        <span class="example-img-title">Integrations</span>
        <img src="/images/icons/customer1.png" alt="Integrations Example" class="example-img h-28 md:h-40" onclick="zoomImage(this.src)" />
      </div>
      <div class="example-img-block">
        <span class="example-img-title">Zigbee Network</span>
        <img src="/images/icons/zigbee.png" alt="Zigbee Network" class="example-img h-28 md:h-40" onclick="zoomImage(this.src)" />
      </div>
      <div class="example-img-block">
        <span class="example-img-title">Integrations</span>
        <img src="/images/icons/customer2.png" alt="Integrations Example 2" class="example-img h-28 md:h-40" onclick="zoomImage(this.src)" />
      </div>
    </div>
    <div class="text-center mb-6">
      <span class="text-xl font-semibold text-gray-800">We have implemented hundreds of integrations including:</span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-8 items-center justify-center">
      <?php
        // [domain, display name, (optional) logo]
        $integrations = [
          ['alarmo', 'Alarmo', '/images/icons/alarmo.png'],
          ['androidtv_remote', 'Android TV Remote', '/images/icons/androidtv_remote.png'],
          ['automate', 'Automate Pulse Hub v2'],
          ['bang_olufsen', 'Bang & Olufsen', 'https://brands.home-assistant.io/bang_olufsen/icon.svg'],
          ['bluetooth', 'Bluetooth'],
          ['denonavr', 'Denon AVR Network Receivers'],
          ['heos', 'Denon HEOS', '/images/icons/heos@2x.png'],
          ['dyson', 'Dyson'],
          ['enphase_envoy', 'Enphase Envoy'],
          ['cast', 'Google Cast'],
          ['hacs', 'HACS'],
          ['homekit_bridge', 'HomeKit Bridge'],
          ['homekit_controller', 'HomeKit Device'],
          ['influxdb', 'InfluxDB'],
          ['ingress', 'Ingress'],
          ['roomba', 'iRobot Roomba and Braava'],
          ['ollama', 'Ollama'],
          ['onvif', 'ONVIF'],
          ['matter', 'Matter'],
          ['mqtt', 'MQTT'],
          ['music_assistant', 'Music Assistant'],
          ['oralb', 'Oral-B'],
          ['hue', 'Philips Hue'],
          ['porsche_connect', 'Porsche Connect'],
          ['pushover', 'Pushover'],
          ['reolink', 'Reolink'],
          ['roborock', 'Roborock'],
          ['samsungtv', 'Samsung Smart TV'],
          ['sensibo', 'Sensibo'],
          ['sonos', 'Sonos'],
          ['sony_bravia_tv', 'Sony Bravia TV'],
          ['songpal', 'Sony Songpal'],
          ['switchbot', 'SwitchBot Bluetooth'],
          ['systemmonitor', 'System Monitor'],
          ['tesla_custom', 'Tesla Custom Integration'],
          ['thread', 'Thread'],
          ['tuya', 'Tuya'],
          ['unifi_access', 'Unifi Access'],
          ['unifi', 'Unifi Network'],
          ['unifiprotect', 'Unifi Protect'],
          ['upnp', 'UPnP/IGD'],
          ['waste_collection_schedule', 'Waste Collection Schedule'],
          ['xiaomi_ble', 'Xiaomi BLE'],
          ['xiaomi_miot', 'Xiaomi Miot Auto'],
          ['zwave_js', 'Z-Wave'],
        ];
        foreach ($integrations as $item) {
          [$domain, $label, $logo_url] = array_pad($item, 3, null);
          if (!$logo_url) {
            $logo_url = "https://brands.home-assistant.io/{$domain}/icon.svg";
          }
          $integration_url = "https://www.home-assistant.io/integrations/{$domain}/";
          echo <<<HTML
          <a href="{$integration_url}" target="_blank" class="flex flex-col items-center group">
            <img src="{$logo_url}" alt="{$label}" class="integration-logo h-12 w-12 mb-2" onerror="this.src='/images/brand/generic.svg'"/>
            <span class="text-xs text-gray-700 group-hover:text-blue-700 font-medium">{$label}</span>
          </a>
HTML;
        }
      ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
