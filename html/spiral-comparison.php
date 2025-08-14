<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spiral Animation Comparison - KTP Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .video-container {
            position: relative;
            background: #0a1628;
            overflow: hidden;
        }
        
        .video-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
            pointer-events: none;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #60a5fa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-white mb-8 text-center">Adobe Stock Spiral Animation Comparison</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php
            $videos = [
                ['id' => '137199678', 'name' => 'Spiral Pattern 1', 'notes' => 'Classic spiral with particles'],
                ['id' => '542797365', 'name' => 'Spiral Pattern 2', 'notes' => 'Large file - complex animation'],
                ['id' => '137208093', 'name' => 'Spiral Pattern 3', 'notes' => 'Medium complexity'],
                ['id' => '1176907710', 'name' => 'Spiral Pattern 4', 'notes' => 'Compact file size'],
                ['id' => '536446830', 'name' => 'Spiral Pattern 5', 'notes' => 'Balanced size and quality'],
                ['id' => '137203063', 'name' => 'Spiral Pattern 6', 'notes' => 'Smooth animation'],
                ['id' => '1513155009', 'name' => 'Spiral Pattern 7', 'notes' => 'Modern effect']
            ];
            
            foreach ($videos as $video):
                $filename = "AdobeStock_{$video['id']}_Video_HD_Preview.mov";
            ?>
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <div class="video-container h-64 relative">
                    <video class="video-preview" autoplay loop muted playsinline>
                        <source src="/test-videos/<?php echo $filename; ?>" type="video/quicktime">
                    </video>
                    
                    <!-- Sample overlay text to test readability -->
                    <div class="overlay-text">
                        <h3 class="text-2xl font-bold gradient-text mb-2">PREMIUM HOME</h3>
                        <p class="text-white/80 text-sm">Automation Solutions</p>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-white mb-1">
                        Stock ID: <?php echo $video['id']; ?>
                    </h3>
                    <p class="text-gray-400 text-sm mb-3"><?php echo $video['notes']; ?></p>
                    
                    <!-- Technical evaluation criteria -->
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Color Flexibility:</span>
                            <div class="flex gap-1">
                                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                <div class="w-4 h-4 bg-purple-500 rounded"></div>
                                <div class="w-4 h-4 bg-cyan-500 rounded"></div>
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Full-width preview section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-white mb-6">Full-Width Hero Preview</h2>
            
            <?php foreach ($videos as $video): 
                $filename = "AdobeStock_{$video['id']}_Video_HD_Preview.mov";
            ?>
            <div class="mb-8">
                <h3 class="text-white mb-2">Stock ID: <?php echo $video['id']; ?></h3>
                <div class="video-container h-96 relative rounded-lg overflow-hidden">
                    <video class="video-preview opacity-60" autoplay loop muted playsinline>
                        <source src="/test-videos/<?php echo $filename; ?>" type="video/quicktime">
                    </video>
                    
                    <!-- Hero content overlay -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <h1 class="text-6xl font-bold gradient-text mb-4">PREMIUM HOME AUTOMATION</h1>
                            <p class="text-xl text-white/80 mb-8">Transform Your Space Into an Intelligent Home</p>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full">
                                Get Started Today
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Evaluation Notes -->
        <div class="mt-12 bg-gray-800 rounded-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-4">Evaluation Criteria</h2>
            <div class="grid md:grid-cols-2 gap-6 text-gray-300">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Visual Appeal</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• How well does it convey "premium" and "high-tech"?</li>
                        <li>• Does it work with overlaid text?</li>
                        <li>• Is the motion smooth and professional?</li>
                        <li>• Does it distract or enhance the content?</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-2">Technical Flexibility</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• Can we adjust opacity effectively?</li>
                        <li>• Does it work with CSS filters and blend modes?</li>
                        <li>• File size vs quality balance</li>
                        <li>• Loop smoothness and seamlessness</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>