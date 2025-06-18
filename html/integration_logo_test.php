<?php
$page_title = "Integration Logo Test – KTP Webstack";
ob_start();
?>

<style>
  body { background: #f7fafc; font-family: system-ui, sans-serif; }
  .integration-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px,1fr)); gap: 2rem; max-width: 900px; margin: 40px auto; }
  .integration-card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 12px 0 rgba(80,80,120,0.08); display: flex; flex-direction: column; align-items: center; padding: 1.3rem 1rem 1rem 1rem; }
  .integration-card img { height: 60px; width: 60px; margin-bottom: 0.6rem; border-radius: 0.5rem; box-shadow: 0 2px 8px 0 rgba(80,80,120,0.04); background: #fff; }
  .integration-card span { font-size: 0.98rem; font-weight: 500; color: #374151; text-align: center; }
  .integration-card a { color: #2563eb; text-decoration: underline; font-size: 0.84rem; margin-top: 0.2rem; }
</style>

<h1 style="text-align:center; font-size:2rem; font-weight:700; margin-top:2rem;">Integration Logo Test</h1>
<p style="text-align:center;">This page checks the live status of Home Assistant logos for each integration.</p>

<div class="integration-grid">
<?php
function ha_logo_url($domain) {
    $url = "https://brands.home-assistant.io/{$domain}/icon.svg";
    // Check if remote logo exists (HEAD request)
    $headers = @get_headers($url, 1);
    if ($headers && strpos($headers[0], '200') !== false) {
        return $url;
    }
    // fallback to your local generic icon (provide this file!)
    return "/images/brand/generic.svg";
}

// Edit this list to test any HA integration domains/names!
$integrations = [
    ['hue', 'Philips Hue'],
    ['miele', 'Miele'],
    ['smartthings', 'Samsung SmartThings'],
    ['unifi', 'Ubiquiti UniFi'],
    ['sonos', 'Sonos'],
    ['roborock', 'Roborock'],
    ['homekit', 'Apple HomeKit'],
    ['google_assistant', 'Google Home'],
    ['androidtv', 'Android TV Remote'],
    ['emulated_hue', 'Emulated Hue'],
    // Add more to test!
];

foreach ($integrations as [$domain, $label]) {
    $logo_url = ha_logo_url($domain);
    $integration_url = "https://www.home-assistant.io/integrations/{$domain}/";
    echo <<<HTML
    <div class="integration-card">
      <img src="{$logo_url}" alt="{$label} Logo"/>
      <span>{$label}</span>
      <a href="{$integration_url}" target="_blank">HA Docs</a>
    </div>
HTML;
}
?>
</div>

<?php
echo ob_get_clean();
?>
