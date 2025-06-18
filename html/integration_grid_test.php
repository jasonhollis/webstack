<?php
// integration_grid_test.php
$page_title = "Integration Grid Test – KTP Webstack";
$json_file = __DIR__ . '/data/ha_integrations.json';
$integrations = [];
if (file_exists($json_file)) {
    $integrations = json_decode(file_get_contents($json_file), true);
}
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

<h1 style="text-align:center; font-size:2rem; font-weight:700; margin-top:2rem;">Integration Grid Test</h1>
<p style="text-align:center;">Live data from ha_integrations.json (<?= count($integrations) ?> integrations)</p>

<div class="integration-grid">
<?php
$fallback_icon = '/images/brand/generic.svg'; // Use your custom fallback if you want

foreach ($integrations as $item) {
    $label = htmlspecialchars($item['name']);
    $icon_url = htmlspecialchars($item['logo']);
    $domain = htmlspecialchars($item['domain']);
    $docs_url = htmlspecialchars($item['url']);
    // If icon is missing or default-social.png, use fallback
    if (
        !$icon_url ||
        strpos($icon_url, 'default-social.png') !== false ||
        strpos($icon_url, 'default-og.png') !== false
    ) {
        $icon_url = $fallback_icon;
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
