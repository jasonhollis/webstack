<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Home Automation - KTP Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    <style>
        /* Custom font */
        .bank-gothic {
            font-family: "bank-gothic", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        
        /* Full page container with dark background */
        body {
            background: #0a1628;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Spiral container - full height, fixed position */
        .spiral-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.5;
            pointer-events: none;
        }
        
        /* Spiral video styling */
        .spiral-video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(1.4) contrast(1.2) hue-rotate(20deg);
            mix-blend-mode: screen;
        }
        
        /* Gradient overlay for depth */
        .gradient-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(10, 22, 40, 0.85) 0%,
                rgba(30, 64, 175, 0.15) 30%,
                rgba(147, 51, 234, 0.1) 60%,
                rgba(10, 22, 40, 0.75) 100%);
            z-index: 2;
            pointer-events: none;
        }
        
        /* Content wrapper */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
        
        /* Glass morphism cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(59, 130, 246, 0.5);
            transform: translateY(-5px);
        }
        
        /* Glowing button */
        .glow-button {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.5);
            transition: all 0.3s ease;
        }
        
        .glow-button:hover {
            box-shadow: 0 0 50px rgba(59, 130, 246, 0.8);
            transform: scale(1.05);
        }
        
        /* Animated gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #60a5fa 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }
        
        @keyframes shimmer {
            to { background-position: 200% center; }
        }
        
        /* Geometric shapes for visual interest */
        .geometric-accent {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px solid rgba(59, 130, 246, 0.2);
            transform: rotate(45deg);
            border-radius: 20px;
            pointer-events: none;
        }
        
        /* Stats counter animation */
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="text-white min-h-screen">
    
    <!-- Spiral Background - Using 1176907710 (Performance Champion) -->
    <div class="spiral-background">
        <video class="spiral-video" autoplay loop muted playsinline>
            <source src="/test-videos/AdobeStock_1176907710_Video_HD_Preview.mov" type="video/quicktime">
            <source src="/test-videos/AdobeStock_1176907710_Video_HD_Preview.mp4" type="video/mp4">
        </video>
    </div>
    
    <!-- Gradient Overlay -->
    <div class="gradient-overlay"></div>
    
    <!-- Main Content -->
    <div class="content-wrapper">
        
        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center px-6 relative">
            <!-- Geometric accent -->
            <div class="geometric-accent -top-20 -left-20 opacity-20"></div>
            
            <div class="text-center max-w-5xl mx-auto">
                <h1 class="bank-gothic text-6xl md:text-8xl mb-6 gradient-text">
                    PREMIUM HOME<br>AUTOMATION
                </h1>
                <p class="text-xl md:text-2xl mb-12 text-gray-300 max-w-2xl mx-auto">
                    Transform Your Space Into an Intelligent Home
                </p>
                <button class="glow-button px-10 py-5 rounded-full text-lg font-semibold">
                    Get Started Today
                </button>
            </div>
        </section>
        
        <!-- Services Section -->
        <section class="py-32 px-6 relative">
            <div class="max-w-7xl mx-auto">
                <h2 class="bank-gothic text-5xl text-center mb-20 gradient-text">
                    OUR SERVICES
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="glass-card p-10 rounded-2xl text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Smart Home</h3>
                        <p class="text-gray-400">Complete home automation solutions tailored to your lifestyle</p>
                    </div>
                    
                    <div class="glass-card p-10 rounded-2xl text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Security</h3>
                        <p class="text-gray-400">Advanced security systems for complete peace of mind</p>
                    </div>
                    
                    <div class="glass-card p-10 rounded-2xl text-center group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Energy</h3>
                        <p class="text-gray-400">Smart energy management to reduce costs and environmental impact</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Stats Section -->
        <section class="py-32 px-6 relative">
            <div class="geometric-accent -bottom-20 -right-20 opacity-10"></div>
            
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-3 gap-12 text-center">
                    <div class="glass-card p-8 rounded-2xl">
                        <div class="stat-number">500+</div>
                        <div class="text-gray-400 mt-4 text-lg">Homes Automated</div>
                    </div>
                    <div class="glass-card p-8 rounded-2xl">
                        <div class="stat-number">3200+</div>
                        <div class="text-gray-400 mt-4 text-lg">Devices Supported</div>
                    </div>
                    <div class="glass-card p-8 rounded-2xl">
                        <div class="stat-number">24/7</div>
                        <div class="text-gray-400 mt-4 text-lg">Support Available</div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Home Automation Section -->
        <section class="py-32 px-6">
            <div class="max-w-7xl mx-auto">
                <h2 class="bank-gothic text-5xl text-center mb-6 gradient-text">
                    HOME AUTOMATION
                </h2>
                <p class="text-center text-gray-400 mb-20 max-w-3xl mx-auto">
                    Experience the future of living with our comprehensive automation solutions
                </p>
                
                <div class="grid md:grid-cols-4 gap-6">
                    <!-- Integration logos would go here -->
                    <div class="glass-card p-8 rounded-xl flex items-center justify-center">
                        <span class="text-2xl">🏠</span>
                    </div>
                    <div class="glass-card p-8 rounded-xl flex items-center justify-center">
                        <span class="text-2xl">💡</span>
                    </div>
                    <div class="glass-card p-8 rounded-xl flex items-center justify-center">
                        <span class="text-2xl">🔊</span>
                    </div>
                    <div class="glass-card p-8 rounded-xl flex items-center justify-center">
                        <span class="text-2xl">📱</span>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="py-32 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="bank-gothic text-5xl mb-8 gradient-text">
                    GET A FREE QUOTE
                </h2>
                <p class="text-xl text-gray-300 mb-12">
                    Ready to transform your home? Get started with a personalized consultation.
                </p>
                <button class="glow-button px-12 py-6 rounded-full text-xl font-semibold">
                    Schedule Consultation
                </button>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="py-12 px-6 border-t border-gray-800">
            <div class="max-w-6xl mx-auto text-center">
                <p class="text-gray-500">© 2025 KTP Digital - Premium Home Automation Solutions</p>
            </div>
        </footer>
        
    </div>
    
</body>
</html>