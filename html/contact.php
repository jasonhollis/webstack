<?php include_once __DIR__."/analytics_logger.php"; ?>
<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'contact') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        // Insert into premium_leads table
        $stmt = $pdo->prepare("INSERT INTO premium_leads (name, email, phone, message, suburb, ip_address, source) VALUES (?, ?, ?, ?, ?, ?, 'contact_form')");
        
        $stmt->execute([
            trim($_POST['name']), 
            trim($_POST['email']), 
            trim($_POST['phone'] ?? ''), 
            trim($_POST['message'] ?? ''),
            trim($_POST['suburb'] ?? 'Not specified'),
            $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        header('Location: /contact.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = "Please try again or email us directly.";
    }
}

require 'layout.php';

$page_title = "Contact KTP Digital | Premium IT Solutions Melbourne";
$page_desc  = "Get in touch with KTP Digital for expert IT consulting, home automation, and enterprise networking solutions in Melbourne.";

$content = '<section class="max-w-4xl mx-auto p-6">';

if (isset($_GET['success'])) {
    $content .= '<div class="bg-green-600 text-white px-6 py-4 rounded-lg mb-6">
        ✅ Thank you for contacting us! We\'ll respond within 24 hours.
    </div>';
}

if (isset($error)) {
    $content .= '<div class="bg-red-600 text-white px-6 py-4 rounded-lg mb-6">
        ⚠️ ' . htmlspecialchars($error) . '
    </div>';
}

$content .= <<<HTML

  <h1 class="text-4xl font-bold mb-6">Contact KTP Digital</h1>
  
  <div class="grid md:grid-cols-2 gap-8">
    <!-- Contact Form -->
    <div>
      <h2 class="text-2xl font-semibold mb-4">Get in Touch</h2>
      <form method="POST" action="/contact.php" class="space-y-4">
        <input type="hidden" name="action" value="contact">
        
        <div>
          <label for="name" class="block text-sm font-medium mb-1">Name *</label>
          <input type="text" id="name" name="name" required 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                 placeholder="Your Name">
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium mb-1">Email *</label>
          <input type="email" id="email" name="email" required 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                 placeholder="your@email.com">
        </div>
        
        <div>
          <label for="phone" class="block text-sm font-medium mb-1">Phone</label>
          <input type="tel" id="phone" name="phone" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                 placeholder="0400 000 000">
        </div>
        
        <div>
          <label for="suburb" class="block text-sm font-medium mb-1">Suburb</label>
          <input type="text" id="suburb" name="suburb" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                 placeholder="e.g., Toorak, Brighton, Melbourne CBD">
        </div>
        
        <div>
          <label for="message" class="block text-sm font-medium mb-1">Message</label>
          <textarea id="message" name="message" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Tell us about your project or requirements..."></textarea>
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
          Send Message
        </button>
      </form>
    </div>
    
    <!-- Contact Information -->
    <div>
      <h2 class="text-2xl font-semibold mb-4">Direct Contact</h2>
      
      <div class="space-y-4 text-lg">
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          <div>
            <p class="font-medium">Email</p>
            <a href="mailto:info@ktp.digital" class="text-blue-600 hover:text-blue-800">info@ktp.digital</a>
          </div>
        </div>
        
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          <div>
            <p class="font-medium">Service Areas</p>
            <p class="text-gray-600">Melbourne Metropolitan Area</p>
            <p class="text-sm text-gray-500 mt-1">Specializing in Toorak, Brighton, Armadale, South Yarra</p>
          </div>
        </div>
        
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div>
            <p class="font-medium">Business Hours</p>
            <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
            <p class="text-gray-600">Saturday: 10:00 AM - 2:00 PM</p>
            <p class="text-sm text-gray-500 mt-1">24/7 emergency support for managed clients</p>
          </div>
        </div>
      </div>
      
      <div class="mt-8 p-6 bg-blue-50 rounded-lg">
        <h3 class="font-semibold mb-2">Why Choose KTP Digital?</h3>
        <ul class="text-sm space-y-1 text-gray-700">
          <li>• Enterprise-grade solutions for homes and businesses</li>
          <li>• Local Melbourne team with 20+ years experience</li>
          <li>• Premium automation and networking expertise</li>
          <li>• White glove service for discerning clients</li>
        </ul>
      </div>
    </div>
  </div>
</section>
HTML;

$canonical = "https://www.ktp.digital/contact.php";
renderLayout($page_title, $content, '', $page_desc, $canonical);
?>