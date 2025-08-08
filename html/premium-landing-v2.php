<?php
// Database connection for lead capture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'get_quote') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        $stmt = $pdo->prepare("INSERT INTO premium_leads (name, email, phone, suburb, budget_range, ip_address, source, estimated_value) VALUES (?, ?, ?, ?, ?, ?, 'premium_landing_v2', ?)");
        
        $budgetMap = ['15-25k' => 20000, '25-50k' => 37500, '50-100k' => 75000, '100k+' => 150000, 'enterprise' => 200000];
        
        $stmt->execute([
            trim($_POST['name']), 
            trim($_POST['email']), 
            trim($_POST['phone']), 
            $_POST['suburb'], 
            $_POST['budget'], 
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $budgetMap[$_POST['budget']] ?? 50000
        ]);
        
        header('Location: /premium-landing-v2.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = "Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Home Automation Melbourne | KTP Digital</title>
    <meta name="description" content="White glove IT consulting and home automation for Melbourne's finest properties. Enterprise-grade solutions from $25K-$200K+">
    
    <!-- Adobe Fonts (Bank Gothic) -->
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Bank Gothic for headings */
        .bank-gothic {
            font-family: 'bank-gothic-bt', 'Orbitron', sans-serif;
            font-weight: 500;
            letter-spacing: 0.05em;
        }
        
        /* Spiral video background */
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, 
                rgba(15, 23, 42, 0.95) 0%, 
                rgba(30, 58, 138, 0.85) 50%, 
                rgba(59, 130, 246, 0.75) 100%);
            z-index: -1;
        }
        
        /* Geometric wave pattern */
        .wave-divider {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        
        .wave-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }
        
        .wave-divider .shape-fill {
            fill: #1e3a8a;
        }
        
        /* Service card hover effects */
        .service-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        /* Network diagram animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-slate-900 text-white">

    <?php if (isset($_GET['success'])): ?>
    <div class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg z-50 shadow-2xl">
        ✅ Thank you! Our premium consultation team will contact you within 24 hours.
    </div>
    <?php endif; ?>

    <!-- Hero Section with Spiral Video -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="/images/spiral_small_1080p.webm" type="video/webm">
            <source src="/images/spiral_1080p.mp4" type="video/mp4">
            <img src="/images/spiral_poster.jpg" alt="Background">
        </video>
        <div class="hero-overlay"></div>
        
        <div class="relative z-10 container mx-auto px-4 text-center">
            <img src="/images/logos/KTP Logo.png" alt="KTP Digital" class="h-24 mx-auto mb-8">
            
            <h1 class="bank-gothic text-5xl md:text-7xl mb-4 text-white">
                HOME AUTOMATION
            </h1>
            <h2 class="bank-gothic text-3xl md:text-5xl mb-2 text-cyan-400">
                IT NETWORKING SERVICES
            </h2>
            <h3 class="bank-gothic text-3xl md:text-5xl mb-8 text-white">
                IT SOLUTIONS
            </h3>
            
            <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto text-gray-200">
                White glove IT consulting for Melbourne's finest properties.<br>
                Enterprise-grade automation from $25K to $200K+
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#quote" class="bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-bold px-8 py-4 rounded-full text-lg transition transform hover:scale-105">
                    GET FREE QUOTE
                </a>
                <a href="#services" class="border-2 border-white hover:bg-white hover:text-slate-900 text-white font-bold px-8 py-4 rounded-full text-lg transition">
                    OUR SERVICES
                </a>
            </div>
        </div>
        
        <div class="wave-divider">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gradient-to-b from-blue-900 to-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12">OUR SERVICES</h2>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Service 1 -->
                <div class="service-card bg-white/10 rounded-2xl p-8 text-center border border-white/20">
                    <div class="w-20 h-20 mx-auto mb-4 bg-cyan-500 rounded-full flex items-center justify-center">
                        <img src="/images/icons/home-assistant.svg" alt="Automation" class="w-12 h-12">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3">HOME AUTOMATION</h3>
                    <p class="text-gray-300">Complete smart home control. Lighting, climate, security, and entertainment unified in one elegant system.</p>
                    <div class="mt-4 text-cyan-400 font-bold">From $25,000</div>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card bg-white/10 rounded-2xl p-8 text-center border border-white/20">
                    <div class="w-20 h-20 mx-auto mb-4 bg-cyan-500 rounded-full flex items-center justify-center">
                        <img src="/images/icons/network.svg" alt="Networking" class="w-12 h-12">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3">ENTERPRISE NETWORKING</h3>
                    <p class="text-gray-300">UniFi, Tailscale, and enterprise-grade infrastructure for flawless connectivity and security.</p>
                    <div class="mt-4 text-cyan-400 font-bold">From $15,000</div>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card bg-white/10 rounded-2xl p-8 text-center border border-white/20">
                    <div class="w-20 h-20 mx-auto mb-4 bg-cyan-500 rounded-full flex items-center justify-center">
                        <img src="/images/icons/shield.svg" alt="Support" class="w-12 h-12">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3">MANAGED IT SERVICES</h3>
                    <p class="text-gray-300">24/7 monitoring, backup, disaster recovery, and white-glove support for your entire technology ecosystem.</p>
                    <div class="mt-4 text-cyan-400 font-bold">From $500/month</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Integration Partners Network -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-4">HOME AUTOMATION</h2>
            <p class="text-center text-xl mb-12 text-gray-300">Seamlessly integrated with the world's leading brands</p>
            
            <!-- Network Diagram -->
            <div class="max-w-4xl mx-auto relative">
                <div class="flex flex-wrap justify-center gap-8">
                    <!-- Center Hub -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                        <div class="w-32 h-32 bg-cyan-500 rounded-full flex items-center justify-center pulse">
                            <img src="/images/icons/home-assistant.svg" alt="Home Assistant" class="w-20 h-20">
                        </div>
                    </div>
                    
                    <!-- Partner Icons Grid -->
                    <div class="grid grid-cols-4 md:grid-cols-6 gap-8 mt-20">
                        <?php
                        $partners = [
                            'tesla_custom.png' => 'Tesla',
                            'sonos.png' => 'Sonos',
                            'unifi.png' => 'UniFi',
                            'apple.png' => 'Apple',
                            'ring.png' => 'Ring',
                            'hue.png' => 'Philips Hue',
                            'zigbee.png' => 'Zigbee',
                            'zwave_js.png' => 'Z-Wave',
                            'matter.png' => 'Matter',
                            'homekit.png' => 'HomeKit',
                            'tailscale.png' => 'Tailscale',
                            'nextdns.png' => 'NextDNS'
                        ];
                        
                        foreach ($partners as $icon => $name) {
                            echo '<div class="w-16 h-16 bg-white/10 rounded-lg p-3 flex items-center justify-center hover:bg-white/20 transition">
                                    <img src="/images/icons/' . $icon . '" alt="' . $name . '" class="w-full h-full object-contain" title="' . $name . '">
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Projects -->
    <section class="py-20 bg-gradient-to-b from-slate-900 to-blue-900">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12">RECENT INSTALLATIONS</h2>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <div class="text-3xl mb-2">🏡</div>
                    <h3 class="font-bold text-xl mb-2">Toorak Mansion</h3>
                    <p class="text-gray-300 mb-3">Complete home automation with 200+ devices, Tesla Powerwall integration, and enterprise networking.</p>
                    <div class="text-cyan-400 font-bold">$145,000 Project</div>
                </div>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <div class="text-3xl mb-2">🏢</div>
                    <h3 class="font-bold text-xl mb-2">Brighton Residence</h3>
                    <p class="text-gray-300 mb-3">Smart lighting, climate control, Sonos whole-home audio, and UniFi security system.</p>
                    <div class="text-cyan-400 font-bold">$87,000 Project</div>
                </div>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <div class="text-3xl mb-2">🏠</div>
                    <h3 class="font-bold text-xl mb-2">Armadale Smart Home</h3>
                    <p class="text-gray-300 mb-3">Apple HomeKit integration, automated blinds, pool control, and premium home theater.</p>
                    <div class="text-cyan-400 font-bold">$62,000 Project</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12">FREQUENTLY ASKED QUESTIONS</h2>
            
            <div class="space-y-6">
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <h3 class="font-bold text-xl mb-3">What makes KTP Digital different?</h3>
                    <p class="text-gray-300">We're not salespeople – we're engineers and IT professionals with 15+ years experience. We use open-source, privacy-first solutions that you actually own, not cloud-dependent systems that spy on you.</p>
                </div>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <h3 class="font-bold text-xl mb-3">What's the typical investment range?</h3>
                    <p class="text-gray-300">Our projects range from $15,000 for focused solutions to $200,000+ for complete smart estates. Most residential projects fall between $40,000-$80,000.</p>
                </div>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <h3 class="font-bold text-xl mb-3">Do you provide ongoing support?</h3>
                    <p class="text-gray-300">Absolutely. We offer managed service plans from $500/month including 24/7 monitoring, regular updates, and white-glove support. Your system will evolve with your needs.</p>
                </div>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                    <h3 class="font-bold text-xl mb-3">Which suburbs do you service?</h3>
                    <p class="text-gray-300">We focus on Melbourne's premium suburbs including Toorak, Brighton, Armadale, South Yarra, Malvern, Canterbury, and Hawthorn. We also handle enterprise projects throughout greater Melbourne.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="quote" class="py-20 bg-gradient-to-b from-blue-900 to-slate-900">
        <div class="container mx-auto px-4 max-w-2xl">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-4">GET A FREE QUOTE</h2>
            <p class="text-center text-xl mb-12 text-gray-300">Join Melbourne's elite with enterprise-grade automation</p>
            
            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="get_quote">
                
                <div class="grid md:grid-cols-2 gap-6">
                    <input type="text" name="name" required placeholder="Your Name" 
                           class="w-full p-4 rounded-lg bg-white/10 backdrop-blur text-white placeholder-gray-400 border border-white/20 focus:border-cyan-400 focus:outline-none">
                    
                    <input type="email" name="email" required placeholder="Email Address"
                           class="w-full p-4 rounded-lg bg-white/10 backdrop-blur text-white placeholder-gray-400 border border-white/20 focus:border-cyan-400 focus:outline-none">
                </div>
                
                <input type="tel" name="phone" required placeholder="Phone Number"
                       class="w-full p-4 rounded-lg bg-white/10 backdrop-blur text-white placeholder-gray-400 border border-white/20 focus:border-cyan-400 focus:outline-none">
                
                <select name="suburb" required 
                        class="w-full p-4 rounded-lg bg-white/10 backdrop-blur text-white border border-white/20 focus:border-cyan-400 focus:outline-none">
                    <option value="" class="bg-slate-800">Select Your Suburb</option>
                    <option value="toorak" class="bg-slate-800">Toorak</option>
                    <option value="brighton" class="bg-slate-800">Brighton</option>
                    <option value="armadale" class="bg-slate-800">Armadale</option>
                    <option value="south-yarra" class="bg-slate-800">South Yarra</option>
                    <option value="malvern" class="bg-slate-800">Malvern</option>
                    <option value="canterbury" class="bg-slate-800">Canterbury</option>
                    <option value="hawthorn" class="bg-slate-800">Hawthorn</option>
                    <option value="other" class="bg-slate-800">Other Premium Suburb</option>
                </select>
                
                <select name="budget" required 
                        class="w-full p-4 rounded-lg bg-white/10 backdrop-blur text-white border border-white/20 focus:border-cyan-400 focus:outline-none">
                    <option value="" class="bg-slate-800">Project Investment Range</option>
                    <option value="15-25k" class="bg-slate-800">$15,000 - $25,000</option>
                    <option value="25-50k" class="bg-slate-800">$25,000 - $50,000</option>
                    <option value="50-100k" class="bg-slate-800">$50,000 - $100,000</option>
                    <option value="100k+" class="bg-slate-800">$100,000+</option>
                    <option value="enterprise" class="bg-slate-800">Enterprise Project</option>
                </select>
                
                <button type="submit" 
                        class="w-full bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-bold py-4 rounded-lg text-xl transition transform hover:scale-105 bank-gothic">
                    REQUEST CONSULTATION
                </button>
            </form>
            
            <div class="text-center mt-8">
                <p class="text-gray-400">Or call directly:</p>
                <a href="tel:1300587348" class="text-2xl font-bold text-cyan-400 hover:text-cyan-300">1300 KTP DIG</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-slate-950 text-center">
        <img src="/images/logos/KTP Logo.png" alt="KTP Digital" class="h-16 mx-auto mb-4">
        <p class="text-gray-400 mb-2">© <?php echo date('Y'); ?> KTP Digital. Premium IT Solutions for Melbourne's Elite.</p>
        <p class="text-sm text-gray-500">Toorak | Brighton | Armadale | South Yarra | Malvern | Canterbury | Hawthorn</p>
    </footer>

</body>
</html>