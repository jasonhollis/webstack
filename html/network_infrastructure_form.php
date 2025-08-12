<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/layout.php';
require '/opt/webstack/vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

$internal_notification_address = "leads@ktp.digital";
$logfile = "/opt/webstack/logs/leads.log";

// --- Network Infrastructure Form Options ---
$project_types = [
    'new_build' => 'New Office/Building Network Design',
    'upgrade' => 'Network Upgrade/Modernization',
    'wifi_coverage' => 'WiFi Coverage Improvement',
    'security' => 'Network Security Enhancement',
    'redundancy' => 'High Availability/Redundancy Setup',
    'performance' => 'Performance Optimization',
    'merger' => 'Office Merger/Integration'
];

$network_sizes = [
    'Under 10 devices',
    '10-50 devices',
    '51-200 devices',
    '201-500 devices',
    '500+ devices'
];

$current_equipment = [
    'UniFi',
    'Cisco',
    'Meraki',
    'Fortinet',
    'SonicWall',
    'Netgear',
    'TP-Link',
    'Other Enterprise',
    'Consumer Grade',
    'None/New Installation'
];

$priority_features = [
    'Reliability/Uptime',
    'Speed/Performance',
    'Security',
    'Remote Management',
    'Guest Network',
    'VLAN Segmentation',
    'VPN Access',
    'Cloud Integration'
];

$budget_ranges = [
    'Under $5,000',
    '$5,000 - $15,000',
    '$15,000 - $35,000',
    '$35,000 - $75,000',
    '$75,000 - $150,000',
    '$150,000+',
    'Prefer to discuss with a professional'
];

// --- Process Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok = true;
    $error_fields = [];

    // Company name
    $company_name = trim($_POST['company_name'] ?? '');
    if ($company_name === '') { $ok = false; $error_fields[] = "Company Name"; }

    // Contact person
    $contact_name = trim($_POST['contact_name'] ?? '');
    if ($contact_name === '') { $ok = false; $error_fields[] = "Contact Name"; }

    // Suburb
    $suburb = trim($_POST['suburb'] ?? '');
    if ($suburb === '') { $ok = false; $error_fields[] = "Suburb"; }

    // Phone validation
    $phone = trim($_POST['phone'] ?? '');
    if (!preg_match('/^0\d{9}$/', $phone)) {
        $ok = false; $error_fields[] = "Valid 10-digit Australian phone";
    }

    // Email validation
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $ok = false; $error_fields[] = "Valid Email";
    }

    // Project Type
    $project_type = $_POST['project_type'] ?? '';
    if ($project_type === '' || !isset($project_types[$project_type])) { 
        $ok = false; $error_fields[] = "Project Type"; 
    }
    $project_label = $project_types[$project_type] ?? '';

    // Network size
    $network_size = $_POST['network_size'] ?? '';
    if ($network_size === '' || !in_array($network_size, $network_sizes)) { 
        $ok = false; $error_fields[] = "Network Size"; 
    }

    // Current equipment (optional but helpful)
    $equipment = $_POST['equipment'] ?? [];
    $equipment_str = is_array($equipment) ? implode(', ', array_map('htmlspecialchars', $equipment)) : '';

    // Priority features (multi-select)
    $priorities = $_POST['priorities'] ?? [];
    if (!is_array($priorities) || count(array_filter($priorities)) == 0) { 
        $ok = false; $error_fields[] = "Priority Features"; 
    }
    $priorities_str = is_array($priorities) ? implode(', ', array_map('htmlspecialchars', $priorities)) : '';

    // Budget
    $budget = $_POST['budget'] ?? '';
    if ($budget === '' || !in_array($budget, $budget_ranges)) { 
        $ok = false; $error_fields[] = "Budget"; 
    }

    // Timeline
    $timeline = trim($_POST['timeline'] ?? '');
    if ($timeline === '') { $ok = false; $error_fields[] = "Timeline"; }

    // Additional requirements (optional)
    $requirements = trim($_POST['requirements'] ?? '');

    if (!$ok) {
        $error = "Please complete all required fields: " . implode(", ", $error_fields) . ".";
    } else {
        $timestamp = date('c');
        $log_entry = "[$timestamp] [Network Infrastructure Lead]\n";
        $data = [
            'Company Name'      => $company_name,
            'Contact Name'      => $contact_name,
            'Suburb'           => $suburb,
            'Phone'            => $phone,
            'Email'            => $email,
            'Project Type'     => $project_label,
            'Network Size'     => $network_size,
            'Current Equipment'=> $equipment_str ?: 'Not specified',
            'Priority Features'=> $priorities_str,
            'Budget'           => $budget,
            'Timeline'         => $timeline,
        ];
        if ($requirements !== '') {
            $data['Additional Requirements'] = $requirements;
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
            
            // Premium business areas
            $premium_suburbs = ['Melbourne', 'Docklands', 'Southbank', 'Richmond', 'Hawthorn', 'Camberwell'];
            foreach ($premium_suburbs as $premium) {
                if (stripos($suburb, $premium) !== false) {
                    $lead_score += 15;
                    break;
                }
            }
            
            // Score based on network size
            if ($network_size === '500+ devices') $lead_score += 25;
            elseif ($network_size === '201-500 devices') $lead_score += 20;
            elseif ($network_size === '51-200 devices') $lead_score += 15;
            elseif ($network_size === '10-50 devices') $lead_score += 10;
            elseif ($network_size === 'Under 10 devices') $lead_score += 5;
            
            // Score based on project type
            if (in_array($project_type, ['new_build', 'merger', 'redundancy'])) {
                $lead_score += 10; // Complex projects
            }
            
            // Score based on priorities count (more complex = higher value)
            $lead_score += count($priorities) * 3;
            
            // Score based on budget
            if ($budget === '$150,000+') $lead_score += 25;
            elseif ($budget === '$75,000 - $150,000') $lead_score += 20;
            elseif ($budget === '$35,000 - $75,000') $lead_score += 15;
            elseif ($budget === '$15,000 - $35,000') $lead_score += 10;
            elseif ($budget === '$5,000 - $15,000') $lead_score += 5;
            elseif ($budget === 'Prefer to discuss with a professional') $lead_score += 12;
            
            // Calculate estimated value
            $budget_map = [
                'Under $5,000' => 3500,
                '$5,000 - $15,000' => 10000,
                '$15,000 - $35,000' => 25000,
                '$35,000 - $75,000' => 55000,
                '$75,000 - $150,000' => 112500,
                '$150,000+' => 200000,
                'Prefer to discuss with a professional' => 35000
            ];
            $estimated_value = $budget_map[$budget] ?? 0;
            
            // Build message field
            $message = "Company: {$company_name}\n";
            $message .= "Project: {$project_label}\n";
            $message .= "Network Size: {$network_size}\n";
            $message .= "Priorities: {$priorities_str}\n";
            $message .= "Timeline: {$timeline}\n";
            if ($equipment_str) {
                $message .= "Current Equipment: {$equipment_str}\n";
            }
            if ($requirements !== '') {
                $message .= "Requirements: {$requirements}\n";
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
                $contact_name . ' (' . $company_name . ')',
                $email,
                $phone,
                $message,
                $project_type,
                $suburb,
                $budget,
                $estimated_value,
                $lead_score,
                'network_infrastructure_form',
                $ip_address,
                $user_agent,
                $utm_source,
                $utm_medium,
                $utm_campaign
            ]);
            
        } catch (PDOException $e) {
            error_log("Database error in network_infrastructure_form.php: " . $e->getMessage());
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

            $mail->setFrom('info@ktp.digital', 'KTP Digital Network Form');
            $mail->addAddress($internal_notification_address);
            $mail->addReplyTo($email, $contact_name);

            $mail->Subject = "[Network Infrastructure] New Lead – $project_label [$company_name]";
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
  <h1 class="font-bold text-3xl sm:text-4xl mb-1">Enterprise Network Infrastructure</h1>
  <p class="text-gray-600 mb-4">Professional network design and implementation for Melbourne businesses. UniFi, Cisco, and enterprise-grade solutions.</p>
  
  <?php if (!empty($thanks)): ?>
    <div class="text-blue-700 font-bold mb-6 text-lg">Thank you! Our network specialist will contact you within one business day.</div>
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
      
      <label class="block font-semibold mt-2 mb-1">Company Name<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="company_name" required 
             value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>">

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

      <label class="block font-semibold mt-2 mb-1">Project Type<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="project_type" required>
        <option value="">Select project type</option>
        <?php foreach ($project_types as $key => $label): ?>
          <option value="<?php echo $key; ?>" 
                  <?php if(($_POST['project_type'] ?? '') == $key) echo 'selected'; ?>>
            <?php echo $label; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Network Size<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="network_size" required>
        <option value="">Select network size</option>
        <?php foreach ($network_sizes as $size): ?>
          <option value="<?php echo htmlspecialchars($size); ?>" 
                  <?php if(($_POST['network_size'] ?? '') == $size) echo 'selected'; ?>>
            <?php echo htmlspecialchars($size); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Current Equipment (optional)</label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="equipment[]" multiple size="6">
        <?php foreach ($current_equipment as $equip): ?>
          <option value="<?php echo htmlspecialchars($equip); ?>" 
                  <?php echo (isset($_POST['equipment']) && in_array($equip, $_POST['equipment'])) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($equip); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <small class="block text-gray-500 mb-2">Hold Command (Mac) or Ctrl (Windows) to select multiple</small>

      <label class="block font-semibold mt-2 mb-1">Priority Features<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="priorities[]" multiple required size="6">
        <?php foreach ($priority_features as $feature): ?>
          <option value="<?php echo htmlspecialchars($feature); ?>" 
                  <?php echo (isset($_POST['priorities']) && in_array($feature, $_POST['priorities'])) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($feature); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <small class="block text-gray-500 mb-2">Hold Command (Mac) or Ctrl (Windows) to select multiple</small>

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

      <label class="block font-semibold mt-2 mb-1">Project Timeline<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="timeline" required 
             placeholder="e.g., Q1 2025, ASAP, Within 3 months"
             value="<?php echo htmlspecialchars($_POST['timeline'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Additional Requirements (optional)</label>
      <textarea class="w-full px-3 py-2 border rounded" name="requirements" rows="3"
          placeholder="Special requirements, compliance needs, integration requirements, etc."><?php
          echo htmlspecialchars($_POST['requirements'] ?? ''); ?></textarea>

      <button type="submit"
        class="mt-4 w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
        Get Network Proposal
      </button>
    </form>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();

renderLayout(
    'Enterprise Network Infrastructure',
    $content,
    '',
    'Professional network infrastructure design and implementation for Melbourne businesses - UniFi, Cisco, enterprise solutions by KTP Digital.',
    '/network_infrastructure_form.php'
);