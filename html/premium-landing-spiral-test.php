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
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'premium_landing_test', ?, ?)");
        
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
            $email_body = "New Lead from Premium Landing Page\n\n";
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

// Add JavaScript for postcode autocomplete
$extra_scripts = '<script src="/js/postcode_autocomplete.js" defer></script>';

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
                <a href="/integrations.php?category=garage" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚗</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Garage &amp; Gates</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Automatic doors, remote access</p>
                </a>
                <a href="/integrations.php?category=security" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔔</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Security & Doorbells</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Ring, cameras, alarms</p>
                </a>
                <a href="/integrations.php?category=vehicle" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚙</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">License Plates</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Vehicle detection, access control</p>
                </a>
                <a href="/integrations.php?category=climate" class="solution-item">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌡️</div>
                    <p style="font-weight: bold; margin-bottom: 0.5rem;">Climate Control</p>
                    <p style="font-size: 0.875rem; color: #6b7280;">Multi-zone, scheduling</p>
                </a>
                <a href="/integrations.php?category=lighting" class="solution-item">
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
                <p style="color: #3b82f6; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Private Consultation</p>
                <h2 class="gradient-title" style="font-size: 2.5rem;">SCHEDULE YOUR CONSULTATION</h2>
                <p style="font-size: 1.25rem; color: #4b5563;">
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
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; color: #6b7280;">Select Integration Areas (hold Ctrl/Cmd for multiple)</label>
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
                <p style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.1em;">Proudly Serving</p>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">All Melbourne Metro & Regional Victoria</p>
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
                    <li><a href="/integrations.php?category=security">Security & Doorbells</a></li>
                    <li><a href="/integrations.php?category=garage">Garage & Gates</a></li>
                    <li><a href="/integrations.php?category=climate">Climate Control</a></li>
                    <li><a href="/integrations.php?category=lighting">Smart Lighting</a></li>
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
HTML;

// Check if renderLayout accepts scripts parameter
// If not, we'll add the script directly to content
if (!isset($extra_scripts)) {
    $content .= '<script src="/js/postcode_autocomplete.js" defer></script>';
}
renderLayout($page_title, $content, $extra_styles, $page_desc);
?>