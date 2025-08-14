<?php
// Database connection for lead capture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'get_quote') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        $stmt = $pdo->prepare("INSERT INTO premium_leads (name, email, phone, suburb, budget_range, ip_address, source, estimated_value) VALUES (?, ?, ?, ?, ?, ?, 'premium_landing_test', ?)");
        
        $budgetMap = ['consultation' => 5000, 'small' => 15000, 'medium' => 50000, 'large' => 100000, 'enterprise' => 200000];
        
        $stmt->execute([
            trim($_POST['name']), 
            trim($_POST['email']), 
            trim($_POST['phone']), 
            $_POST['suburb'], 
            $_POST['budget'], 
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $budgetMap[$_POST['budget']] ?? 50000
        ]);
        
        header('Location: /premium-landing-spiral-test.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = "Please try again.";
    }
}

require 'layout.php';

$page_title = "Premium Home Automation Melbourne | KTP Digital";
$page_desc = "White glove IT consulting and home automation for Melbourne's finest properties. Enterprise-grade solutions tailored to your needs.";

$extra_styles = <<<CSS
.hero-section {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    min-height: 70vh;
    display: flex;
    align-items: center;
    padding: 2rem 1rem;
}

.hero-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    padding: 3rem 2rem;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.gradient-title {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 3rem;
    font-weight: bold;
    margin: 1rem 0;
}

.solution-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.solution-item {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.solution-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
    border-color: #3b82f6;
}

.stats-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: white;
    padding: 3rem 1rem;
    text-align: center;
}

.contact-section {
    padding: 3rem 1rem;
    background: #f8fafc;
}

.contact-form {
    background: white;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 2rem;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

/* Fix Services dropdown */
.group:hover .group-hover\:opacity-100 {
    opacity: 1 !important;
}

.group:hover .group-hover\:visible {
    visibility: visible !important;
}

.group .absolute {
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
    max-height: 80vh;
    overflow-y: auto;
}

.group:hover .absolute {
    opacity: 1;
    visibility: visible;
}

/* Custom scrollbar for Services dropdown */
.group .absolute::-webkit-scrollbar {
    width: 8px;
}

.group .absolute::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.group .absolute::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.group .absolute::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Hide default footer */
footer {
    display: none;
}

/* Custom footer - Light theme */
.custom-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    color: #1f2937;
    padding: 3rem 1rem 2rem;
    margin-top: 3rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto 2rem;
}

.footer-section h4 {
    font-weight: bold;
    margin-bottom: 1rem;
    color: #1f2937;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section a {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #3b82f6;
}

.footer-bottom {
    border-top: 1px solid #e2e8f0;
    padding-top: 2rem;
    text-align: center;
    color: #6b7280;
}
CSS;

$content = '';

if (isset($_GET['success'])) {
    $content .= '<div class="fixed top-20 right-4 bg-green-600 text-white px-6 py-3 rounded-lg z-50 shadow-xl">
        ✅ Thank you! Our premium consultation team will contact you within 24 hours.
    </div>';
}

$content .= <<<HTML
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-card">
            <p style="color: #3b82f6; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Melbourne's Premium IT Consultancy</p>
            <h1 class="gradient-title">PREMIUM HOME<br>AUTOMATION</h1>
            <p style="font-size: 1.25rem; color: #4b5563; margin-bottom: 1rem;">
                Transform Your Melbourne Property Into an Intelligent Sanctuary
            </p>
            <p style="font-size: 1rem; color: #6b7280; margin-bottom: 2rem;">
                Tailored solutions for every budget and requirement
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="#contact" class="btn-primary" style="text-decoration: none; display: inline-block; min-width: 200px;">
                    Begin Your Journey
                </a>
                <a href="#solutions" style="border: 2px solid #3b82f6; color: #3b82f6; padding: 0.75rem 2rem; border-radius: 6px; text-decoration: none; display: inline-block; min-width: 200px; text-align: center;">
                    View Solutions
                </a>
            </div>
        </div>
    </section>
    
    <!-- Common Solutions -->
    <section id="solutions" style="padding: 3rem 1rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #1f2937; margin-bottom: 1rem;">Common Problems We Solve</h2>
                <p style="font-size: 1.25rem; color: #6b7280;">Click to explore solutions for your specific needs</p>
            </div>
            
            <div class="solution-grid">
                <a href="/integration_grid_test.php?category=garage" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚗</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Garage &amp; Gates</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Automatic doors, remote access</p>
                </a>
                <a href="/integration_grid_test.php?category=access" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">👤</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Facial Recognition</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Keyless entry, visitor ID</p>
                </a>
                <a href="/integration_grid_test.php?category=vehicle" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚙</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">License Plates</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Vehicle detection, access control</p>
                </a>
                <a href="/integration_grid_test.php?category=climate" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌡️</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Climate Control</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Multi-zone, scheduling</p>
                </a>
                <a href="/integration_grid_test.php?category=lighting" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Smart Lighting</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Scenes, motion sensing</p>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Premium Service Areas -->
    <section class="stats-section">
        <div style="max-width: 800px; margin: 0 auto;">
            <h3 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Trusted by Melbourne's Elite</h3>
            <p style="font-size: 1.25rem; opacity: 0.9; margin-bottom: 2rem;">Exclusively serving premium suburbs</p>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; font-size: 1.125rem;">
                <span>Toorak</span>
                <span style="opacity: 0.5;">•</span>
                <span>Brighton</span>
                <span style="opacity: 0.5;">•</span>
                <span>Armadale</span>
                <span style="opacity: 0.5;">•</span>
                <span>South Yarra</span>
                <span style="opacity: 0.5;">•</span>
                <span>Hawthorn</span>
            </div>
        </div>
    </section>
    
    <!-- Contact Form Section -->
    <section id="contact" class="contact-section">
        <div class="contact-form">
            <div style="text-align: center; margin-bottom: 2rem;">
                <p style="color: #3b82f6; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Private Consultation</p>
                <h2 class="gradient-title" style="font-size: 2.5rem;">REQUEST AN INVITATION</h2>
                <p style="font-size: 1.25rem; color: #4b5563;">
                    Limited availability for Melbourne's most discerning properties
                </p>
            </div>
            
            <form method="POST">
                <input type="hidden" name="action" value="get_quote">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <input type="text" name="name" required placeholder="Your Name" class="form-input">
                    <input type="email" name="email" required placeholder="Email Address" class="form-input">
                </div>
                
                <div class="form-group">
                    <input type="tel" name="phone" required placeholder="Phone Number" class="form-input">
                </div>
                
                <div class="form-group">
                    <select name="suburb" required class="form-input">
                        <option value="">Select Your Suburb</option>
                        <option value="toorak">Toorak</option>
                        <option value="brighton">Brighton</option>
                        <option value="armadale">Armadale</option>
                        <option value="south-yarra">South Yarra</option>
                        <option value="malvern">Malvern</option>
                        <option value="canterbury">Canterbury</option>
                        <option value="hawthorn">Hawthorn</option>
                        <option value="other">Other Premium Suburb</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <select name="budget" required class="form-input">
                        <option value="">Project Budget Range</option>
                        <option value="consultation">Initial Consultation</option>
                        <option value="small">Small Project</option>
                        <option value="medium">Medium Project</option>
                        <option value="large">Large Project</option>
                        <option value="enterprise">Enterprise Solution</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary">Submit Application</button>
            </form>
            
            <div style="text-align: center; margin-top: 2rem;">
                <p style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.1em;">Exclusively Serving</p>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Toorak • Brighton • Armadale • South Yarra</p>
                <p style="font-size: 0.75rem; color: #6b7280; margin-top: 1rem;">Response within 24 hours for qualified inquiries</p>
            </div>
        </div>
    </section>
    
    <!-- Custom Footer -->
    <div class="custom-footer">
        <div class="footer-grid">
            <div class="footer-section">
                <h4>Services</h4>
                <ul>
                    <li><a href="/automation.php">Home Automation</a></li>
                    <li><a href="/smallbiz.php">Small Business IT</a></li>
                    <li><a href="/enterprise.php">Enterprise Solutions</a></li>
                    <li><a href="/services.php">All Services</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Solutions</h4>
                <ul>
                    <li><a href="/integration_grid_test.php?category=garage">Garage & Gates</a></li>
                    <li><a href="/integration_grid_test.php?category=access">Facial Recognition</a></li>
                    <li><a href="/integration_grid_test.php?category=climate">Climate Control</a></li>
                    <li><a href="/integration_grid_test.php?category=lighting">Smart Lighting</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="/about.php">About Us</a></li>
                    <li><a href="/contact.php">Contact</a></li>
                    <li><a href="/privacy.php">Privacy Policy</a></li>
                    <li><a href="/terms.php">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <ul>
                    <li><a href="/contact.php">Schedule Consultation</a></li>
                    <li><a href="mailto:info@ktp.digital">info@ktp.digital</a></li>
                    <li>Melbourne, Australia</li>
                    <li>Premium IT Solutions</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> KTP Digital - Premium IT Solutions</p>
            <p style="margin-top: 0.5rem; font-size: 0.875rem;">Serving Toorak, Brighton, Armadale, South Yarra, and Melbourne's finest suburbs</p>
        </div>
    </div>
HTML;

renderLayout($page_title, $content, $extra_styles, $page_desc);
?>