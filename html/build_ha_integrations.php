<?php
// build_ha_integrations.php – Run once to regenerate ha_integrations.json
$input = json_decode(file_get_contents(__DIR__ . '/data/integrations.json'), true);
$output = [];

foreach ($input as $item) {
    $domain = $item['domain'];
    $name = $item['label'];
    $logo = "https://brands.home-assistant.io/{$domain}/icon.svg";
    $docs = "https://www.home-assistant.io/integrations/{$domain}/";

    // Verify logo exists
    $headers = @get_headers($logo, 1);
    if (!$headers || strpos($headers[0], '200') === false) {
        $logo = '/images/brand/generic.svg';
    }

    $output[] = [
        'domain' => $domain,
        'name'   => $name,
        'logo'   => $logo,
        'url'    => $docs
    ];
}

file_put_contents(__DIR__ . '/data/ha_integrations.json', json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "✅ Updated ha_integrations.json with " . count($output) . " entries.\n";
