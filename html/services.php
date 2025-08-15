<?php
require_once __DIR__ . '/layout.php';
include_once __DIR__ . '/services_menu.php';

ob_start();
?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-4">Our Services</h1>
    <p class="text-xl text-center text-gray-600 mb-12">
        Complete IT solutions for homes and businesses in Melbourne
    </p>

    <?php foreach ($service_categories as $category => $data): ?>
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="mr-2"><?php echo $data['icon']; ?></span>
            <?php echo $category; ?>
        </h2>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($data['pages'] as $url => $title): ?>
            <a href="<?php echo $url; ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-2 text-blue-600"><?php echo $title; ?></h3>
                
                <?php
                // Add descriptions for each service
                $descriptions = [
                    '/home-automation.php' => 'Complete smart home solutions with Home Assistant. Control everything from one app.',
                    '/success-stories.php' => 'Real customer transformations with enterprise-grade home automation.',
                    '/integration.php' => 'Connect 3,200+ devices and services seamlessly.',
                    '/ai-camera-integrations.php' => 'AI-powered security with facial recognition and object detection.',
                    '/home_automation_form.php' => 'Get a custom quote for your smart home project.',
                    '/smallbiz.php' => 'Premium IT support designed for Melbourne small businesses.',
                    '/enterprise.php' => 'Scalable enterprise solutions that grow with your business.',
                    '/mac.php' => 'Expert Apple ecosystem support since 1984.',
                    '/windows.php' => 'Professional Windows infrastructure and support.',
                    '/small_business_form.php' => 'Request a business IT assessment and quote.',
                    '/network.php' => 'Enterprise-grade networking that just works.',
                    '/ubiquiti.php' => 'UniFi Dream Machine Pro and complete network solutions.',
                    '/security.php' => 'Protect your business with enterprise security.',
                    '/disaster-recovery.php' => 'Never lose data with bulletproof backup strategies.',
                    '/network_infrastructure_form.php' => 'Get a custom network infrastructure proposal.',
                    '/cloud.php' => 'Secure cloud migration and management services.',
                    '/nas.php' => 'QNAP and Synology NAS solutions for any scale.',
                    '/email.php' => 'Microsoft 365 and professional email services.',
                    '/websites.php' => 'Custom web development and hosting solutions.',
                    '/macos-tools.php' => 'Power user tools and automation for macOS.',
                    '/nextdns.php' => 'Enterprise DNS security and filtering.',
                    '/tailscale.php' => 'Zero-config mesh VPN for secure access.',
                    '/methodology.php' => 'How we deliver excellence in every project.'
                ];
                
                $description = $descriptions[$url] ?? 'Learn more about this service.';
                ?>
                
                <p class="text-gray-600 text-sm"><?php echo $description; ?></p>
                
                <?php if (strpos($url, '_form.php') !== false): ?>
                <div class="mt-4">
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                        Get Quote
                    </span>
                </div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- CTA Section -->
    <div class="bg-blue-50 rounded-xl p-8 mt-12 text-center">
        <h2 class="text-2xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-gray-700 mb-6">
            Whether you need home automation, business IT, or enterprise networking - we have the expertise to deliver.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/contact.php" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Contact Us
            </a>
            <a href="/premium-landing.php" class="inline-block px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg shadow hover:bg-gray-900 transition">
                Premium Services
            </a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

renderLayout(
    'IT Services Melbourne | KTP Digital',
    $content,
    '',
    'Complete IT services for Melbourne homes and businesses. Home automation, network infrastructure, Mac support, cloud services, and enterprise solutions.',
    '/services.php'
);
?>