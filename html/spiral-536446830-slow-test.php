<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slow Motion Test - Stock 536446830</title>
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
            opacity: 0.35;
            mix-blend-mode: screen;
            filter: brightness(0.7) contrast(1.2);
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
    </style>
</head>
<body class="bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-4 text-center">JavaScript Playback Speed Test</h1>
        <p class="text-gray-400 text-center mb-8">Testing Stock 536446830 at different speeds</p>
        
        <!-- Speed Controls -->
        <div class="flex justify-center gap-4 mb-8">
            <button onclick="setSpeed(1)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Normal (1x)
            </button>
            <button onclick="setSpeed(0.5)" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                Half Speed (0.5x)
            </button>
            <button onclick="setSpeed(0.25)" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded">
                Quarter Speed (0.25x)
            </button>
            <button onclick="setSpeed(0.1)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Ultra Slow (0.1x)
            </button>
        </div>
        
        <!-- Current Speed Display -->
        <div class="text-center mb-8">
            <span class="text-gray-400">Current Speed: </span>
            <span id="speedDisplay" class="text-2xl font-bold text-white">1x</span>
        </div>
        
        <!-- Video Display -->
        <div class="relative h-96 bg-gray-800 rounded-lg overflow-hidden">
            <video id="testVideo" class="video-bg" autoplay loop muted playsinline>
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
        
        <!-- Performance Note -->
        <div class="mt-8 p-4 bg-yellow-900/30 border border-yellow-500/30 rounded-lg">
            <p class="text-yellow-400 font-semibold mb-2">⚠️ Browser Limitations:</p>
            <p class="text-gray-300 text-sm">
                JavaScript playbackRate may cause stuttering or choppy playback, especially at very slow speeds.
                For production use, the video should be re-exported at the desired speed in Final Cut Pro or Adobe Premiere.
            </p>
            <p class="text-gray-300 text-sm mt-2">
                <strong>Note:</strong> Some browsers handle slow playback better than others. Chrome generally performs best.
            </p>
        </div>
        
        <!-- Test Other Videos -->
        <div class="mt-8 space-y-4">
            <h2 class="text-xl font-semibold text-white">Test Other Videos:</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button onclick="changeVideo('AdobeStock_1513155009_Video_HD_Preview.mov')" 
                        class="bg-gray-700 hover:bg-gray-600 text-white p-3 rounded text-sm">
                    1513155009
                </button>
                <button onclick="changeVideo('AdobeStock_1176907710_Video_HD_Preview.mov')" 
                        class="bg-gray-700 hover:bg-gray-600 text-white p-3 rounded text-sm">
                    1176907710
                </button>
                <button onclick="changeVideo('AdobeStock_137199678_Video_HD_Preview.mov')" 
                        class="bg-gray-700 hover:bg-gray-600 text-white p-3 rounded text-sm">
                    137199678
                </button>
                <button onclick="changeVideo('AdobeStock_536446830_Video_HD_Preview.mov')" 
                        class="bg-gray-700 hover:bg-gray-600 text-white p-3 rounded text-sm">
                    536446830 (Current)
                </button>
            </div>
        </div>
    </div>
    
    <script>
        const video = document.getElementById('testVideo');
        const speedDisplay = document.getElementById('speedDisplay');
        
        function setSpeed(speed) {
            video.playbackRate = speed;
            speedDisplay.textContent = speed + 'x';
            
            // Log for debugging
            console.log('Playback speed set to:', speed);
        }
        
        function changeVideo(filename) {
            const source = video.querySelector('source');
            source.src = '/test-videos/' + filename;
            video.load();
            video.play();
            
            // Reset speed to normal when changing videos
            setSpeed(1);
        }
        
        // Ensure video plays after page load
        video.addEventListener('loadedmetadata', function() {
            video.play();
        });
    </script>
</body>
</html>