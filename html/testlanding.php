<?php
$page_title  = "KTP Digital – Automation & IT Services";
$page_desc   = "Home automation, IT networking, and integrated digital services from KTP Digital. Based in Melbourne.";
$canonical   = "https://www.ktp.digital/newlanding.php";
$og_image    = "/images/logos/KTP Logo.png";
ob_start();
?>

<link rel="stylesheet" href="https://use.typekit.net/xyz0abc.css"> <!-- Replace with real Adobe Fonts embed if needed -->

<style>
  body {
    margin: 0;
    font-family: 'inter', sans-serif;
    background: #111;
    color: #fff;
    overflow-x: hidden;
  }

  .hero {
    background: radial-gradient(circle at top left, rgba(255,223,100,0.15), rgba(0,0,0,0.8)),
                url('/images/spiral-mesh.svg') no-repeat center center;
    background-size: cover;
    padding: 6rem 1rem 4rem;
    text-align: center;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .hero h1 {
    font-family: 'orbitron', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    letter-spacing: 0.1em;
    line-height: 1.4;
    margin: 0 auto 2rem;
    max-width: 800px;
    text-shadow: 0 0 12px rgba(0,174,255,0.35);
  }

  .hero .cta-buttons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .hero .cta-buttons a {
    background: #fff;
    color: #000;
    font-weight: bold;
    text-decoration: none;
    padding: 0.9rem 2rem;
    border-radius: 999px;
    box-shadow: 0 4px 20px rgba(255,255,255,0.15);
    transition: all 0.3s ease;
  }

  .hero .cta-buttons a:hover {
    background: #00bfff;
    color: #fff;
    box-shadow: 0 0 20px #00bfff;
  }
</style>

<section class="hero">
  <h1>
    HOME AUTOMATION<br>
    IT NETWORKING SERVICES<br>
    IT SOLUTIONS
  </h1>
  <div class="cta-buttons">
    <a href="/contact.php">Enquire Today</a>
    <a href="/about.php">Explore More</a>
  </div>
</section>

<?php
$content = ob_get_clean();
require 'layout.php';
renderLayout($page_title, $content, '', $page_desc, $canonical, $og_image);
?>
