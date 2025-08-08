<?php
// Database connection for lead capture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'get_quote') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        $stmt = $pdo->prepare("INSERT INTO premium_leads (name, email, phone, suburb, budget_range, ip_address, source, estimated_value) VALUES (?, ?, ?, ?, ?, ?, 'premium_landing_v3', ?)");
        
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
        
        header('Location: /premium-landing-v3.php?success=1');
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
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        /* Spiral video background - FULL CONTRAST */
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 1;
        }
        
        /* Minimal overlay for depth without washing out the spiral */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, 
                rgba(0, 0, 0, 0.2) 0%, 
                rgba(30, 58, 138, 0.1) 50%, 
                rgba(0, 0, 0, 0.3) 100%);
            z-index: 2;
        }
        
        /* Content box like the old version */
        .hero-content-box {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
        }
        
        /* Network node animation */
        @keyframes pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.05);
                opacity: 0.8;
            }
        }
        
        .pulse {
            animation: pulse 3s ease-in-out infinite;
        }
        
        /* Service card hover */
        .service-card {
            transition: all 0.3s ease;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            background: rgba(30, 58, 138, 0.95);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
        }
        
        /* Network lines */
        .network-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, #06b6d4, transparent);
            animation: pulse 3s ease-in-out infinite;
        }
        
        /* Button styles matching Canva */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.4);
        }
        
        /* Wave divider */
        .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        
        .wave-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 60px;
        }
    </style>
</head>
<body class="bg-black text-white">

    <?php if (isset($_GET['success'])): ?>
    <div class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg z-50 shadow-2xl">
        ✅ Thank you! Our premium consultation team will contact you within 24 hours.
    </div>
    <?php endif; ?>

    <!-- Navigation Bar -->
    <nav class="absolute top-0 w-full z-50 bg-gradient-to-b from-black/50 to-transparent">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <!-- Network-style logo -->
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="12" cy="5" r="2"/>
                        <circle cx="12" cy="19" r="2"/>
                        <circle cx="5" cy="12" r="2"/>
                        <circle cx="19" cy="12" r="2"/>
                        <line x1="12" y1="7" x2="12" y2="10"/>
                        <line x1="12" y1="14" x2="12" y2="17"/>
                        <line x1="7" y1="12" x2="10" y2="12"/>
                        <line x1="14" y1="12" x2="17" y2="12"/>
                    </svg>
                </div>
                <span class="bank-gothic text-xl text-white">KTP DIGITAL</span>
            </div>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#services" class="text-white/80 hover:text-cyan-400 transition">Services</a>
                <a href="#automation" class="text-white/80 hover:text-cyan-400 transition">Automation</a>
                <a href="#contact" class="text-white/80 hover:text-cyan-400 transition">Contact</a>
                <a href="tel:1300587348" class="text-cyan-400 font-bold">1300 KTP DIG</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with PROPER Spiral Video -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Video Background - Multiple sources for compatibility -->
        <video autoplay muted loop playsinline class="hero-video">
            <source src="/images/spiral_small_1080p.webm" type="video/webm">
            <source src="/images/spiral_lossless_1080p.webm" type="video/webm">
            <source src="/images/spiral_1080p.mp4" type="video/mp4">
            <source src="/images/spiral_720p.mp4" type="video/mp4">
            <img src="/images/spiral_poster.jpg" alt="Background">
        </video>
        
        <!-- Subtle overlay to maintain spiral visibility -->
        <div class="hero-overlay"></div>
        
        <!-- Content in dark box like the old version -->
        <div class="relative z-10 container mx-auto px-4">
            <div class="hero-content-box max-w-3xl mx-auto p-8 md:p-12 rounded-2xl text-center">
                <h1 class="bank-gothic text-4xl md:text-6xl mb-3 text-white">
                    Premium Home<br>Automation
                </h1>
                <p class="text-2xl md:text-3xl mb-2 text-yellow-400 font-bold">
                    for Melbourne's Finest Properties
                </p>
                <p class="text-lg md:text-xl mb-8 text-gray-300">
                    White glove IT consulting with enterprise-grade automation<br>
                    from $15,000 to $200,000+
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#contact" class="btn-primary text-white font-bold px-8 py-4 rounded-full text-lg">
                        Schedule Consultation
                    </a>
                    <a href="#services" class="border-2 border-white/50 hover:bg-white/10 text-white font-bold px-8 py-4 rounded-full text-lg transition">
                        Explore Services
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave divider at bottom -->
        <div class="wave-bottom">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                      fill="#0f172a"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section with Better Colors -->
    <section id="services" class="py-20 bg-gradient-to-b from-slate-900 to-slate-800">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-4 text-white">Our Services</h2>
            <p class="text-center text-xl mb-12 text-gray-400">Enterprise-grade solutions tailored to your lifestyle</p>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Service 1 -->
                <div class="service-card rounded-2xl p-8 text-center border border-blue-900/50">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center">
                        <img src="/images/icons/home-assistant.svg" alt="Home Automation" class="w-14 h-14">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3 text-cyan-400">Home Automation</h3>
                    <p class="text-gray-400 mb-4">Complete control of the service in one go. Hassle-free, tailored to your needs.</p>
                    <div class="text-2xl font-bold text-white">From $25K</div>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card rounded-2xl p-8 text-center border border-blue-900/50">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center">
                        <img src="/images/icons/network.svg" alt="IT Networking" class="w-14 h-14">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3 text-cyan-400">Enterprise Networking</h3>
                    <p class="text-gray-400 mb-4">Secure, fast, and reliable network solutions for your business and home.</p>
                    <div class="text-2xl font-bold text-white">From $15K</div>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card rounded-2xl p-8 text-center border border-blue-900/50">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center">
                        <img src="/images/icons/shield.svg" alt="Managed Services" class="w-14 h-14">
                    </div>
                    <h3 class="bank-gothic text-xl mb-3 text-cyan-400">Managed IT Services</h3>
                    <p class="text-gray-400 mb-4">Enterprise-grade support for all your technology needs.</p>
                    <div class="text-2xl font-bold text-white">From $500/mo</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Home Automation Network Section -->
    <section id="automation" class="py-20 bg-slate-900 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-4 text-white">Home Automation</h2>
            <p class="text-center text-xl mb-16 text-gray-400">Seamlessly integrated with the world's leading brands</p>
            
            <!-- Network Visualization -->
            <div class="max-w-6xl mx-auto relative h-96">
                <!-- Center Hub -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-full flex items-center justify-center pulse shadow-2xl">
                        <img src="/images/icons/home-assistant.svg" alt="Home Assistant" class="w-20 h-20">
                    </div>
                </div>
                
                <!-- Connecting Lines -->
                <svg class="absolute inset-0 w-full h-full" style="z-index: 10;">
                    <line x1="50%" y1="50%" x2="20%" y2="20%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <line x1="50%" y1="50%" x2="80%" y2="20%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <line x1="50%" y1="50%" x2="20%" y2="80%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <line x1="50%" y1="50%" x2="80%" y2="80%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <line x1="50%" y1="50%" x2="10%" y2="50%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <line x1="50%" y1="50%" x2="90%" y2="50%" stroke="url(#gradient)" stroke-width="2" opacity="0.5"/>
                    <defs>
                        <linearGradient id="gradient">
                            <stop offset="0%" stop-color="#3b82f6"/>
                            <stop offset="100%" stop-color="#06b6d4"/>
                        </linearGradient>
                    </defs>
                </svg>
                
                <!-- Partner Nodes -->
                <div class="absolute top-[20%] left-[20%] transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/tesla_custom.png" alt="Tesla" class="w-full h-full object-contain">
                    </div>
                </div>
                
                <div class="absolute top-[20%] right-[20%] transform translate-x-1/2 -translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/sonos.png" alt="Sonos" class="w-full h-full object-contain">
                    </div>
                </div>
                
                <div class="absolute bottom-[20%] left-[20%] transform -translate-x-1/2 translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/unifi.png" alt="UniFi" class="w-full h-full object-contain">
                    </div>
                </div>
                
                <div class="absolute bottom-[20%] right-[20%] transform translate-x-1/2 translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/apple.png" alt="Apple" class="w-full h-full object-contain">
                    </div>
                </div>
                
                <div class="absolute top-[50%] left-[10%] transform -translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/ring.png" alt="Ring" class="w-full h-full object-contain">
                    </div>
                </div>
                
                <div class="absolute top-[50%] right-[10%] transform -translate-y-1/2">
                    <div class="w-20 h-20 bg-slate-800 rounded-xl p-3 border border-blue-500/30 hover:border-cyan-400 transition">
                        <img src="/images/icons/hue.png" alt="Philips Hue" class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
            
            <!-- Partner Grid -->
            <div class="grid grid-cols-4 md:grid-cols-8 gap-4 max-w-4xl mx-auto mt-16">
                <?php
                $partners = ['zigbee.png', 'zwave_js.png', 'matter.png', 'homekit.png', 'tailscale.png', 'nextdns.png', 'mqtt.png', 'thread.png'];
                foreach ($partners as $icon) {
                    echo '<div class="bg-slate-800/50 rounded-lg p-3 hover:bg-slate-700/50 transition">
                            <img src="/images/icons/' . $icon . '" alt="" class="w-full h-full object-contain opacity-70 hover:opacity-100 transition">
                          </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Early Reviews Section -->
    <section class="py-20 bg-gradient-to-b from-slate-900 to-black">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12 text-white">Early Reviews</h2>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full mr-4"></div>
                        <div>
                            <div class="font-bold text-white">Sarah Mitchell</div>
                            <div class="text-sm text-gray-400">Toorak Residence</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-2">★★★★★</div>
                    <p class="text-gray-300">"KTP Digital transformed our home into a seamless smart ecosystem. The attention to detail and technical expertise is unmatched."</p>
                </div>
                
                <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full mr-4"></div>
                        <div>
                            <div class="font-bold text-white">James Chen</div>
                            <div class="text-sm text-gray-400">Brighton Estate</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-2">★★★★★</div>
                    <p class="text-gray-300">"Professional, reliable, and truly understand enterprise-grade systems. Our $87K investment was worth every penny."</p>
                </div>
                
                <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full mr-4"></div>
                        <div>
                            <div class="font-bold text-white">Michael Torres</div>
                            <div class="text-sm text-gray-400">Armadale Smart Home</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-2">★★★★★</div>
                    <p class="text-gray-300">"Unlike other providers, KTP actually delivers on their promises. Real engineers, not salespeople."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- IT Networking Services -->
    <section class="py-20 bg-black">
        <div class="container mx-auto px-4">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12 text-white">IT Networking Services</h2>
            
            <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto items-center">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-cyan-400">Enterprise-Grade Infrastructure</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            UniFi Dream Machine Pro with 10Gb backbone
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            WiFi 6E access points with seamless roaming
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            VLAN segmentation for IoT security
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            Tailscale mesh VPN for secure remote access
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            NextDNS for ad blocking and malware protection
                        </li>
                        <li class="flex items-start">
                            <span class="text-cyan-400 mr-2">✓</span>
                            24/7 monitoring and automated alerts
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 border border-blue-900/50">
                        <img src="/images/icons/unifi.png" alt="UniFi Network" class="w-32 h-32 mx-auto mb-4">
                        <p class="text-center text-gray-400">Powering Melbourne's smartest properties with bulletproof networking</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gradient-to-b from-black to-slate-900">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-12 text-white">FAQs</h2>
            
            <div class="space-y-4">
                <?php
                $faqs = [
                    ["What makes KTP Digital different?", "We're engineers, not salespeople. We use open-source, privacy-first solutions that you own, not cloud-dependent systems that harvest your data."],
                    ["What's your typical project timeline?", "Most residential projects take 2-4 weeks from consultation to completion. Enterprise projects typically run 4-12 weeks."],
                    ["Do you provide ongoing support?", "Yes, we offer managed service plans from $500/month including 24/7 monitoring, updates, and white-glove support."],
                    ["Which areas do you service?", "We focus on Melbourne's premium suburbs: Toorak, Brighton, Armadale, South Yarra, Malvern, Canterbury, and Hawthorn."],
                    ["Can you integrate with existing systems?", "Absolutely. We specialize in unifying disparate systems into one cohesive platform."]
                ];
                
                foreach ($faqs as $faq) {
                    echo '<details class="bg-slate-800/50 rounded-xl border border-slate-700 group">
                            <summary class="p-6 cursor-pointer font-bold text-lg text-white hover:text-cyan-400 transition">
                                ' . $faq[0] . '
                            </summary>
                            <div class="px-6 pb-6 text-gray-300">
                                ' . $faq[1] . '
                            </div>
                          </details>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="py-20 bg-gradient-to-b from-slate-900 to-black relative">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-cyan-600/10"></div>
        
        <div class="container mx-auto px-4 max-w-2xl relative z-10">
            <h2 class="bank-gothic text-4xl md:text-5xl text-center mb-4 text-white">Get a Free Quote</h2>
            <p class="text-center text-xl mb-12 text-cyan-400">Join Melbourne's elite with enterprise-grade automation</p>
            
            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="get_quote">
                
                <div class="grid md:grid-cols-2 gap-6">
                    <input type="text" name="name" required placeholder="Your Name" 
                           class="w-full p-4 rounded-lg bg-slate-800/50 backdrop-blur text-white placeholder-gray-500 border border-slate-700 focus:border-cyan-400 focus:outline-none transition">
                    
                    <input type="email" name="email" required placeholder="Email Address"
                           class="w-full p-4 rounded-lg bg-slate-800/50 backdrop-blur text-white placeholder-gray-500 border border-slate-700 focus:border-cyan-400 focus:outline-none transition">
                </div>
                
                <input type="tel" name="phone" required placeholder="Phone Number"
                       class="w-full p-4 rounded-lg bg-slate-800/50 backdrop-blur text-white placeholder-gray-500 border border-slate-700 focus:border-cyan-400 focus:outline-none transition">
                
                <select name="suburb" required 
                        class="w-full p-4 rounded-lg bg-slate-800/50 backdrop-blur text-white border border-slate-700 focus:border-cyan-400 focus:outline-none transition">
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
                        class="w-full p-4 rounded-lg bg-slate-800/50 backdrop-blur text-white border border-slate-700 focus:border-cyan-400 focus:outline-none transition">
                    <option value="" class="bg-slate-800">Project Investment Range</option>
                    <option value="15-25k" class="bg-slate-800">$15,000 - $25,000</option>
                    <option value="25-50k" class="bg-slate-800">$25,000 - $50,000</option>
                    <option value="50-100k" class="bg-slate-800">$50,000 - $100,000</option>
                    <option value="100k+" class="bg-slate-800">$100,000+</option>
                    <option value="enterprise" class="bg-slate-800">Enterprise Project</option>
                </select>
                
                <button type="submit" 
                        class="w-full btn-primary text-white font-bold py-4 rounded-full text-xl bank-gothic">
                    Request Consultation
                </button>
            </form>
            
            <div class="text-center mt-8">
                <p class="text-gray-400">Or call directly:</p>
                <a href="tel:1300587348" class="text-3xl font-bold text-cyan-400 hover:text-cyan-300 bank-gothic">1300 KTP DIG</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-black border-t border-slate-800">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="12" cy="5" r="2"/>
                        <circle cx="12" cy="19" r="2"/>
                        <circle cx="5" cy="12" r="2"/>
                        <circle cx="19" cy="12" r="2"/>
                        <line x1="12" y1="7" x2="12" y2="10"/>
                        <line x1="12" y1="14" x2="12" y2="17"/>
                        <line x1="7" y1="12" x2="10" y2="12"/>
                        <line x1="14" y1="12" x2="17" y2="12"/>
                    </svg>
                </div>
                <span class="bank-gothic text-xl text-white">KTP DIGITAL</span>
            </div>
            <p class="text-gray-400 mb-2">© <?php echo date('Y'); ?> KTP Digital. Premium IT Solutions for Melbourne's Elite.</p>
            <p class="text-sm text-gray-500">Toorak | Brighton | Armadale | South Yarra | Malvern | Canterbury | Hawthorn</p>
        </div>
    </footer>

</body>
</html>