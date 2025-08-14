<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Page Spiral Test - KTP Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    <style>
        /* Custom font */
        .bank-gothic {
            font-family: "bank-gothic", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        
        /* Option 1: Fixed video background that covers entire viewport */
        .spiral-video-fixed {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            background-size: cover;
        }
        
        /* Option 2: Stretched static image with parallax */
        .spiral-stretched {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/spiral_poster.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            opacity: 0.3;
        }
        
        /* Option 3: Repeating spiral pattern */
        .spiral-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/spiral_poster.jpg');
            background-size: 100% auto;
            background-position: top center;
            background-repeat: repeat-y;
            z-index: -1;
            opacity: 0.2;
        }
        
        /* Option 4: CSS animated gradient spiral effect */
        .gradient-spiral {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: -2;
        }
        
        .gradient-spiral::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg at 50% 50%, 
                transparent 0deg, 
                rgba(102, 126, 234, 0.1) 60deg, 
                transparent 120deg, 
                rgba(118, 75, 162, 0.1) 180deg, 
                transparent 240deg, 
                rgba(102, 126, 234, 0.1) 300deg, 
                transparent 360deg);
            animation: spiralRotate 30s linear infinite;
        }
        
        @keyframes spiralRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Dark overlay for better readability */
        .dark-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, 
                rgba(10, 22, 40, 0.85) 0%, 
                rgba(10, 22, 40, 0.7) 50%, 
                rgba(10, 22, 40, 0.9) 100%);
            z-index: -1;
        }
        
        /* Content styling */
        .content-section {
            position: relative;
            z-index: 1;
            background: rgba(10, 22, 40, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    
    <!-- Background Options - Toggle these to test different approaches -->
    
    <!-- Option 1: Video Background (Uncomment to test) -->
    <!--
    <video autoplay muted loop class="spiral-video-fixed">
        <source src="/images/spiral_small_1080p.webm" type="video/webm">
        <source src="/images/spiral_1080p.mp4" type="video/mp4">
    </video>
    -->
    
    <!-- Option 2: Stretched Image (Currently Active) -->
    <div class="spiral-stretched"></div>
    
    <!-- Option 3: Pattern (Uncomment to test) -->
    <!-- <div class="spiral-pattern"></div> -->
    
    <!-- Option 4: CSS Gradient Spiral (Uncomment to test) -->
    <!-- <div class="gradient-spiral"></div> -->
    
    <!-- Dark overlay for readability -->
    <div class="dark-overlay"></div>
    
    <!-- Main Content -->
    <div class="relative z-10">
        
        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center px-6">
            <div class="text-center max-w-4xl">
                <h1 class="bank-gothic text-5xl md:text-7xl mb-6 bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">
                    PREMIUM HOME AUTOMATION
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-300">
                    Transform Your Space Into an Intelligent Home
                </p>
                <button class="bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-lg text-lg font-semibold transition-all transform hover:scale-105">
                    Get Started Today
                </button>
            </div>
        </section>
        
        <!-- Services Section -->
        <section class="py-20 px-6">
            <div class="content-section max-w-6xl mx-auto p-12 rounded-2xl">
                <h2 class="bank-gothic text-4xl text-center mb-12">OUR SERVICES</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white/5 p-8 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all">
                        <div class="text-blue-400 text-4xl mb-4">🏠</div>
                        <h3 class="text-xl font-bold mb-2">Smart Home</h3>
                        <p class="text-gray-400">Complete home automation solutions</p>
                    </div>
                    <div class="bg-white/5 p-8 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all">
                        <div class="text-purple-400 text-4xl mb-4">🔒</div>
                        <h3 class="text-xl font-bold mb-2">Security</h3>
                        <p class="text-gray-400">Advanced security systems</p>
                    </div>
                    <div class="bg-white/5 p-8 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all">
                        <div class="text-green-400 text-4xl mb-4">⚡</div>
                        <h3 class="text-xl font-bold mb-2">Energy</h3>
                        <p class="text-gray-400">Smart energy management</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Stats Section -->
        <section class="py-20 px-6">
            <div class="content-section max-w-4xl mx-auto p-12 rounded-2xl">
                <div class="grid grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-400">500+</div>
                        <div class="text-gray-400 mt-2">Homes Automated</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-purple-400">3200+</div>
                        <div class="text-gray-400 mt-2">Devices Supported</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-400">24/7</div>
                        <div class="text-gray-400 mt-2">Support Available</div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Test Different Backgrounds Section -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="bank-gothic text-3xl text-center mb-8">Background Options Test</h2>
                <div class="bg-black/50 backdrop-blur-sm p-8 rounded-xl">
                    <p class="mb-4">Edit the HTML above to test different background approaches:</p>
                    <ol class="list-decimal list-inside space-y-2 text-gray-300">
                        <li><strong>Video Background:</strong> Uses your existing spiral video, fixed position</li>
                        <li><strong>Stretched Image:</strong> Uses spiral poster image, stretched to fill (Currently Active)</li>
                        <li><strong>Pattern:</strong> Repeats the spiral image vertically</li>
                        <li><strong>CSS Gradient:</strong> Pure CSS animated spiral effect</li>
                    </ol>
                    <p class="mt-6 text-sm text-gray-400">
                        For production, we can also explore Adobe Stock for vertical/portrait oriented spiral animations,
                        or create a custom SVG animation that scales perfectly to any height.
                    </p>
                </div>
            </div>
        </section>
        
        <!-- Long Content Test -->
        <section class="py-20 px-6">
            <div class="content-section max-w-4xl mx-auto p-12 rounded-2xl">
                <h2 class="bank-gothic text-3xl mb-6">Extended Content Area</h2>
                <p class="mb-4 text-gray-300">This section demonstrates how the spiral background works with longer content.</p>
                <p class="mb-4 text-gray-300">The background should remain fixed while content scrolls over it, creating a parallax effect.</p>
                <p class="mb-4 text-gray-300">We can adjust opacity, blur, and overlay darkness to ensure perfect readability.</p>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="py-12 px-6 border-t border-gray-800">
            <div class="max-w-6xl mx-auto text-center">
                <p class="text-gray-400">© 2025 KTP Digital - Premium Home Automation</p>
            </div>
        </footer>
        
    </div>
    
    <script>
        // Optional: Add parallax scrolling effect
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.spiral-stretched, .spiral-pattern');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>
    
</body>
</html>