<?php
$page_title = "KTP Digital | Home Automation & IT Services Melbourne";
$page_desc = "Home automation, IT networking, and advanced digital solutions for Melbourne. Hassle-free, professional, and future-proofed. Get a free quote today.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <link rel="icon" type="image/png" href="/images/logos/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Orbitron -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&display=swap" rel="stylesheet">
    
    <style>
        .canva-hero-font {
            font-family: 'Orbitron', Arial, sans-serif;
            letter-spacing: 0.03em;
            font-weight: 800;
        }
        .mesh-anim-bg {
            animation: mesh-drift 24s linear infinite alternate;
            will-change: transform, filter;
        }
        @keyframes mesh-drift {
            0% {
                transform: scale(1) translateY(0px) rotate(0deg);
                filter: hue-rotate(0deg) blur(0.2px);
            }
            25% {
                transform: scale(1.04) translateY(-18px) rotate(-2deg);
                filter: hue-rotate(8deg) blur(1.1px);
            }
            50% {
                transform: scale(1.07) translateY(26px) rotate(3deg);
                filter: hue-rotate(-12deg) blur(1.5px);
            }
            75% {
                transform: scale(1.03) translateY(-12px) rotate(-1.5deg);
                filter: hue-rotate(10deg) blur(1.0px);
            }
            100% {
                transform: scale(1) translateY(0px) rotate(0deg);
                filter: hue-rotate(0deg) blur(0.2px);
            }
        }
    </style>
</head>
<body class="bg-black">

<!-- HERO SECTION -->
<section class="relative overflow-hidden flex flex-col items-center text-center py-14 sm:py-20 px-2 bg-black">
    <!-- Inline true mesh SVG background, animated via group -->
    <svg class="absolute inset-0 w-full h-full pointer-events-none select-none" width="3840" height="900" viewBox="0 0 3840 900" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <defs>
        <linearGradient id="mesh1" x1="0" y1="0" x2="3840" y2="900" gradientUnits="userSpaceOnUse">
          <stop offset="0%" stop-color="#2fe5ee"/>
          <stop offset="20%" stop-color="#47e8b3"/>
          <stop offset="40%" stop-color="#438cff"/>
          <stop offset="60%" stop-color="#7b72ee"/>
          <stop offset="80%" stop-color="#3cb2fa"/>
          <stop offset="100%" stop-color="#2fe5ee"/>
        </linearGradient>
        <radialGradient id="mesh2" cx="30%" cy="25%" r="60%" fx="30%" fy="20%">
          <stop offset="0%" stop-color="#eafffd" stop-opacity="0.8"/>
          <stop offset="100%" stop-color="#2fe5ee" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="mesh3" cx="70%" cy="60%" r="50%" fx="70%" fy="65%">
          <stop offset="0%" stop-color="#46d8fc" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#7b72ee" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="mesh4" cx="60%" cy="20%" r="40%" fx="60%" fy="15%">
          <stop offset="0%" stop-color="#5fffca" stop-opacity="0.7"/>
          <stop offset="100%" stop-color="#438cff" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <g class="mesh-anim-bg">
        <rect width="3840" height="900" fill="url(#mesh1)" />
        <ellipse cx="1100" cy="200" rx="900" ry="400" fill="url(#mesh2)" />
        <ellipse cx="3000" cy="700" rx="1200" ry="600" fill="url(#mesh3)" />
        <ellipse cx="2400" cy="150" rx="700" ry="250" fill="url(#mesh4)" />
      </g>
    </svg>
    <div class="relative z-10 flex flex-col items-center space-y-5">
        <img src="/images/icons/home-assistant.svg" alt="KTP Digital Home Automation Logo" class="w-28 h-28 mx-auto mb-2 drop-shadow-xl" style="background:rgba(255,255,255,0.95); border-radius:100%; padding:15px;">
        <h1 class="canva-hero-font text-3xl sm:text-5xl text-white font-bold tracking-wide">
            HOME AUTOMATION<br>
            IT NETWORKING SERVICES<br>
            IT SOLUTIONS
        </h1>
        <div class="flex flex-wrap gap-4 justify-center mt-4">
            <a href="#contact" class="bg-white/80 hover:bg-[#37e2ef] text-blue-900 font-semibold px-8 py-3 rounded-full shadow-lg text-lg border-2 border-[#37e2ef] transition">ENQUIRE TODAY</a>
            <a href="#services" class="bg-[#3257ff] hover:bg-[#37e2ef] text-white font-semibold px-8 py-3 rounded-full shadow-lg text-lg border-2 border-white transition">EXPLORE MORE</a>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section id="services" class="bg-[#152b6a] py-14 px-4 text-center text-white relative z-10">
    <h2 class="canva-hero-font text-3xl sm:text-4xl mb-12 tracking-wide">OUR SERVICES</h2>
    <div class="flex flex-col sm:flex-row gap-8 max-w-5xl mx-auto justify-center items-stretch">
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#37e2ef] mb-4 bg-white flex items-center justify-center">
                <img src="/images/icons/home-assistant.svg" class="w-16 h-16 p-2" alt="Home Automation" />
            </div>
            <h3 class="canva-hero-font text-lg mb-2">Home Automation</h3>
            <p class="text-base opacity-90">Complete control of the service in one go. Hassle-free, tailored to your needs.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#37e2ef] mb-4 bg-white flex items-center justify-center">
                <img src="/images/icons/network.svg" class="w-16 h-16 p-2" alt="IT Networking" />
            </div>
            <h3 class="canva-hero-font text-lg mb-2">IT Networking</h3>
            <p class="text-base opacity-90">Secure, fast, and reliable network solutions for your business and home.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#37e2ef] mb-4 bg-white flex items-center justify-center">
                <img src="/images/icons/shield.svg" class="w-16 h-16 p-2" alt="IT Solutions" />
            </div>
            <h3 class="canva-hero-font text-lg mb-2">IT Solutions</h3>
            <p class="text-base opacity-90">Enterprise-grade support for all your technology needs.</p>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-14 px-4 bg-gradient-to-r from-[#1e3a8a] via-[#2563eb] to-[#37e2ef] text-white text-center">
    <h2 class="canva-hero-font text-3xl sm:text-4xl mb-8">Why Choose KTP Digital?</h2>
    <div class="max-w-3xl mx-auto grid gap-6">
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
            <h3 class="font-bold text-xl mb-2">✓ Premium Service</h3>
            <p>White glove IT consulting for Melbourne's finest properties</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
            <h3 class="font-bold text-xl mb-2">✓ Enterprise Experience</h3>
            <p>15+ years delivering $25K-$100K+ automation projects</p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6">
            <h3 class="font-bold text-xl mb-2">✓ Trusted Partners</h3>
            <p>Certified integrators for Tesla, Sonos, UniFi, and more</p>
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section id="contact" class="py-14 px-4 bg-gray-100 text-center">
    <h2 class="canva-hero-font text-3xl sm:text-4xl mb-8 text-gray-800">Get Started Today</h2>
    <p class="text-lg mb-8 text-gray-600 max-w-2xl mx-auto">
        Transform your property with enterprise-grade automation and IT solutions. 
        Our experts are ready to design the perfect system for your needs.
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/contact.php" class="bg-[#3257ff] hover:bg-[#2563eb] text-white font-bold px-10 py-4 rounded-full shadow-lg text-lg transition transform hover:scale-105">
            Request Consultation
        </a>
        <a href="tel:1300587348" class="bg-white hover:bg-gray-100 text-[#3257ff] font-bold px-10 py-4 rounded-full shadow-lg text-lg border-2 border-[#3257ff] transition transform hover:scale-105">
            Call 1300 KTP DIGITAL
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-8 px-4 text-center">
    <p>&copy; <?php echo date('Y'); ?> KTP Digital. Premium IT Solutions for Melbourne.</p>
    <p class="mt-2 text-sm opacity-75">Toorak | Brighton | Armadale | South Yarra | Malvern</p>
</footer>

</body>
</html>