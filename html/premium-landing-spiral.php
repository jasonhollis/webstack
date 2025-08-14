<?php
require '/opt/webstack/vendor/autoload.php'; // PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

// Database connection for lead capture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'get_quote') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        // Build full name
        $full_name = trim($_POST['first_name']) . ' ' . trim($_POST['surname']);
        
        // Build message with project details
        $message = "Project Type: " . $_POST['project_type'] . "\n";
        if (!empty($_POST['integrations'])) {
            $message .= "Integrations: " . implode(', ', $_POST['integrations']) . "\n";
        }
        $message .= "Property: " . $_POST['property_type'] . ", ";
        $message .= $_POST['bedrooms'] . " bed, " . $_POST['rooms'] . " other rooms\n";
        if (!empty($_POST['details'])) {
            $message .= "Details: " . $_POST['details'] . "\n";
        }
        
        // Calculate estimated value and lead score
        $budgetMap = [
            'Under $5,000' => 5000,
            '$5,000 - $15,000' => 15000, 
            '$15,000 - $35,000' => 35000,
            '$35,000 - $75,000' => 75000,
            '$75,000+' => 100000,
            'Prefer to discuss' => 50000
        ];
        $estimated_value = $budgetMap[$_POST['budget']] ?? 50000;
        
        // Calculate lead score
        $lead_score = 50; // Base score
        if ($estimated_value >= 75000) $lead_score += 25;
        elseif ($estimated_value >= 35000) $lead_score += 15;
        elseif ($estimated_value >= 15000) $lead_score += 10;
        
        // Add points for integrations
        if (!empty($_POST['integrations'])) {
            $lead_score += count($_POST['integrations']) * 5;
        }
        
        $stmt = $pdo->prepare("INSERT INTO premium_leads 
            (name, email, phone, suburb, postcode, budget_range, project_type, message, 
             ip_address, source, estimated_value, lead_score) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'premium_landing_spiral', ?, ?)");
        
        $stmt->execute([
            $full_name,
            trim($_POST['email']), 
            trim($_POST['phone']), 
            trim($_POST['suburb']),
            trim($_POST['postcode']),
            $_POST['budget'],
            $_POST['project_type'],
            $message,
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $estimated_value,
            $lead_score
        ]);
        
        // Send email notification
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.mailgun.org';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'scanner@mailgun.ktp.digital';
            $mail->Password   = 'ScanMePlease888';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            $mail->setFrom('info@ktp.digital', 'KTP Digital Lead Form');
            $mail->addAddress('leads@ktp.digital');
            $mail->addReplyTo(trim($_POST['email']), $full_name);
            
            // Build email body
            $email_body = "New Lead from Premium Landing Page (Spiral)\n\n";
            $email_body .= "Name: {$full_name}\n";
            $email_body .= "Email: " . trim($_POST['email']) . "\n";
            $email_body .= "Phone: " . trim($_POST['phone']) . "\n";
            $email_body .= "Suburb: " . trim($_POST['suburb']) . "\n";
            $email_body .= "Postcode: " . trim($_POST['postcode']) . "\n";
            $email_body .= "Budget: " . $_POST['budget'] . "\n";
            $email_body .= "Lead Score: {$lead_score}\n";
            $email_body .= "\n{$message}";
            
            $project_label = [
                'updates' => 'Updates to Existing',
                'newsystem' => 'New System',
                'newbuild' => 'New Build'
            ][$_POST['project_type']] ?? $_POST['project_type'];
            
            $mail->Subject = "[Home Automation] New Lead - {$project_label} [{$full_name}]";
            $mail->Body = $email_body;
            
            $mail->send();
        } catch (Exception $e) {
            // Log error but don't stop the process
            error_log("Email send failed: " . $e->getMessage());
        }
        
        // Also log to file
        $log_entry = date('Y-m-d H:i:s') . " | {$full_name} | " . trim($_POST['email']) . " | " . trim($_POST['phone']) . " | Lead Score: {$lead_score}\n";
        @file_put_contents('/opt/webstack/logs/leads.log', $log_entry, FILE_APPEND);
        
        header('Location: /premium-landing-spiral.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = "Please try again.";
    }
}

require 'layout.php';

$page_title = "Premium Home Automation Melbourne | KTP Digital";
$page_desc = "White glove IT consulting and home automation for Melbourne's finest properties. Enterprise-grade solutions tailored to your needs.";

$extra_styles = <<<CSS
/* Spiral background container */
.spiral-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    opacity: 0.6;
    pointer-events: none;
}

.spiral-video {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.8) contrast(1.1);
}

.gradient-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, 
        rgba(15, 23, 42, 0.85) 0%,
        rgba(30, 64, 175, 0.15) 30%,
        rgba(147, 51, 234, 0.1) 60%,
        rgba(15, 23, 42, 0.75) 100%);
    z-index: 2;
    pointer-events: none;
}

/* Content needs higher z-index */
.content-wrapper {
    position: relative;
    z-index: 10;
}

body {
    background: #0f172a;
    color: white;
}

.hero-section {
    min-height: 90vh;
    display: flex;
    align-items: center;
    padding: 2rem 1rem;
}

.hero-card {
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    padding: 3rem 2rem;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.gradient-title {
    background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #60a5fa 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer 3s linear infinite;
    font-size: 3rem;
    font-weight: bold;
    margin: 1rem 0;
}

@keyframes shimmer {
    to { background-position: 200% center; }
}

.solution-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.solution-item {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: white;
}

.solution-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    border-color: #60a5fa;
    background: rgba(15, 23, 42, 0.9);
}

.stats-section {
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(20px);
    color: white;
    padding: 3rem 1rem;
    text-align: center;
    margin: 2rem 0;
}

.contact-section {
    padding: 3rem 1rem;
}

.contact-form {
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 2rem;
    max-width: 600px;
    margin: 0 auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.form-group {
    margin-bottom: 1rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    font-size: 1rem;
    background: rgba(15, 23, 42, 0.8);
    color: white;
}

.form-input:focus {
    outline: none;
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
}

.form-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
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
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
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

/* Custom scrollbar for Services dropdown - dark theme */
.group .absolute::-webkit-scrollbar {
    width: 8px;
}

.group .absolute::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.group .absolute::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
}

.group .absolute::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Hide default footer */
footer {
    display: none;
}

/* Custom footer for dark theme */
.custom-footer {
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px);
    color: white;
    padding: 3rem 1rem 2rem;
    margin-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
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
    color: white;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #60a5fa;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 2rem;
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
}
CSS;

// Add JavaScript for postcode autocomplete
$extra_scripts = '<script src="/js/postcode_autocomplete.js" defer></script>';

$content = '';

if (isset($_GET['success'])) {
    $content .= '<div style="position: fixed; top: 80px; right: 20px; background: #10b981; color: white; padding: 1rem 1.5rem; border-radius: 8px; z-index: 1000; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);">
        ✅ Thank you! Our premium consultation team will contact you within 24 hours.
    </div>';
}

$content .= <<<HTML
    <!-- Spiral Background -->
    <div class="spiral-background">
        <video class="spiral-video" autoplay loop muted playsinline>
            <source src="/images/spiral_1080p.mp4" type="video/mp4">
            <source src="/images/spiral_720p.mp4" type="video/mp4">
        </video>
    </div>

    <!-- Gradient Overlay -->
    <div class="gradient-overlay"></div>

    <!-- Main Content -->
    <div class="content-wrapper">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-card">
                <p style="color: #60a5fa; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Melbourne's Premium IT Consultancy</p>
                <h1 class="gradient-title">PREMIUM HOME<br>AUTOMATION</h1>
                <p style="font-size: 1.25rem; color: rgba(255, 255, 255, 0.8); margin-bottom: 1rem;">
                    Transform Your Melbourne Property Into an Intelligent Sanctuary
                </p>
                <p style="font-size: 1rem; color: rgba(255, 255, 255, 0.6); margin-bottom: 2rem;">
                    Tailored solutions for every budget and requirement
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="#contact" class="btn-primary" style="text-decoration: none; display: inline-block; min-width: 200px;">
                        Begin Your Journey
                    </a>
                    <a href="#solutions" style="border: 2px solid #60a5fa; color: #60a5fa; padding: 0.75rem 2rem; border-radius: 6px; text-decoration: none; display: inline-block; min-width: 200px; text-align: center; transition: all 0.3s ease;">
                        View Solutions
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Common Solutions -->
        <section id="solutions" style="padding: 3rem 1rem;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 3rem;">
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 1rem;">Common Problems We Solve</h2>
                    <p style="font-size: 1.25rem; color: rgba(255, 255, 255, 0.7);">Click to explore solutions for your specific needs</p>
                </div>
                
                <div class="solution-grid">
                    <a href="/integration_grid_test.php?category=garage" class="solution-item">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🚗</div>
                        <p style="font-weight: bold; margin-bottom: 0.5rem;">Garage &amp; Gates</p>
                        <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7);">Automatic doors, remote access</p>
                    </a>
                    <a href="/integration_grid_test.php?category=access" class="solution-item">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">👤</div>
                        <p style="font-weight: bold; margin-bottom: 0.5rem;">Facial Recognition</p>
                        <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7);">Keyless entry, visitor ID</p>
                    </a>
                    <a href="/integration_grid_test.php?category=vehicle" class="solution-item">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🚙</div>
                        <p style="font-weight: bold; margin-bottom: 0.5rem;">License Plates</p>
                        <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7);">Vehicle detection, access control</p>
                    </a>
                    <a href="/integration_grid_test.php?category=climate" class="solution-item">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🌡️</div>
                        <p style="font-weight: bold; margin-bottom: 0.5rem;">Climate Control</p>
                        <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7);">Multi-zone, scheduling</p>
                    </a>
                    <a href="/integration_grid_test.php?category=lighting" class="solution-item">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">💡</div>
                        <p style="font-weight: bold; margin-bottom: 0.5rem;">Smart Lighting</p>
                        <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7);">Scenes, motion sensing</p>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Premium Service Areas -->
        <section class="stats-section">
            <div style="max-width: 800px; margin: 0 auto;">
                <h3 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Trusted by Melbourne's Elite</h3>
                <p style="font-size: 1.25rem; opacity: 0.9; margin-bottom: 2rem;">Serving all of Melbourne and surrounding areas</p>
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.5rem; font-size: 1.125rem;">
                    <span>Melbourne CBD</span>
                    <span style="opacity: 0.5;">•</span>
                    <span>Eastern Suburbs</span>
                    <span style="opacity: 0.5;">•</span>
                    <span>Bayside</span>
                    <span style="opacity: 0.5;">•</span>
                    <span>Inner City</span>
                    <span style="opacity: 0.5;">•</span>
                    <span>All Areas</span>
                </div>
            </div>
        </section>
        
        <!-- Contact Form Section -->
        <section id="contact" class="contact-section">
            <div class="contact-form">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <p style="color: #60a5fa; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Private Consultation</p>
                    <h2 class="gradient-title" style="font-size: 2.5rem;">REQUEST AN INVITATION</h2>
                    <p style="font-size: 1.25rem; color: rgba(255, 255, 255, 0.8);">
                        Professional consultation for your unique automation needs
                    </p>
                </div>
                
                <form method="POST">
                    <input type="hidden" name="action" value="get_quote">
                    
                    <!-- Name Fields -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="text" name="first_name" required placeholder="First Name" class="form-input">
                        <input type="text" name="surname" required placeholder="Surname" class="form-input">
                    </div>
                    
                    <!-- Contact Info -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="email" name="email" required placeholder="Email Address" class="form-input">
                        <input type="tel" name="phone" required pattern="^0\d{9}$" maxlength="10" placeholder="Phone (0400 000 000)" class="form-input">
                    </div>
                    
                    <!-- Location -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="text" name="suburb" required placeholder="Your Suburb" class="form-input">
                        <input type="text" name="postcode" pattern="\d{4}" maxlength="4" required placeholder="Postcode" class="form-input">
                    </div>
                    
                    <!-- Project Type -->
                    <div class="form-group">
                        <select name="project_type" required class="form-input">
                            <option value="">Select Project Type</option>
                            <option value="updates">Updates to Existing Automation</option>
                            <option value="newsystem">Complete New System</option>
                            <option value="newbuild">New Home Build Design</option>
                        </select>
                    </div>
                    
                    <!-- Integrations -->
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; color: rgba(255,255,255,0.8);">Select Integration Areas (hold Ctrl/Cmd for multiple)</label>
                        <select name="integrations[]" multiple size="6" class="form-input" style="height: auto; padding: 0.5rem;">
                            <option value="Lighting">Lighting Control</option>
                            <option value="Curtains">Curtains & Blinds</option>
                            <option value="Climate">AC/Heating/Climate</option>
                            <option value="Access">Doors/Gates Access Control</option>
                            <option value="Security">Security/CCTV</option>
                            <option value="Entertainment">TV/Cinema/Audio</option>
                            <option value="Network">Network/WiFi</option>
                            <option value="Energy">Solar/Energy Management</option>
                        </select>
                    </div>
                    
                    <!-- Property Details -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <select name="property_type" required class="form-input">
                            <option value="">Property Type</option>
                            <option value="Apartment">Apartment/Unit</option>
                            <option value="House">House</option>
                            <option value="Townhouse">Townhouse</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="number" name="bedrooms" min="0" required placeholder="Bedrooms" class="form-input">
                        <input type="number" name="rooms" min="0" required placeholder="Other Rooms" class="form-input">
                    </div>
                    
                    <!-- Budget -->
                    <div class="form-group">
                        <select name="budget" required class="form-input">
                            <option value="">Project Budget Range</option>
                            <option value="Under $5,000">Under $5,000</option>
                            <option value="$5,000 - $15,000">$5,000 - $15,000</option>
                            <option value="$15,000 - $35,000">$15,000 - $35,000</option>
                            <option value="$35,000 - $75,000">$35,000 - $75,000</option>
                            <option value="$75,000+">$75,000+</option>
                            <option value="Prefer to discuss">Prefer to discuss with professional</option>
                        </select>
                    </div>
                    
                    <!-- Additional Details -->
                    <div class="form-group">
                        <textarea name="details" rows="3" placeholder="Additional details (optional) - existing equipment, specific needs, special requests..." class="form-input" style="resize: vertical;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary">Submit Application</button>
                </form>
                
                <div style="text-align: center; margin-top: 2rem;">
                    <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.5); text-transform: uppercase; letter-spacing: 0.1em;">Proudly Serving</p>
                    <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.7); margin-top: 0.5rem;">All Melbourne Metro & Regional Victoria</p>
                    <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.5); margin-top: 1rem;">Response within 24 hours for qualified inquiries</p>
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
                <p style="margin-top: 0.5rem; font-size: 0.875rem;">Serving all of Melbourne and regional Victoria with premium IT solutions</p>
            </div>
        </div>
        
    </div><!-- End content-wrapper -->
HTML;

// Check if renderLayout accepts scripts parameter
// If not, we'll add the script directly to content
if (!isset($extra_scripts)) {
    $content .= '<script src="/js/postcode_autocomplete.js" defer></script>';
}
renderLayout($page_title, $content, $extra_styles, $page_desc);
?>