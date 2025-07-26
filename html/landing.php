<?php
$page_title = "Home Automation and IT Solutions | KTP Digital";
$page_desc  = "Premium smart home systems, networking, and enterprise IT services by KTP Digital. Fast, secure, local-first.";
$canonical  = "https://www.ktp.digital/landing-fullbleed.php";
$og_image   = "/images/logos/KTP Logo.png";

ob_start();
?>

<section class="hero">
  <div class="hero-content">
    <h1>
      HOME AUTOMATION<br>
      IT NETWORKING SERVICES<br>
      IT SOLUTIONS
    </h1>
    <div class="button-row">
      <a href="/contact.php">Enquire Today</a>
      <a href="/about.php">Explore More</a>
    </div>
  </div>
</section>

<style>
.hero {
  margin: 0;
  padding: 0;
  width: 100vw;
  height: 100vh;
  background: linear-gradient(135deg, #1a1a1a, #777);
  background-image: url('/images/spiral-mesh.svg');
  background-repeat: no-repeat;
  background-position: right center;
  background-size: cover;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  overflow: hidden;
}

.hero-content h1 {
  font-family: 'Orbitron', sans-serif;
  font-size: 3rem;
  color: #00aaff;
  letter-spacing: 0.1em;
  line-height: 1.6;
  text-shadow: 0 0 5px #00aaff;
  margin-bottom: 2rem;
}

.button-row {
  display: flex;
  gap: 1.5rem;
  justify-content: center;
}

.button-row a {
  font-family: sans-serif;
  background: white;
  color: black;
  font-weight: bold;
  padding: 1rem 2rem;
  border-radius: 100px;
  text-decoration: none;
  box-shadow: 0 8px 12px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}

.button-row a:hover {
  background: #00caff;
  color: white;
  transform: scale(1.05);
  box-shadow: 0 0 12px #00caff;
}

@media (max-width: 600px) {
  .hero-content h1 {
    font-size: 1.8rem;
    letter-spacing: 0.05em;
  }

  .button-row {
    flex-direction: column;
    gap: 1rem;
  }

  .button-row a {
    font-size: 1rem;
    padding: 0.9rem 2rem;
  }
}
</style>

<?php
$content = ob_get_clean();
require 'layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
