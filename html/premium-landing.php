<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'get_quote') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        $stmt = $pdo->prepare("INSERT INTO premium_leads (name, email, phone, suburb, budget_range, ip_address, source, estimated_value) VALUES (?, ?, ?, ?, ?, ?, 'premium_landing', ?)");
        
        $budgetMap = ['15-25k' => 20000, '25-50k' => 37500, '50k+' => 75000, 'enterprise' => 100000];
        
        $stmt->execute([
            trim($_POST['name']), trim($_POST['email']), trim($_POST['phone']), 
            $_POST['suburb'], $_POST['budget'], $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $budgetMap[$_POST['budget']] ?? 50000
        ]);
        
        header('Location: /premium-landing.php?success=1&lead_id=' . $pdo->lastInsertId());
        exit;
    } catch (Exception $e) {
        $error = "Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Home Automation Melbourne | KTP Digital</title>
    <link rel="stylesheet" href="https://use.typekit.net/zqf3vpv.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-video {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; z-index: 1; opacity: 0.9;
        }
        .hero-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.3) 0%, rgba(30, 58, 138, 0.2) 100%);
            z-index: 2;
        }
        .hero-content { position: relative; z-index: 10; }
    </style>
</head>
<body class="bg-white">
    <?php if (isset($_GET['success'])): ?>
    <div class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg z-50">
        ✅ Thank you! We'll contact you within 24 hours.
    </div>
    <?php endif; ?>

    <nav class="bg-white shadow-sm border-b relative z-20">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="/images/logos/KTP Logo.png" alt="KTP Digital" class="h-10 mr-4">
                <span class="font-bold text-xl text-blue-900">KTP DIGITAL</span>
            </div>
        </div>
    </nav>

    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="/images/spiral_small_1080p.webm" type="video/webm">
            <source src="/images/spiral_1080p.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        
        <div class="hero-content container mx-auto px-4 py-20 text-center">
            <div class="max-w-4xl mx-auto">
                <div class="bg-black bg-opacity-80 p-8 rounded-2xl mb-8 text-white">
                    <h1 class="text-5xl md:text-7xl font-bold mb-4" style="font-family: 'bank-gothic-bt', sans-serif;">
                        Premium Home Automation
                    </h1>
                    <h2 class="text-3xl md:text-4xl font-bold text-yellow-400 mb-6">
                        for Melbourne's Finest Properties
                    </h2>
                    <p class="text-xl mb-6">
                        White glove IT consulting with enterprise-grade automation<br>
                        from $15,000 to $200,000+
                    </p>
                </div>
                
                <button onclick="document.getElementById('form').scrollIntoView({behavior: 'smooth'})" 
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-12 py-4 rounded-lg text-xl">
                    Schedule Consultation
                </button>
            </div>
        </div>
    </div>

    <div id="form" class="py-20 bg-blue-900 text-white">
        <div class="container mx-auto px-4 max-w-2xl">
            <h2 class="text-4xl font-bold text-center mb-12">Schedule Your Consultation</h2>
            <form method="POST" class="space-y-6">
                <input type="hidden" name="action" value="get_quote">
                <input type="text" name="name" required placeholder="Your Name" 
                       class="w-full p-4 rounded-lg bg-white bg-opacity-10 text-white border border-white border-opacity-20">
                <input type="email" name="email" required placeholder="Email Address"
                       class="w-full p-4 rounded-lg bg-white bg-opacity-10 text-white border border-white border-opacity-20">
                <input type="tel" name="phone" required placeholder="Phone Number"
                       class="w-full p-4 rounded-lg bg-white bg-opacity-10 text-white border border-white border-opacity-20">
                <select name="suburb" required class="w-full p-4 rounded-lg bg-white bg-opacity-10 text-white border border-white border-opacity-20">
                    <option value="">Select Suburb</option>
                    <option value="toorak">Toorak</option>
                    <option value="brighton">Brighton</option>
                    <option value="armadale">Armadale</option>
                    <option value="other">Other</option>
                </select>
                <select name="budget" required class="w-full p-4 rounded-lg bg-white bg-opacity-10 text-white border border-white border-opacity-20">
                    <option value="">Investment Range</option>
                    <option value="15-25k">$15,000 - $25,000</option>
                    <option value="25-50k">$25,000 - $50,000</option>
                    <option value="50k+">$50,000+</option>
                    <option value="enterprise">Enterprise Project</option>
                </select>
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-lg text-xl">
                    Request Consultation
                </button>
            </form>
        </div>
    </div>
</body>
</html>
