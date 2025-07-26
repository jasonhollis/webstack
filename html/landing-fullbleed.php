<?php
$page_title     = "KTP Digital | Smarter Home + IT Systems";
$page_desc      = "Open-source automation that puts privacy, speed, and real-world support at the centre. Built for modern homes and serious systems.";
$canonical      = "https://www.ktp.digital/landing-fullbleed.php";
$og_image       = "/images/logos/KTP Logo.png";
$use_orbitron   = true;
$fullbleed      = true;
$hide_nav       = true;

ob_start();
?>

<section class="hero">
  <video class="hero-video" autoplay muted loop playsinline poster="/images/spiral_poster.jpg">
    <source src="/images/spiral_4k.mp4" type="video/mp4">
    <source src="/images/spiral_fallback.gif" type="image/gif">
  </video>

  <div class="hero-overlay">
    <div class="hero-content">
      <h1>Smarter. Faster. Local-first.</h1>
      <p class="hero-subtext">
        Open-source automation that puts privacy, speed, and<br>
        real-world support at the centre. Built for modern homes<br>
        and serious systems.
      </p>
      <div class="button-row">
        <a href="/contact.php">Enquire Now</a>
        <a href="/about.php">How We Work</a>
      </div>
    </div>
  </div>
</section>

<section class="section-blurb">
  <h2>Trusted Technology, Seamless Integration</h2>
  <p>
    Our systems connect lighting, media, security, energy and enterprise IT<br>
    into one reliable platform. Designed for performance. Built for control.
  </p>
  <div class="integration-icons">
    <img src="/images/icons/apple.png" alt="Apple" />
    <img src="/images/icons/qnap.png" alt="QNAP" />
    <img src="/images/icons/ring.png" alt="Ring" />
    <img src="/images/icons/tailscale.png" alt="Tailscale" />
    <img src="/images/icons/chatgpt-mark.png" alt="OpenAI" />
    <img src="/images/icons/homekit.png" alt="HomeKit" />
  </div>
</section>

<style>
.hero {
  position: relative;
  width: 100%;
  height: 100vh;
  overflow: hidden;
}
.hero-video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: 0;
  transform: translate(-50%, -50%);
  object-fit: cover;
  opacity: 0.9;
}
.hero-overlay {
  position: relative;
  z-index: 1;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0,0,0,0.5);
}
.hero-content {
  text-align: center;
  padding: 2rem;
  background: rgba(0,0,0,0.6);
  border-radius: 3rem;
  backdrop-filter: blur(5px);
  max-width: 90%;
}
.hero-content h1 {
  font-size: 2.6rem;
  color: #00caff;
  text-shadow: 0 0 8px #00caff;
  margin-bottom: 1rem;
}
.hero-subtext {
  font-size: 1rem;
  color: #eee;
  line-height: 1.6;
  margin-bottom: 2rem;
}
.button-row {
  display: flex;
  justify-content: center;
  gap: 1.5rem;
  flex-wrap: wrap;
}
.button-row a {
  background: white;
  color: black;
  font-weight: bold;
  padding: 1rem 2rem;
  border-radius: 100px;
  text-decoration: none;
  box-shadow: 0 6px 12px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
.button-row a:hover {
  background: #00caff;
  color: white;
  transform: scale(1.05);
  box-shadow: 0 0 12px #00caff;
}

.section-blurb {
  background: #000;
  color: #fff;
  text-align: center;
  padding: 4rem 2rem;
}
.section-blurb h2 {
  font-size: 2rem;
  margin-bottom: 1.2rem;
}
.section-blurb p {
  font-size: 1.1rem;
  line-height: 1.6;
  margin-bottom: 2rem;
}
.integration-icons {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}
.integration-icons img {
  max-height: 40px;
  max-width: 100px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}
</style>

<?php
$content = ob_get_clean();
require 'layout.php';
