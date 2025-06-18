<?php
// integration_grid_hybrid.php
$page_title = "Integration Grid Hybrid – KTP Webstack";
$json_file = __DIR__ . '/data/ha_integrations.json';
$integrations = [];
if (file_exists($json_file)) {
    $integrations = json_decode(file_get_contents($json_file), true);
}

// Manual logo overrides (domain => logo SVG URL)
$logo_override = [
    'hue'            => 'https://brands.home-assistant.io/hue/icon.svg',
    'androidtv'      => 'https://brands.home-assistant.io/android_tv/icon.svg',
    'denonavr'       => 'https://brands.home-assistant.io/denonavr/icon.svg',
    'denon_heos'     => 'https://brands.home-assistant.io/denon_heos/icon.svg',
    'roborock'       => 'https://brands.home-assistant.io/roborock/icon.svg',
    'unifi'          => 'https://brands.home-assistant.io/unifi/icon.svg',
    'unifiprotect'   => 'https://brands.home-assistant.io/unifiprotect/icon.svg',
    'unifi_access'   => 'https://brands.home-assistant.io/unifi_access/icon.svg',
    'sony_bravia_tv' => 'https://brands.home-assistant.io/sony_bravia_tv/icon.svg',
    'bangolufsen'    => 'https://brands.home-assistant.io/bangolufsen/icon.svg',
    'cast'           => 'https://brands.home-assistant.io/cast/icon.svg',
    'pushover'       => 'https://brands.home-assistant.io/pushover/icon.svg',
    'songpal'        => 'https://brands.home-assistant.io/songpal/icon.svg',
    'tuya'           => 'https://brands.home-assistant.io/tuya/icon.svg',
    'xiaomi_miot'    => 'https://brands.home-assistant.io/xiaomi_miot/icon.svg',
    'homekit_bridge' => 'https://brands.home-assistant.io/homekit_bridge/icon.svg',
    'homekit_controller' => 'https://brands.home-assistant.io/homekit_controller/icon.svg',
    // Add more overrides as needed!
];

// Local fallback icon for *any* missing/unknown logo
$fallback_icon = '/images/brand/generic.svg';

ob_start();
?>

<style>
  body { background: #f7fafc; font-family: system-ui, sans-serif; }
  .integration-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px,1fr)); gap: 2rem; max-width: 1100px; margin: 40px auto; }
  .integration-card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 12px 0 rgba(80,80,120,0.08); display: flex; flex-direction: column; align-items: center; padding: 1.3rem 1rem 1rem 1rem; }
  .integration-card img { height: 60px; width: 60px; margin-bottom: 0.6rem; border-radius: 0.5rem; box-shadow: 0 2px 8px 0 rgba(80,80,120,0.04); background: #fff; object-fit: contain; }
  .integration-card span { font-size: 0.98rem; font-weight: 500; color: #374151; text-align: center; }
  .integration-card a { color: #2563eb; text-decoration: underline; font-size: 0.84rem; margin-top: 0.2rem; }
</style>

<h1 style="text-align:center; font-size:2rem; font-weight:700; margin-top:2rem;">Integration Grid (Hybrid Branding)</h1>
<p style="text-align:center;">Live data from ha_integrations.json + manual logo branding.<br>(<?= count($integrations) ?> integrations)</p>

<div class="integration-grid">
<?php
foreach ($integrations as $item) {
    // Skip "Removed" integrations
    if (stripos($item['name'], 'Removed') !== false) continue;

    $domain = $item['domain'];
    $label  = htmlspecialchars($item['name']);
    $docs_url = htmlspecialchars($item['url']);

    // Decide which logo to use
    if (isset($logo_override[$domain])) {
        $icon_url = $logo_override[$domain];
    } else {
        $icon_url = $item['logo'];
        if (
            !$icon_url ||
            strpos($icon_url, 'default-social.png') !== false ||
            strpos($icon_url, 'default-og.png') !== false
        ) {
            $icon_url = $fallback_icon;
        }
    }

    echo <<<HTML
    <div class="integration-card">
      <img src="{$icon_url}" alt="{$label} Logo" onerror="this.src='{$fallback_icon}'"/>
      <span>{$label}</span>
      <a href="{$docs_url}" target="_blank">HA Docs</a>
    </div>
HTML;
}
?>
</div>

<?php
echo ob_get_clean();
?>
