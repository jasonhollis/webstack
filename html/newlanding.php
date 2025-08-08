<?php
require_once __DIR__ . '/layout.php';

$page_title = "KTP Digital | Home Automation & IT Services Melbourne";
$page_desc = "Home automation, IT networking, and advanced digital solutions for Melbourne. Hassle-free, professional, and future-proofed. Get a free quote today.";

$content = <<<HTML
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
                <img src="https://img.icons8.com/external-flat-icons-inmotus-design/68/000000/external-networking-internet-security-flat-icons-inmotus-design.png" alt="IT Networking" />
            </div>
            <h3 class="canva-hero-font text-lg mb-2">IT Networking Services</h3>
            <p class="text-base opacity-90">Streamline, secure, and optimize your entire home or business network.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#37e2ef] mb-4 bg-white flex items-center justify-center">
                <img src="https://img.icons8.com/fluency/68/000000/artificial-intelligence.png" alt="Advanced Solutions" />
            </div>
            <h3 class="canva-hero-font text-lg mb-2">Advanced Solutions</h3>
            <p class="text-base opacity-90">Custom, future-proofed digital solutions for the smart home era.</p>
        </div>
    </div>
</section>

<!-- NODE CHART SECTION (Home Automation Networks) -->
<section class="bg-[#2249c9] py-14 px-2 text-white text-center relative">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-6 tracking-wide">HOME AUTOMATION</h2>
    <div class="max-w-3xl mx-auto flex flex-col items-center">
        <img src="/images/HOME.svg" alt="Network Node Chart" class="w-32 h-32 mb-5 drop-shadow-xl" />
        <div class="flex flex-wrap justify-center gap-4 mt-2">
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Alexa</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">HomeKit</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">MQTT</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Zigbee</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Z-Wave</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Google Home</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Tuya</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Matter</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Apple TV</span>
            <span class="bg-[#37e2ef] px-5 py-2 rounded-full font-bold text-blue-900 text-sm">Thread</span>
        </div>
        <div class="mt-7 flex flex-wrap gap-4 justify-center">
            <a href="#contact" class="bg-white/80 hover:bg-[#37e2ef] text-blue-900 font-semibold px-7 py-2 rounded-full shadow-lg text-base border-2 border-[#37e2ef] transition">ENQUIRE NOW</a>
            <a href="#projects" class="bg-[#3257ff] hover:bg-[#37e2ef] text-white font-semibold px-7 py-2 rounded-full shadow-lg text-base border-2 border-white transition">PAST PROJECTS</a>
        </div>
    </div>
</section>

<!-- PROJECTS SECTION -->
<section id="projects" class="bg-[#152b6a] py-14 px-4 text-white text-center">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-8 tracking-wide">HOME AUTOMATION<br><span class="text-base font-normal">(PAST PROJECTS)</span></h2>
    <div class="flex flex-col sm:flex-row gap-8 max-w-5xl mx-auto justify-center items-stretch">
        <div class="bg-[#1c3167]/90 rounded-2xl flex-1 px-3 py-7 flex flex-col items-center shadow-lg">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=500&q=80" class="rounded-lg w-full max-w-xs mb-4" alt="EV Charging Automation" />
            <h3 class="canva-hero-font text-lg mb-1">EV Charging Automation</h3>
            <p class="text-sm opacity-90 mb-2">All EV charger installs, custom automations, and smart controls integrated to your needs.</p>
            <div class="flex items-center gap-2 text-xs justify-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-7 h-7 rounded-full" alt="Expert 1"/>
                <span>Enquire now</span>
            </div>
        </div>
        <div class="bg-[#1c3167]/90 rounded-2xl flex-1 px-3 py-7 flex flex-col items-center shadow-lg">
            <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=500&q=80" class="rounded-lg w-full max-w-xs mb-4" alt="Advance Scenes" />
            <h3 class="canva-hero-font text-lg mb-1">Advance Scenes</h3>
            <p class="text-sm opacity-90 mb-2">Automations and smart routines tailored to every scenario using top-tier services.</p>
            <div class="flex items-center gap-2 text-xs justify-center">
                <img src="https://randomuser.me/api/portraits/men/52.jpg" class="w-7 h-7 rounded-full" alt="Expert 2"/>
                <span>Enquire now</span>
            </div>
        </div>
        <div class="bg-[#1c3167]/90 rounded-2xl flex-1 px-3 py-7 flex flex-col items-center shadow-lg">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80" class="rounded-lg w-full max-w-xs mb-4" alt="Blinds Automation" />
            <h3 class="canva-hero-font text-lg mb-1">Blinds Automation</h3>
            <p class="text-sm opacity-90 mb-2">Home & office smart shades, automated and voice controlled for any scenario.</p>
            <div class="flex items-center gap-2 text-xs justify-center">
                <img src="https://randomuser.me/api/portraits/men/68.jpg" class="w-7 h-7 rounded-full" alt="Expert 3"/>
                <span>Enquire now</span>
            </div>
        </div>
    </div>
</section>

<!-- EARLY REVIEWS -->
<section class="bg-[#2249c9] py-14 px-2 text-white text-center">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-8 tracking-wide">EARLY REVIEWS</h2>
    <div class="flex flex-col sm:flex-row gap-8 max-w-5xl mx-auto justify-center items-stretch">
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-7 flex flex-col items-center shadow-lg">
            <p class="text-lg mb-3 italic font-medium opacity-90">Total knock-out smart quotes from people who have used our services & are your reference point for customer-first home automation.</p>
            <div class="flex items-center gap-2">
                <img src="https://randomuser.me/api/portraits/men/20.jpg" class="w-10 h-10 rounded-full border-2 border-[#37e2ef]" alt="Hunter Mason"/>
                <span class="font-bold">Hunter Mason</span>
            </div>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-7 flex flex-col items-center shadow-lg">
            <p class="text-lg mb-3 italic font-medium opacity-90">Technically excellent, quotes from people who value your time, trust, and want the best possible commitment to your setup.</p>
            <div class="flex items-center gap-2">
                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="w-10 h-10 rounded-full border-2 border-[#37e2ef]" alt="Carey Sloan"/>
                <span class="font-bold">Carey Sloan</span>
            </div>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-7 flex flex-col items-center shadow-lg">
            <p class="text-lg mb-3 italic font-medium opacity-90">Great value, super-clean installs, and exactly what you want from a smart home provider in 2025.</p>
            <div class="flex items-center gap-2">
                <img src="https://randomuser.me/api/portraits/men/34.jpg" class="w-10 h-10 rounded-full border-2 border-[#37e2ef]" alt="Devin Ellis"/>
                <span class="font-bold">Devin Ellis</span>
            </div>
        </div>
    </div>
</section>

<!-- IT NETWORKING SERVICES SECTION -->
<section class="bg-[#152b6a] py-14 px-4 text-white text-center">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-8 tracking-wide">IT NETWORKING SERVICES</h2>
    <div class="flex flex-col sm:flex-row gap-8 max-w-5xl mx-auto justify-center items-stretch">
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#37e2ef] mb-4">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M16 17v1a3 3 0 01-6 0v-1"></path>
                  <path d="M6 7V6a6 6 0 0112 0v1"></path>
                  <rect width="20" height="12" x="2" y="10" rx="2"></rect>
                </svg>
            </div>
            <h3 class="canva-hero-font text-lg mb-2">Cloud Integration</h3>
            <p class="text-base opacity-90">Customized to your business. We’re ready to deliver at any scale whether cloud or hybrid local.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#37e2ef] mb-4">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10"></circle>
                  <path d="M2 12h20M12 2v20"></path>
                </svg>
            </div>
            <h3 class="canva-hero-font text-lg mb-2">Expert Recommendations</h3>
            <p class="text-base opacity-90">Benefit from top-tier software, hardware, and network design for your needs.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-[#37e2ef] mb-4">
                <svg class="w-9 h-9 text-blue-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                  <path d="M3 9h18"></path>
                  <path d="M9 21V9"></path>
                </svg>
            </div>
            <h3 class="canva-hero-font text-lg mb-2">Automation & Management</h3>
            <p class="text-base opacity-90">Assign and create automations for workflows to bring effortless local or remote management.</p>
        </div>
    </div>
</section>

<!-- HOME AUTOMATION SECTION (DEVICE IMAGE) -->
<section class="bg-[#2249c9] py-14 px-2 text-white text-center">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-8 tracking-wide">HOME AUTOMATION</h2>
    <div class="flex flex-col sm:flex-row gap-10 max-w-5xl mx-auto justify-center items-center">
        <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80" class="rounded-2xl shadow-lg max-w-xs mx-auto" alt="Home Automation Device" />
        <div class="text-left max-w-xl mx-auto space-y-4">
            <p class="text-lg font-semibold">Should I need your product, service, or smarts? You do so to seek a single right solution, that’s all that matters. That’s what you want, right? It’s also how you get the best possible outcome, doing it right the first time, with a results-driven approach that’s as hassle-free as your devices.</p>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section id="faq" class="bg-[#152b6a] py-14 px-4 text-white text-center">
    <h2 class="canva-hero-font text-2xl sm:text-3xl mb-8 tracking-wide">FAQS</h2>
    <div class="flex flex-col sm:flex-row gap-8 max-w-5xl mx-auto justify-center items-stretch">
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <h3 class="canva-hero-font text-lg mb-2">Why choose KTP Digital?</h3>
            <p class="text-base opacity-90">Industry leading, tailored to you, years of technical and customer experience. Every detail counts for your smart home and network—made easy, smooth, and secure for your needs.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <h3 class="canva-hero-font text-lg mb-2">How long will the project take?</h3>
            <p class="text-base opacity-90">Most projects finished in 1-2 weeks, every project different, but we make it fast, transparent, and reliable. No question—work is planned, quoted, and delivered to your timeline.</p>
        </div>
        <div class="bg-[#20306a]/80 rounded-2xl flex-1 px-4 py-8 flex flex-col items-center shadow-lg">
            <h3 class="canva-hero-font text-lg mb-2">How much will it cost?</h3>
            <p class="text-base opacity-90">Transparent, honest, with a quote and timeline before you commit. No surprise bills—just the best outcome, every time.</p>
        </div>
    </div>
</section>

<!-- FINAL CTA FOOTER SECTION -->
<section id="contact" class="relative overflow-hidden flex flex-col items-center text-center py-14 sm:py-20 px-2 bg-black">
    <!-- Inline true mesh SVG, animated, flipped for footer -->
    <svg class="absolute inset-0 w-full h-full pointer-events-none select-none" style="transform: scaleY(-1);" width="3840" height="900" viewBox="0 0 3840 900" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <defs>
        <linearGradient id="mesh1f" x1="0" y1="0" x2="3840" y2="900" gradientUnits="userSpaceOnUse">
          <stop offset="0%" stop-color="#2fe5ee"/>
          <stop offset="20%" stop-color="#47e8b3"/>
          <stop offset="40%" stop-color="#438cff"/>
          <stop offset="60%" stop-color="#7b72ee"/>
          <stop offset="80%" stop-color="#3cb2fa"/>
          <stop offset="100%" stop-color="#2fe5ee"/>
        </linearGradient>
        <radialGradient id="mesh2f" cx="30%" cy="25%" r="60%" fx="30%" fy="20%">
          <stop offset="0%" stop-color="#eafffd" stop-opacity="0.8"/>
          <stop offset="100%" stop-color="#2fe5ee" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="mesh3f" cx="70%" cy="60%" r="50%" fx="70%" fy="65%">
          <stop offset="0%" stop-color="#46d8fc" stop-opacity="0.9"/>
          <stop offset="100%" stop-color="#7b72ee" stop-opacity="0"/>
        </radialGradient>
        <radialGradient id="mesh4f" cx="60%" cy="20%" r="40%" fx="60%" fy="15%">
          <stop offset="0%" stop-color="#5fffca" stop-opacity="0.7"/>
          <stop offset="100%" stop-color="#438cff" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <g class="mesh-anim-bg">
        <rect width="3840" height="900" fill="url(#mesh1f)" />
        <ellipse cx="1100" cy="200" rx="900" ry="400" fill="url(#mesh2f)" />
        <ellipse cx="3000" cy="700" rx="1200" ry="600" fill="url(#mesh3f)" />
        <ellipse cx="2400" cy="150" rx="700" ry="250" fill="url(#mesh4f)" />
      </g>
    </svg>
    <div class="relative z-10 flex flex-col items-center space-y-5">
        <h2 class="canva-hero-font text-3xl sm:text-4xl text-white font-bold tracking-wide mb-3">GET A FREE QUOTE.<br>CALL OR EMAIL US TODAY!</h2>
        <div class="text-lg text-white mb-4">
            <div class="mb-2"><span class="font-bold">PHONE:</span> (123) 456-7890</div>
            <div class="mb-2"><span class="font-bold">EMAIL:</span> hello@yourwebsite.com</div>
            <div class="flex gap-5 mt-3 justify-center">
                <a href="#" class="inline-flex items-center text-white hover:text-[#37e2ef]">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.59-2.47.69a4.3 4.3 0 0 0 1.88-2.36 8.73 8.73 0 0 1-2.75 1.05 4.27 4.27 0 0 0-7.3 3.89A12.13 12.13 0 0 1 3.09 4.95a4.28 4.28 0 0 0 1.32 5.7 4.2 4.2 0 0 1-1.93-.53v.05a4.27 4.27 0 0 0 3.43 4.19 4.2 4.2 0 0 1-1.92.07 4.28 4.28 0 0 0 4 2.97A8.58 8.58 0 0 1 2 19.55a12.14 12.14 0 0 0 6.57 1.92c7.88 0 12.2-6.53 12.2-12.2l-.01-.56A8.77 8.77 0 0 0 24 4.59a8.67 8.67 0 0 1-2.54.7z"/></svg>
                </a>
                <a href="#" class="inline-flex items-center text-white hover:text-[#37e2ef]">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.56v14.91c0 .85-.69 1.54-1.54 1.54h-20.92C.7 21 .01 20.31.01 19.47V4.56C.01 3.71.7 3.02 1.54 3.02h20.91c.85 0 1.54.69 1.54 1.54zM8.6 17.2h2.62V9.73H8.6v7.47zm1.31-8.46a1.51 1.51 0 1 1 0-3.01 1.51 1.51 0 0 1 0 3zm7.4 8.46h2.61v-4.19c0-.99-.02-2.27-1.38-2.27-1.39 0-1.6 1.09-1.6 2.2v4.26zm-1.3-7.47c.84 0 1.52-.68 1.52-1.52s-.68-1.51-1.52-1.51a1.51 1.51 0 1 0 0 3.03z"/></svg>
                </a>
                <a href="#" class="inline-flex items-center text-white hover:text-[#37e2ef]">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.59-2.47.69a4.3 4.3 0 0 0 1.88-2.36 8.73 8.73 0 0 1-2.75 1.05 4.27 4.27 0 0 0-7.3 3.89A12.13 12.13 0 0 1 3.09 4.95a4.28 4.28 0 0 0 1.32 5.7 4.2 4.2 0 0 1-1.93-.53v.05a4.27 4.27 0 0 0 3.43 4.19 4.2 4.2 0 0 1-1.92.07 4.28 4.28 0 0 0 4 2.97A8.58 8.58 0 0 1 2 19.55a12.14 12.14 0 0 0 6.57 1.92c7.88 0 12.2-6.53 12.2-12.2l-.01-.56A8.77 8.77 0 0 0 24 4.59a8.67 8.67 0 0 1-2.54.7z"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
HTML;

renderLayout($page_title, $content, '', $page_desc, '', '');
?>
