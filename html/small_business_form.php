<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/layout.php';
require '/opt/webstack/vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

$internal_notification_address = "leads@ktp.digital";
$logfile = "/opt/webstack/logs/leads.log";

// --- Small Business Form Options ---
$service_types = [
    'mac_support' => 'Mac Support & Management',
    'it_infrastructure' => 'IT Infrastructure Setup',
    'cloud_migration' => 'Cloud Migration Services',
    'cybersecurity' => 'Cybersecurity & Compliance',
    'managed_services' => 'Ongoing Managed IT Services',
    'consulting' => 'IT Strategy Consulting'
];

$business_sizes = [
    '1-5 employees',
    '6-20 employees',
    '21-50 employees',
    '51-100 employees',
    '100+ employees'
];

$urgency_levels = [
    'immediate' => 'Immediate (System Down)',
    'week' => 'Within a Week',
    'month' => 'Within a Month',
    'planning' => 'Planning/Research Phase'
];

$budget_ranges = [
    'Under $2,000',
    '$2,000 - $5,000',
    '$5,000 - $10,000',
    '$10,000 - $25,000',
    '$25,000+',
    'Prefer to discuss with a professional'
];

// --- Process Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok = true;
    $error_fields = [];

    // Business name
    $business_name = trim($_POST['business_name'] ?? '');
    if ($business_name === '') { $ok = false; $error_fields[] = "Business Name"; }

    // Contact person
    $contact_name = trim($_POST['contact_name'] ?? '');
    if ($contact_name === '') { $ok = false; $error_fields[] = "Contact Name"; }

    // Suburb
    $suburb = trim($_POST['suburb'] ?? '');
    if ($suburb === '') { $ok = false; $error_fields[] = "Suburb"; }

    // Phone validation: 10 digits, starts with 0
    $phone = trim($_POST['phone'] ?? '');
    if (!preg_match('/^0\d{9}$/', $phone)) {
        $ok = false; $error_fields[] = "Valid 10-digit Australian phone";
    }

    // Email validation
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $ok = false; $error_fields[] = "Valid Email";
    }

    // Service Type
    $service_type = $_POST['service_type'] ?? '';
    if ($service_type === '' || !isset($service_types[$service_type])) { 
        $ok = false; $error_fields[] = "Service Type"; 
    }
    $service_label = $service_types[$service_type] ?? '';

    // Business size
    $business_size = $_POST['business_size'] ?? '';
    if ($business_size === '' || !in_array($business_size, $business_sizes)) { 
        $ok = false; $error_fields[] = "Business Size"; 
    }

    // Urgency
    $urgency = $_POST['urgency'] ?? '';
    if ($urgency === '' || !isset($urgency_levels[$urgency])) { 
        $ok = false; $error_fields[] = "Urgency"; 
    }
    $urgency_label = $urgency_levels[$urgency] ?? '';

    // Budget
    $budget = $_POST['budget'] ?? '';
    if ($budget === '' || !in_array($budget, $budget_ranges)) { 
        $ok = false; $error_fields[] = "Budget"; 
    }

    // Current challenges (optional but helpful)
    $challenges = trim($_POST['challenges'] ?? '');

    if (!$ok) {
        $error = "Please complete all required fields: " . implode(", ", $error_fields) . ".";
    } else {
        $timestamp = date('c');
        $log_entry = "[$timestamp] [Small Business Lead]\n";
        $data = [
            'Business Name' => $business_name,
            'Contact Name'  => $contact_name,
            'Suburb'        => $suburb,
            'Phone'         => $phone,
            'Email'         => $email,
            'Service Type'  => $service_label,
            'Business Size' => $business_size,
            'Urgency'       => $urgency_label,
            'Budget'        => $budget,
        ];
        if ($challenges !== '') {
            $data['Current Challenges'] = $challenges;
        }
        foreach ($data as $label => $value) {
            $log_entry .= "$label: $value\n";
        }
        $log_entry .= str_repeat('-', 40) . "\n";
        file_put_contents($logfile, $log_entry, FILE_APPEND);

        // Save to database
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            
            // Calculate lead score
            $lead_score = 0;
            
            // Premium suburbs get bonus
            $premium_suburbs = ['Melbourne', 'South Yarra', 'Prahran', 'Richmond', 'Hawthorn', 'Kew'];
            foreach ($premium_suburbs as $premium) {
                if (stripos($suburb, $premium) !== false) {
                    $lead_score += 15;
                    break;
                }
            }
            
            // Score based on business size
            if ($business_size === '100+ employees') $lead_score += 20;
            elseif ($business_size === '51-100 employees') $lead_score += 15;
            elseif ($business_size === '21-50 employees') $lead_score += 10;
            elseif ($business_size === '6-20 employees') $lead_score += 5;
            
            // Score based on urgency
            if ($urgency === 'immediate') $lead_score += 15;
            elseif ($urgency === 'week') $lead_score += 10;
            elseif ($urgency === 'month') $lead_score += 5;
            
            // Score based on budget
            if ($budget === '$25,000+') $lead_score += 20;
            elseif ($budget === '$10,000 - $25,000') $lead_score += 15;
            elseif ($budget === '$5,000 - $10,000') $lead_score += 10;
            elseif ($budget === '$2,000 - $5,000') $lead_score += 5;
            elseif ($budget === 'Prefer to discuss with a professional') $lead_score += 8;
            
            // Calculate estimated value
            $budget_map = [
                'Under $2,000' => 1500,
                '$2,000 - $5,000' => 3500,
                '$5,000 - $10,000' => 7500,
                '$10,000 - $25,000' => 17500,
                '$25,000+' => 35000,
                'Prefer to discuss with a professional' => 10000
            ];
            $estimated_value = $budget_map[$budget] ?? 0;
            
            // Build message field
            $message = "Business: {$business_name} ({$business_size})\n";
            $message .= "Service: {$service_label}\n";
            $message .= "Urgency: {$urgency_label}\n";
            if ($challenges !== '') {
                $message .= "Challenges: {$challenges}\n";
            }
            
            // Get IP and user agent
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            // Get UTM parameters
            $utm_source = $_GET['utm_source'] ?? $_POST['utm_source'] ?? '';
            $utm_medium = $_GET['utm_medium'] ?? $_POST['utm_medium'] ?? '';
            $utm_campaign = $_GET['utm_campaign'] ?? $_POST['utm_campaign'] ?? '';
            
            $stmt = $pdo->prepare("INSERT INTO premium_leads 
                (name, email, phone, message, project_type, suburb, budget_range, 
                 estimated_value, lead_score, source, ip_address, user_agent,
                 utm_source, utm_medium, utm_campaign, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())");
            
            $stmt->execute([
                $contact_name . ' (' . $business_name . ')',
                $email,
                $phone,
                $message,
                $service_type,
                $suburb,
                $budget,
                $estimated_value,
                $lead_score,
                'small_business_form',
                $ip_address,
                $user_agent,
                $utm_source,
                $utm_medium,
                $utm_campaign
            ]);
            
        } catch (PDOException $e) {
            error_log("Database error in small_business_form.php: " . $e->getMessage());
        }

        // Email notification
        $email_body = '';
        foreach ($data as $label => $value) {
            $safe_value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
            $email_body .= "$label:\n$safe_value\n\n";
        }

        // PHPMailer for Mailgun SMTP
        $mail_success = false;
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.mailgun.org';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'scanner@mailgun.ktp.digital';
            $mail->Password   = 'ScanMePlease888';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('info@ktp.digital', 'KTP Digital Business Form');
            $mail->addAddress($internal_notification_address);
            $mail->addReplyTo($email, $contact_name);

            $mail->Subject = "[Small Business] New Lead – $service_label [$business_name]";
            $mail->Body    = $email_body;

            $mail->send();
            $mail_success = true;
        } catch (Exception $e) {
            $error = "Sorry, we couldn't send your enquiry at this time. Please try again later.";
        }

        if ($mail_success) {
            $thanks = true;
        }
    }
}

// --- Start Output Buffer ---
ob_start();
?>
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg px-6 py-6 mt-6 mb-10">
  <h1 class="font-bold text-3xl sm:text-4xl mb-1">Small Business IT Solutions</h1>
  <p class="text-gray-600 mb-4">Premium Mac support and IT services for Melbourne businesses. Expert solutions tailored to your needs.</p>
  
  <?php if (!empty($thanks)): ?>
    <div class="text-blue-700 font-bold mb-6 text-lg">Thank you! We'll contact you within one business day.</div>
  <?php else: ?>
    <?php if (!empty($error)): ?>
      <div class="text-red-700 font-semibold mb-3"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="post" autocomplete="off" novalidate>
      <!-- Pass through UTM parameters -->
      <?php foreach (['utm_source', 'utm_medium', 'utm_campaign'] as $param): ?>
        <?php if (!empty($_GET[$param])): ?>
          <input type="hidden" name="<?php echo $param; ?>" value="<?php echo htmlspecialchars($_GET[$param]); ?>">
        <?php endif; ?>
      <?php endforeach; ?>
      
      <label class="block font-semibold mt-2 mb-1">Business Name<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="business_name" required 
             value="<?php echo htmlspecialchars($_POST['business_name'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Contact Name<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="contact_name" required 
             value="<?php echo htmlspecialchars($_POST['contact_name'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Suburb<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="suburb" required 
             value="<?php echo htmlspecialchars($_POST['suburb'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Phone<span class="text-red-700">*</span> 
        <span class="text-gray-500 text-sm">(10 digits, start with 0)</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="tel" name="phone" required 
             pattern="^0\d{9}$" maxlength="10" 
             value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Email<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="email" name="email" required 
             value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Service Required<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="service_type" required>
        <option value="">Select a service</option>
        <?php foreach ($service_types as $key => $label): ?>
          <option value="<?php echo $key; ?>" 
                  <?php if(($_POST['service_type'] ?? '') == $key) echo 'selected'; ?>>
            <?php echo $label; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Business Size<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="business_size" required>
        <option value="">Select size</option>
        <?php foreach ($business_sizes as $size): ?>
          <option value="<?php echo htmlspecialchars($size); ?>" 
                  <?php if(($_POST['business_size'] ?? '') == $size) echo 'selected'; ?>>
            <?php echo htmlspecialchars($size); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Urgency<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="urgency" required>
        <option value="">Select urgency</option>
        <?php foreach ($urgency_levels as $key => $label): ?>
          <option value="<?php echo $key; ?>" 
                  <?php if(($_POST['urgency'] ?? '') == $key) echo 'selected'; ?>>
            <?php echo $label; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Budget Range<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="budget" required>
        <option value="">Select budget range</option>
        <?php foreach ($budget_ranges as $range): ?>
          <option value="<?php echo htmlspecialchars($range); ?>" 
                  <?php if(($_POST['budget'] ?? '') == $range) echo 'selected'; ?>>
            <?php echo htmlspecialchars($range); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Current IT Challenges (optional)</label>
      <textarea class="w-full px-3 py-2 border rounded" name="challenges" rows="3"
          placeholder="Describe any specific IT challenges or requirements your business is facing"><?php
          echo htmlspecialchars($_POST['challenges'] ?? ''); ?></textarea>

      <button type="submit"
        class="mt-4 w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
        Get Expert Help
      </button>
    </form>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();

renderLayout(
    'Small Business IT Solutions',
    $content,
    '',
    'Mac support and premium IT services for Melbourne small businesses - Expert solutions from KTP Digital.',
    '/small_business_form.php'
);