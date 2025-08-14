<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Spiral Animations - KTP Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    <style>
        .bank-gothic {
            font-family: "bank-gothic", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        
        /* Base video styles */
        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }
        
        /* Different color treatments */
        .blue-tint {
            filter: hue-rotate(0deg) saturate(1.2) brightness(0.9);
            opacity: 0.5;
            mix-blend-mode: screen;
        }
        
        .purple-tint {
            filter: hue-rotate(270deg) saturate(1.5) brightness(0.8);
            opacity: 0.4;
            mix-blend-mode: screen;
        }
        
        .cyan-tint {
            filter: hue-rotate(180deg) saturate(2) brightness(0.7);
            opacity: 0.45;
            mix-blend-mode: lighten;
        }
        
        .neutral {
            filter: saturate(0.3) brightness(0.8) contrast(1.2);
            opacity: 0.35;
            mix-blend-mode: screen;
        }
        
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(10, 22, 40, 0.9) 0%,
                rgba(30, 64, 175, 0.2) 50%,
                rgba(10, 22, 40, 0.95) 100%);
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
    </style>
</head>
<body class="bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-white mb-4 text-center">Top 3 Spiral Animation Candidates</h1>
        <p class="text-gray-400 text-center mb-8">Testing color flexibility and visual impact</p>
        
        <!-- Option 1: Best Overall - 137199678 -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">Option 1: Best Overall (Stock #137199678 - 3.5MB)</h2>
            
            <div class="grid md:grid-cols-2 gap-4 mb-8">
                <!-- Blue Tint -->
                <div class="relative h-64 bg-gray-800 rounded-lg overflow-hidden">
                    <video class="video-bg blue-tint" autoplay loop muted playsinline>
                        <source src="/test-videos/AdobeStock_137199678_Video_HD_Preview.mov" type="video/quicktime">
                    </video>
                    <div class="gradient-overlay"></div>
                    <div class="content-layer p-8 h-full flex items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-bold gradient-text mb-2">BLUE THEME</h3>
                            <p class="text-white/80 text-sm">Professional & Trustworthy</p>
                        </div>
                    </div>
                </div>
                
                <!-- Purple Tint -->
                <div class="relative h-64 bg-gray-800 rounded-lg overflow-hidden">
                    <video class="video-bg purple-tint" autoplay loop muted playsinline>
                        <source src="/test-videos/AdobeStock_137199678_Video_HD_Preview.mov" type="video/quicktime">
                    </video>
                    <div class="gradient-overlay"></div>
                    <div class="content-layer p-8 h-full flex items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-bold gradient-text mb-2">PURPLE THEME</h3>
                            <p class="text-white/80 text-sm">Premium & Innovative</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Full Width Hero -->
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg neutral" autoplay loop muted playsinline>
                    <source src="/test-videos/AdobeStock_137199678_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-6xl gradient-text mb-4">PREMIUM HOME AUTOMATION</h1>
                        <p class="text-xl text-white/80 mb-8">Transform Your Space Into an Intelligent Home</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full transition">
                            Get Started Today
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Option 2: Performance Focus - 1176907710 -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">Option 2: Performance Focus (Stock #1176907710 - 2.5MB)</h2>
            
            <div class="grid md:grid-cols-2 gap-4 mb-8">
                <!-- Cyan Tint -->
                <div class="relative h-64 bg-gray-800 rounded-lg overflow-hidden">
                    <video class="video-bg cyan-tint" autoplay loop muted playsinline>
                        <source src="/test-videos/AdobeStock_1176907710_Video_HD_Preview.mov" type="video/quicktime">
                    </video>
                    <div class="gradient-overlay"></div>
                    <div class="content-layer p-8 h-full flex items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-bold gradient-text mb-2">CYAN THEME</h3>
                            <p class="text-white/80 text-sm">Modern & Tech-Forward</p>
                        </div>
                    </div>
                </div>
                
                <!-- Neutral -->
                <div class="relative h-64 bg-gray-800 rounded-lg overflow-hidden">
                    <video class="video-bg neutral" autoplay loop muted playsinline>
                        <source src="/test-videos/AdobeStock_1176907710_Video_HD_Preview.mov" type="video/quicktime">
                    </video>
                    <div class="gradient-overlay"></div>
                    <div class="content-layer p-8 h-full flex items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-bold gradient-text mb-2">NEUTRAL THEME</h3>
                            <p class="text-white/80 text-sm">Subtle & Sophisticated</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Option 3: Premium Quality - 536446830 -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold text-white mb-4">Option 3: Premium Quality (Stock #536446830 - 4.9MB)</h2>
            
            <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
                <video class="video-bg blue-tint" autoplay loop muted playsinline>
                    <source src="/test-videos/AdobeStock_536446830_Video_HD_Preview.mov" type="video/quicktime">
                </video>
                <div class="gradient-overlay"></div>
                <div class="content-layer p-12 h-full flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="bank-gothic text-5xl md:text-6xl gradient-text mb-4">ENTERPRISE AUTOMATION</h1>
                        <p class="text-xl text-white/80 mb-8">Premium Solutions for Melbourne's Finest Homes</p>
                        <div class="flex gap-4 justify-center">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full transition">
                                Schedule Consultation
                            </button>
                            <button class="border border-white/30 hover:bg-white/10 text-white px-6 py-3 rounded-full transition">
                                View Portfolio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Technical Comparison -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-4">Technical Comparison</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="pb-2">Stock ID</th>
                            <th class="pb-2">File Size</th>
                            <th class="pb-2">Best Use Case</th>
                            <th class="pb-2">Color Flexibility</th>
                            <th class="pb-2">Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-700">
                            <td class="py-2">137199678</td>
                            <td>3.5MB</td>
                            <td>Main hero sections</td>
                            <td class="text-green-400">Excellent</td>
                            <td class="text-green-400">Good</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-2">1176907710</td>
                            <td>2.5MB</td>
                            <td>Mobile/performance critical</td>
                            <td class="text-yellow-400">Good</td>
                            <td class="text-green-400">Excellent</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-2">536446830</td>
                            <td>4.9MB</td>
                            <td>Premium/desktop focus</td>
                            <td class="text-green-400">Excellent</td>
                            <td class="text-yellow-400">Moderate</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- CSS Filter Controls -->
        <div class="mt-8 bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-4">CSS Filter Examples</h2>
            <pre class="bg-gray-900 p-4 rounded text-sm text-gray-300 overflow-x-auto">
/* Blue Corporate Theme */
.blue-tint {
    filter: hue-rotate(0deg) saturate(1.2) brightness(0.9);
    opacity: 0.5;
    mix-blend-mode: screen;
}

/* Purple Premium Theme */
.purple-tint {
    filter: hue-rotate(270deg) saturate(1.5) brightness(0.8);
    opacity: 0.4;
    mix-blend-mode: screen;
}

/* Cyan Modern Theme */
.cyan-tint {
    filter: hue-rotate(180deg) saturate(2) brightness(0.7);
    opacity: 0.45;
    mix-blend-mode: lighten;
}

/* Neutral Subtle Theme */
.neutral {
    filter: saturate(0.3) brightness(0.8) contrast(1.2);
    opacity: 0.35;
    mix-blend-mode: screen;
}</pre>
        </div>
    </div>
</body>
</html>