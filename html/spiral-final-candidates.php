<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Spiral Candidates - KTP Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    <style>
        .bank-gothic {
            font-family: "bank-gothic", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        
        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }
        
        /* Different speed/opacity treatments */
        .subtle-slow {
            opacity: 0.3;
            mix-blend-mode: screen;
            filter: brightness(0.8);
        }
        
        .moderate-speed {
            opacity: 0.4;
            mix-blend-mode: screen;
            filter: brightness(0.9) saturate(1.2);
        }
        
        .vibrant-normal {
            opacity: 0.5;
            mix-blend-mode: lighten;
            filter: saturate(1.5) brightness(0.85);
        }
        
        .ultra-slow {
            opacity: 0.35;
            mix-blend-mode: screen;
            filter: brightness(0.7) contrast(1.2);
            /* CSS can't control playback speed, but we note it for implementation */
        }
        
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(10, 22, 40, 0.95) 0%,
                rgba(30, 64, 175, 0.15) 40%,
                rgba(147, 51, 234, 0.1) 60%,
                rgba(10, 22, 40, 0.9) 100%);
            z-index: 2;
        }
        
        .content-layer {
            position: relative;
            z-index: 10;
        }
        
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
        
        /* Playback speed control for demo */
        .speed-05x { animation: slowdown 40s linear infinite; }
        .speed-025x { animation: slowdown 80s linear infinite; }
        
        @keyframes slowdown {
            0% { opacity: 0.35; }
            50% { opacity: 0.4; }
            100% { opacity: 0.35; }
        }
    </style>
</head>
<body class="bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-white mb-2 text-center">Final Spiral Selection</h1>
        <p class="text-gray-400 text-center mb-8">Your top 4 picks with different treatments</p>
        
        <!-- Top Pick #1: 1513155009 - Modern effect -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">
                #1: Stock 1513155009 - Modern Effect (6.3MB)
            </h2>
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg moderate-speed" autoplay loop muted playsinline>
                    <source src="/test-videos/AdobeStock_1513155009_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-7xl gradient-text mb-4">PREMIUM HOME AUTOMATION</h1>
                        <p class="text-xl text-white/80 mb-8">Transform Your Space Into an Intelligent Home</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full transition">
                            Get Started Today
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                <p class="text-gray-300"><strong>Pros:</strong> Modern, sophisticated particle effect. Great loop. Professional feel.</p>
                <p class="text-gray-300"><strong>Implementation:</strong> Use at normal speed with 40% opacity</p>
            </div>
        </div>
        
        <!-- Top Pick #2: 1176907710 - Compact champion -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">
                #2: Stock 1176907710 - Performance Champion (2.5MB)
            </h2>
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg vibrant-normal" autoplay loop muted playsinline>
                    <source src="/test-videos/AdobeStock_1176907710_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-7xl gradient-text mb-4">ENTERPRISE SOLUTIONS</h1>
                        <p class="text-xl text-white/80 mb-8">Premium IT Services for Melbourne's Elite</p>
                        <div class="flex gap-4 justify-center">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full">
                                Schedule Consultation
                            </button>
                            <button class="border border-white/30 hover:bg-white/10 text-white px-6 py-3 rounded-full">
                                View Portfolio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                <p class="text-gray-300"><strong>Pros:</strong> Smallest file, fastest load. Clean animation. Mobile-friendly.</p>
                <p class="text-gray-300"><strong>Implementation:</strong> Perfect for performance-critical pages</p>
            </div>
        </div>
        
        <!-- Top Pick #3: 137199678 - Classic -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">
                #3: Stock 137199678 - Classic Spiral (3.5MB)
            </h2>
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg subtle-slow" autoplay loop muted playsinline>
                    <source src="/test-videos/AdobeStock_137199678_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-7xl gradient-text mb-4">SMART HOME SYSTEMS</h1>
                        <p class="text-xl text-white/80 mb-8">Toorak • Brighton • Armadale</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full">
                            Explore Solutions
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                <p class="text-gray-300"><strong>Pros:</strong> Classic particle spiral. Very flexible for color adjustment.</p>
                <p class="text-gray-300"><strong>Implementation:</strong> Works well at any opacity level</p>
            </div>
        </div>
        
        <!-- Bonus Pick #4: 536446830 - Slowed down -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">
                #4: Stock 536446830 - Ultra Slow Version (4.9MB)
            </h2>
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg ultra-slow" autoplay loop muted playsinline 
                       style="animation: slowMotion 120s linear infinite;">
                    <source src="/test-videos/AdobeStock_536446830_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-7xl gradient-text mb-4">LUXURY AUTOMATION</h1>
                        <p class="text-xl text-white/80 mb-8">White Glove Service for Discerning Clients</p>
                        <button class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-10 py-4 rounded-full text-lg">
                            Begin Your Journey
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                <p class="text-gray-300"><strong>Pros:</strong> If slowed to 25% speed in Final Cut, creates ambient luxury feel</p>
                <p class="text-gray-300"><strong>Implementation:</strong> Export at 0.25x speed for meditative effect</p>
            </div>
        </div>
        
        <!-- Decision Matrix -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">Quick Decision Guide</h2>
            <div class="space-y-3 text-gray-300">
                <div class="flex justify-between items-center p-3 bg-gray-700 rounded">
                    <span><strong>For Google Ads Landing:</strong></span>
                    <span class="text-green-400">Use #1 (1513155009) - Modern & engaging</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-700 rounded">
                    <span><strong>For Mobile-First Pages:</strong></span>
                    <span class="text-green-400">Use #2 (1176907710) - Fast loading</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-700 rounded">
                    <span><strong>For Enterprise Pages:</strong></span>
                    <span class="text-green-400">Use #3 (137199678) - Professional</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-700 rounded">
                    <span><strong>For Luxury Focus:</strong></span>
                    <span class="text-green-400">Use #4 (536446830) @ 0.25x speed</span>
                </div>
            </div>
        </div>
        
        <!-- Implementation Notes -->
        <div class="bg-blue-900/30 border border-blue-500/30 rounded-lg p-6">
            <h3 class="text-xl font-bold text-blue-400 mb-3">Next Steps</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-300">
                <li>Choose primary video: <strong>Recommend #1 (1513155009)</strong> for main site</li>
                <li>License 4K version from Adobe Stock</li>
                <li>Export versions:
                    <ul class="ml-6 mt-1 text-sm">
                        <li>• 4K for desktop (keep under 50MB)</li>
                        <li>• 1080p for tablet (keep under 20MB)</li>
                        <li>• 720p for mobile (keep under 10MB)</li>
                        <li>• Create .webm versions with ffmpeg</li>
                    </ul>
                </li>
                <li>For #4, export at 0.25x speed in Final Cut Pro</li>
                <li>Test with actual content on premium-landing.php</li>
            </ol>
        </div>
    </div>
</body>
</html>