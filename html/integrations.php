<?php
require_once __DIR__ . '/layout.php';

// Get category from URL
$category = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : 'all';

// Define categories and their integrations
$categories = [
    'security' => [
        'title' => 'Security & Doorbells',
        'description' => 'Ring, cameras, alarms - unified control across all platforms',
        'icon' => '🔔',
        'integrations' => ['ring', 'nest', 'arlo', 'eufy', 'wyze', 'unifiprotect', 'alarmo', 'reolink', 'onvif', 'august', 'yale', 'homekit', 'matter'],
        'highlight' => 'Ring works with Alexa only - until we integrate it with HomeKit, Google, and everything else'
    ],
    'garage' => [
        'title' => 'Garage & Gates',
        'description' => 'Automatic doors, remote access, and vehicle management',
        'icon' => '🚗',
        'integrations' => ['myq', 'chamberlain', 'shelly', 'homekit', 'unifi_access', 'zwave_js', 'matter', 'tuya']
    ],
    'access' => [
        'title' => 'Facial Recognition & Access',
        'description' => 'Keyless entry, visitor identification, and security',
        'icon' => '👤',
        'integrations' => ['unifi_access', 'unifiprotect', 'homekit', 'onvif', 'matter']
    ],
    'climate' => [
        'title' => 'Climate Control',
        'description' => 'Multi-zone temperature control and scheduling',
        'icon' => '🌡️',
        'integrations' => ['nest', 'ecobee', 'honeywell', 'sensibo', 'tuya', 'switchbot', 'homekit', 'matter', 'dyson']
    ],
    'lighting' => [
        'title' => 'Smart Lighting',
        'description' => 'Scenes, motion sensing, and automated lighting',
        'icon' => '💡',
        'integrations' => ['hue', 'lifx', 'wiz', 'govee', 'lutron', 'shelly', 'zwave_js', 'zigbee', 'tuya', 'homekit', 'matter', 'switchbot']
    ],
    'entertainment' => [
        'title' => 'Entertainment & Audio',
        'description' => 'TV, music, streaming - all devices in harmony',
        'icon' => '🎵',
        'integrations' => ['sonos', 'spotify', 'plex', 'apple_tv', 'roku', 'cast', 'samsungtv', 'lg_webos', 'vizio', 'sony_bravia_tv', 'androidtv_remote', 'yamaha', 'denonavr', 'heos', 'bang_olufsen', 'airplay', 'music_assistant']
    ],
    'network' => [
        'title' => 'Network & Infrastructure',
        'description' => 'WiFi, routers, NAS, monitoring, and network management',
        'icon' => '🌐',
        'integrations' => ['unifi', 'synology_dsm', 'qnap', 'mikrotik', 'openwrt', 'upnp', 'mqtt', 'snmp', 'wake_on_lan', 'ping', 'nmap_tracker', 'cert_expiry', 'bluetooth', 'thread', 'matter']
    ],
    'energy' => [
        'title' => 'Energy & Solar',
        'description' => 'Solar panels, energy monitoring, and efficiency',
        'icon' => '⚡',
        'integrations' => ['shelly', 'enphase_envoy', 'tesla_custom', 'systemmonitor']
    ],
    'cleaning' => [
        'title' => 'Cleaning & Maintenance',
        'description' => 'Robot vacuums, air purifiers, and automated cleaning',
        'icon' => '🧹',
        'integrations' => ['roomba', 'roborock', 'dyson', 'waste_collection_schedule']
    ],
    'automotive' => [
        'title' => 'Automotive & Transport',
        'description' => 'Vehicle integration, EV charging, and energy management',
        'icon' => '🚙',
        'integrations' => ['tesla_custom', 'porsche_connect']
    ]
];

// Load all integrations data
$json_file = __DIR__ . '/data/ha_integrations.json';
$all_integrations = [];
if (file_exists($json_file)) {
    $all_integrations = json_decode(file_get_contents($json_file), true);
    // Index by domain for easy lookup
    $indexed = [];
    foreach ($all_integrations as $int) {
        $indexed[$int['domain']] = $int;
    }
    $all_integrations = $indexed;
}

// Get current category data
$current_category = isset($categories[$category]) ? $categories[$category] : null;
$page_title = $current_category ? $current_category['title'] . ' Integrations' : 'All Integrations';
$page_desc = $current_category ? $current_category['description'] : 'Premium home automation integrations';

ob_start();
?>
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <?php if ($current_category): ?>
            <div class="text-6xl mb-4"><?= $current_category['icon'] ?></div>
            <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($current_category['title']) ?></h1>
            <p class="text-xl text-gray-600 mb-4"><?= htmlspecialchars($current_category['description']) ?></p>
            <?php if (isset($current_category['highlight'])): ?>
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg max-w-2xl mx-auto">
                    <p class="text-amber-800 font-medium">💡 <?= htmlspecialchars($current_category['highlight']) ?></p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <h1 class="text-4xl font-bold mb-4">Premium Integrations</h1>
            <p class="text-xl text-gray-600 mb-6">Enterprise-grade home automation solutions</p>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-r-lg max-w-3xl mx-auto">
                <h3 class="font-bold text-blue-900 mb-2">🏠 Why Home Assistant Integration?</h3>
                <p class="text-blue-800">Many devices like Ring only work with one ecosystem (Alexa). We bridge everything together - Ring with HomeKit, Tuya with Google Home, Tesla with Philips Hue. One system controlling all your devices, regardless of manufacturer.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Category Navigation -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
        <a href="/integrations.php" 
           class="px-6 py-3 rounded-lg font-medium transition <?= $category === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
            All Integrations
        </a>
        <?php foreach ($categories as $cat_key => $cat_data): ?>
            <a href="/integrations.php?category=<?= $cat_key ?>" 
               class="px-6 py-3 rounded-lg font-medium transition <?= $category === $cat_key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                <?= $cat_data['icon'] ?> <?= htmlspecialchars($cat_data['title']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Integration Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <?php 
        // Determine which integrations to show
        $show_integrations = [];
        if ($current_category) {
            // Show specific category integrations
            foreach ($current_category['integrations'] as $domain) {
                if (isset($all_integrations[$domain])) {
                    $show_integrations[] = $all_integrations[$domain];
                }
            }
        } else {
            // Show all integrations
            $show_integrations = array_values($all_integrations);
        }
        
        // Display integrations
        foreach ($show_integrations as $integration):
            $domain = $integration['domain'];
            $name = $integration['name'];
            $docs_url = $integration['url'] ?? '#';
            
            // Special highlighting for key bridge devices
            $is_ring = ($domain === 'ring');
            $is_bridge = in_array($domain, ['homekit', 'homekit_controller', 'matter', 'zigbee', 'zwave_js', 'alexa', 'google_assistant', 'homekit_bridge', 'mqtt', 'thread', 'hue', 'tuya', 'cast']);
            
            // Find icon
            $icon_dir = __DIR__ . '/images/icons';
            $svg_path = "{$icon_dir}/{$domain}.svg";
            $png_path = "{$icon_dir}/{$domain}.png";
            
            if (file_exists($svg_path)) {
                $icon_url = "/images/icons/{$domain}.svg";
            } elseif (file_exists($png_path)) {
                $icon_url = "/images/icons/{$domain}.png";
            } else {
                $icon_url = "/images/icons/home-assistant.svg";
            }
            
            $card_class = "bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center group";
            if ($is_ring) {
                $card_class = "bg-gradient-to-br from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center group";
            } elseif ($is_bridge) {
                $card_class = "bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center group";
            }
        ?>
            <div class="<?= $card_class ?> relative">
                <?php if ($is_ring): ?>
                    <div class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                        NEEDS BRIDGE
                    </div>
                <?php elseif ($is_bridge): ?>
                    <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                        BRIDGE
                    </div>
                <?php endif; ?>
                <img src="<?= htmlspecialchars($icon_url) ?>" 
                     alt="<?= htmlspecialchars($name) ?>" 
                     class="h-20 w-20 object-contain mb-4 group-hover:scale-110 transition"
                     onerror="this.src='/images/icons/home-assistant.svg'">
                <h3 class="text-center font-medium <?= $is_ring ? 'text-orange-900' : ($is_bridge ? 'text-blue-900' : 'text-gray-900') ?>"><?= htmlspecialchars($name) ?></h3>
                <?php if ($is_ring): ?>
                    <p class="text-xs text-orange-700 text-center mt-1">Alexa only → We bridge to all platforms</p>
                <?php elseif ($is_bridge): ?>
                    <?php if ($domain === 'alexa'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Voice & cross-platform bridge</p>
                    <?php elseif ($domain === 'google_assistant'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Voice & ecosystem bridge</p>
                    <?php elseif (in_array($domain, ['zigbee', 'zwave_js'])): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Protocol bridge</p>
                    <?php elseif (in_array($domain, ['homekit', 'homekit_bridge', 'homekit_controller'])): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Apple ecosystem bridge</p>
                    <?php elseif ($domain === 'hue'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Zigbee to IP bridge</p>
                    <?php elseif ($domain === 'tuya'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Smart Life ecosystem bridge</p>
                    <?php elseif ($domain === 'cast'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Google Cast bridge</p>
                    <?php elseif ($domain === 'matter'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Universal standard bridge</p>
                    <?php elseif ($domain === 'mqtt'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">IoT protocol bridge</p>
                    <?php elseif ($domain === 'thread'): ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Mesh network bridge</p>
                    <?php else: ?>
                        <p class="text-xs text-blue-700 text-center mt-1">Bridge technology</p>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="<?= htmlspecialchars($docs_url) ?>" 
                   target="_blank" 
                   class="mt-2 text-xs text-blue-600 hover:text-blue-800 underline">
                    Documentation
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- AI Camera Section -->
    <div class="mt-12 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold mb-3">🤖 Advanced AI Camera Integrations</h2>
            <p class="text-gray-600">Transform your security cameras into intelligent guardians</p>
        </div>
        <div class="grid md:grid-cols-3 gap-4 max-w-4xl mx-auto mb-6">
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl mb-2">🎯</div>
                <p class="font-medium">Object Detection</p>
                <p class="text-sm text-gray-600">People, vehicles, packages</p>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl mb-2">👤</div>
                <p class="font-medium">Facial Recognition</p>
                <p class="text-sm text-gray-600">Family vs strangers</p>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl mb-2">⚡</div>
                <p class="font-medium">Real-time Alerts</p>
                <p class="text-sm text-gray-600">Instant notifications</p>
            </div>
        </div>
        <div class="text-center">
            <a href="/ai-camera-integrations.php" 
               class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-purple-700 transition">
                Explore AI Camera Solutions →
            </a>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="mt-16 text-center bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl p-12 text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Automate Your Home?</h2>
        <p class="text-xl mb-8">Schedule a consultation to discuss your unique requirements</p>
        <a href="/premium-landing-spiral.php#contact" 
           class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
            Schedule Consultation
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();

// Render the full page
echo renderLayout(
    $page_title . ' – KTP Digital',
    $content,
    '',
    $page_desc,
    '/integrations.php' . ($category !== 'all' ? '?category=' . $category : '')
);
?>