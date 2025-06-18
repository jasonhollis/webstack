<?php
/**
 * fetch_ha_integrations.php
 * Scrapes Home Assistant integrations docs for a list of domains,
 * and outputs a JSON file with name, logo, and docs URL.
 * Usage: php fetch_ha_integrations.php OR run via browser.
 */

// Where to write the JSON file
define('OUTPUT_JSON', __DIR__ . '/data/ha_integrations.json');

// Your desired integration domains:
$integration_domains = [
    'alarmo',                   // Alarmo
    'androidtv',                // Android TV Remote
    'automate',                 // Automate Pulse Hub v2
    'bangolufsen',              // Bang & Olufsen
    'bluetooth',                // Bluetooth
    'denonavr',                 // Denon AVR Network Receivers
    'denon_heos',               // Denon HEOS
    'dyson',                    // Dyson
    'enphase_envoy',            // Enphase Envoy
    'cast',                     // Google Cast
    'hacs',                     // HACS
    'homekit_bridge',           // HomeKit Bridge
    'homekit_controller',       // HomeKit Device
    'influxdb',                 // InfluxDB
    'ingress',                  // Ingress
    'roomba',                   // iRobot Roomba and Braava
    'ollama',                   // Ollama
    'onvif',                    // ONVIF
    'matter',                   // Matter
    'mqtt',                     // MQTT
    'music_assistant',          // Music Assistant
    'oralb',                    // Oral-B
    'hue',                      // Philips Hue
    'porsche_connect',          // Porsche Connect
    'pushover',                 // Pushover
    'reolink',                  // Reolink
    'roborock',                 // Roborock
    'samsungtv',                // Samsung Smart TV
    'sensibo',                  // Sensibo
    'sony_bravia_tv',           // Sony Bravia TV
    'songpal',                  // Sony Songpal
    'switchbot',                // SwitchBot Bluetooth
    'systemmonitor',            // System Monitor
    'tesla_custom',             // Tesla Custom Integration
    'thread',                   // Thread
    'tuya',                     // Tuya
    'unifi_access',             // Unifi Access
    'unifi',                    // Unifi Network
    'unifiprotect',             // Unifi Protect
    'upnp',                     // UPnP/IGD
    'waste_collection_schedule',// Waste Collection Schedule
    'xiaomi_ble',               // Xiaomi BLE
    'xiaomi_miot',              // Xiaomi Miot Auto
    'zwave_js',                 // Z-Wave
];

function fetch_integration_data($domain) {
    $doc_url = "https://www.home-assistant.io/integrations/{$domain}/";
    $brands_logo = "https://brands.home-assistant.io/{$domain}/icon.svg";
    $html = @file_get_contents($doc_url);
    if (!$html) {
        return [
            'domain' => $domain,
            'name'   => ucfirst(str_replace('_', ' ', $domain)),
            'logo'   => $brands_logo,
            'url'    => $doc_url,
            'error'  => 'Failed to load docs'
        ];
    }
    // Parse <title> and meta og:image
    $name = '';
    if (preg_match('/<title>(.+?) integration.+?Home Assistant/i', $html, $m)) {
        $name = trim($m[1]);
    }
    // Try for meta og:image
    $logo = '';
    if (preg_match('/<meta\s+property="og:image"\s+content="([^"]+)"/i', $html, $m)) {
        $logo = $m[1];
    }
    if (!$logo) $logo = $brands_logo;
    if (!$name) $name = ucfirst(str_replace('_', ' ', $domain));
    return [
        'domain' => $domain,
        'name'   => $name,
        'logo'   => $logo,
        'url'    => $doc_url,
    ];
}

// Build the output array
$results = [];
foreach ($integration_domains as $domain) {
    $results[] = fetch_integration_data($domain);
}

// Save as JSON
@mkdir(dirname(OUTPUT_JSON), 0775, true);
file_put_contents(OUTPUT_JSON, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// Output for CLI/browser
echo "<pre>Saved " . count($results) . " integrations to: " . OUTPUT_JSON . "\n</pre>";
foreach ($results as $item) {
    echo htmlspecialchars("{$item['name']} ({$item['domain']}): {$item['logo']}") . "\n";
}
?>
