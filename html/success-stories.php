<?php
require __DIR__ . '/layout.php';

$page_title = "Success Stories | Premium Home Automation | KTP Digital";
$page_description = "Real Melbourne homes transformed with intelligent automation. From app chaos to seamless living - see how KTP Digital creates smart homes that actually work.";

// Success stories data
$stories = [
    [
        'title' => 'Toorak Estate',
        'subtitle' => 'From 25 Apps to One Unified System',
        'challenge' => '1,300+ smart devices across 25 different apps',
        'solution' => 'Unified Home Assistant platform with custom dashboards',
        'results' => [
            'Single app control for entire property',
            'Geolocation-based climate & lighting',
            'Automated robot cleaning schedules',
            'CarPlay & Apple Watch integration'
        ],
        'devices' => '1,300+',
        'investment' => '$45,000',
        'timeframe' => '3 weeks',
        'icon' => '🏛️'
    ],
    [
        'title' => 'Brighton Heritage',
        'subtitle' => 'Legacy C-Bus Modernized',
        'challenge' => '20-year-old C-Bus system requiring $600/hr specialists',
        'solution' => 'Home Assistant bridging with AI security & automation',
        'results' => [
            'Full C-Bus control via app',
            'Facial recognition entry',
            'AI-powered security cameras',
            'Automatic water leak protection'
        ],
        'devices' => '400+',
        'investment' => '$35,000',
        'timeframe' => '2 weeks',
        'icon' => '🏰'
    ],
    [
        'title' => 'Macedon Ranges',
        'subtitle' => '15-Acre Smart Property',
        'challenge' => 'Large property with no automation infrastructure',
        'solution' => 'Full Ubiquiti network + comprehensive Home Assistant',
        'results' => [
            'License plate gate recognition',
            'Wildlife-aware outdoor lighting',
            'Mesh WiFi to all outbuildings',
            '1Gbps fiber throughout property'
        ],
        'devices' => '500+',
        'investment' => '$85,000',
        'timeframe' => '6 weeks',
        'icon' => '🌄'
    ]
];

$content = <<<HTML
<style>
    .story-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .story-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
    .metric-badge {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #7dd3fc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }
    .result-item {
        position: relative;
        padding-left: 1.5rem;
    }
    .result-item:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: bold;
    }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-50 to-cyan-50 py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Real Success Stories</h1>
        <p class="text-xl text-gray-700 mb-8">Melbourne's Premium Properties Transformed</p>
        <div class="flex flex-wrap justify-center gap-6 text-sm">
            <div class="metric-badge">
                <span class="text-gray-600">Total Devices Integrated</span>
                <span class="font-bold text-blue-700 ml-2">2,200+</span>
            </div>
            <div class="metric-badge">
                <span class="text-gray-600">Properties Automated</span>
                <span class="font-bold text-blue-700 ml-2">50+</span>
            </div>
            <div class="metric-badge">
                <span class="text-gray-600">Average ROI</span>
                <span class="font-bold text-blue-700 ml-2">18 months</span>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories Grid -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-8">
HTML;

foreach ($stories as $story) {
    $content .= <<<HTML
            <div class="story-card p-8">
                <div class="text-4xl mb-4">{$story['icon']}</div>
                <h2 class="text-2xl font-bold mb-2">{$story['title']}</h2>
                <p class="text-blue-600 font-medium mb-4">{$story['subtitle']}</p>
                
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">CHALLENGE</p>
                    <p class="text-gray-800">{$story['challenge']}</p>
                </div>
                
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">SOLUTION</p>
                    <p class="text-gray-800">{$story['solution']}</p>
                </div>
                
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-3">KEY RESULTS</p>
                    <div class="space-y-2">
HTML;
    
    foreach ($story['results'] as $result) {
        $content .= '<div class="result-item text-gray-800">' . $result . '</div>';
    }
    
    $content .= <<<HTML
                    </div>
                </div>
                
                <div class="border-t pt-4 mt-6">
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-700">{$story['devices']}</p>
                            <p class="text-xs text-gray-600">Devices</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-700">{$story['investment']}</p>
                            <p class="text-xs text-gray-600">Investment</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-700">{$story['timeframe']}</p>
                            <p class="text-xs text-gray-600">Timeframe</p>
                        </div>
                    </div>
                </div>
            </div>
HTML;
}

$content .= <<<HTML
        </div>
    </div>
</section>

<!-- Problem/Solution Section -->
<section class="bg-gray-50 py-16 px-4">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Common Problems We Solve</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-lg">
                <h3 class="text-xl font-bold mb-4 text-red-600">❌ Before KTP Digital</h3>
                <ul class="space-y-3 text-gray-700">
                    <li>• 20+ different apps for different devices</li>
                    <li>• Devices that don't talk to each other</li>
                    <li>• Complex scenes require multiple apps</li>
                    <li>• Ring doorbell only works with Alexa</li>
                    <li>• Legacy systems requiring expensive specialists</li>
                    <li>• No unified security or monitoring</li>
                    <li>• Manual control of everything</li>
                </ul>
            </div>
            <div class="bg-white p-8 rounded-lg">
                <h3 class="text-xl font-bold mb-4 text-green-600">✓ After KTP Digital</h3>
                <ul class="space-y-3 text-gray-700">
                    <li>• One app controls everything</li>
                    <li>• All devices work together seamlessly</li>
                    <li>• Complex automations with simple triggers</li>
                    <li>• Ring works with HomeKit, Google, everything</li>
                    <li>• Self-service control and modifications</li>
                    <li>• Unified security with AI detection</li>
                    <li>• Intelligent automation that learns</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Technology Stack -->
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">Enterprise-Grade Technology Stack</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="h-16 w-16 mx-auto mb-3 bg-blue-600 rounded-lg flex items-center justify-center">
                    <img src="/images/icons/home-assistant.svg" alt="Home Assistant" class="h-12 w-12 object-contain">
                </div>
                <p class="font-medium">Home Assistant</p>
                <p class="text-sm text-gray-600">Core Platform</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="h-16 w-16 mx-auto mb-3 bg-gray-800 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">UI</span>
                </div>
                <p class="font-medium">UniFi</p>
                <p class="text-sm text-gray-600">Network & Security</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="h-16 w-16 mx-auto mb-3 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <p class="font-medium">HomeKit</p>
                <p class="text-sm text-gray-600">Apple Integration</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="h-16 w-16 mx-auto mb-3 bg-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">MTR</span>
                </div>
                <p class="font-medium">Matter</p>
                <p class="text-sm text-gray-600">Universal Standard</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-700 to-cyan-600 py-16 px-4 text-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Home?</h2>
        <p class="text-xl mb-8">Join Melbourne's elite properties with truly intelligent automation</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/premium-landing-spiral.php#contact" class="px-8 py-4 bg-white text-blue-700 font-bold rounded-lg hover:bg-gray-100 transition">
                Schedule Consultation
            </a>
            <a href="/integrations.php" class="px-8 py-4 bg-blue-800 text-white font-bold rounded-lg hover:bg-blue-900 transition">
                View Integrations
            </a>
        </div>
    </div>
</section>
HTML;

renderLayout($page_title, $content, '', $page_description);
?>