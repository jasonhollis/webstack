<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/layout.php';
require '/opt/webstack/vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

// For quick postcode → state lookup (safe for all PHP versions)
function au_state_from_postcode($postcode) {
    $ranges = [
        'NSW' => [[1000, 1999], [2000, 2599], [2619, 2899], [2921, 2999]],
        'ACT' => [[200, 299], [2600, 2618], [2900, 2920]],
        'VIC' => [[3000, 3999], [8000, 8999]],
        'QLD' => [[4000, 4999], [9000, 9999]],
        'SA'  => [[5000, 5799], [5800, 5999]],
        'WA'  => [[6000, 6797], [6800, 6999]],
        'TAS' => [[7000, 7799], [7800, 7999]],
        'NT'  => [[800, 899], [900, 999]],
    ];
    foreach ($ranges as $state => $blocks) {
        foreach ($blocks as $block) {
            $start = $block[0];
            $end = $block[1];
            if ($postcode >= $start && $postcode <= $end) return $state;
        }
    }
    return '';
}

$internal_notification_address = "leads@ktp.digital";
$logfile = "/opt/webstack/logs/leads.log";

// --- Main Form Options ---
$project_types = [
    'updates'    => 'Updates and Changes to an Existing Automation Environment',
    'newsystem'  => 'Complete New System for an Existing Home',
    'newbuild'   => 'New Home Build – System Design'
];

$integrations = [
    'Lighting',
    'Curtains or Blinds',
    'AC/Heating',
    'Doors/Gates – Access Control',
    'Network/WIFI',
    'Security/CCTV',
    'Irrigation',
    'Pool Equipment',
    'TV/Home Cinema/Audio Entertainment',
    'Appliance Controls',
    'Solar/Energy Management',
    'Something else'
];

$property_types = [
    'Apartment/Unit',
    'Standalone House',
    'Townhouse',
    'Other'
];

$budget_options = [
    '$1,000-$2,000',
    '$2,000-$5,000',
    '$5,000-$10,000',
    '$10,000-$25,000',
    '$25,000+'
];

// --- Process Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok = true;
    $error_fields = [];

    // First name / Surname
    $first_name = trim($_POST['first_name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    if ($first_name === '') { $ok = false; $error_fields[] = "First Name"; }
    if ($surname === '') { $ok = false; $error_fields[] = "Surname"; }
    $customer_name = "$first_name $surname";

    // Suburb & Postcode
    $suburb = trim($_POST['suburb'] ?? '');
    $postcode = trim($_POST['postcode'] ?? '');
    if ($suburb === '') { $ok = false; $error_fields[] = "Suburb"; }
    if (!preg_match('/^\d{4}$/', $postcode) || au_state_from_postcode((int)$postcode) === '') {
        $ok = false; $error_fields[] = "Valid Australian Postcode";
    }
    $state = au_state_from_postcode((int)$postcode);

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

    // Project Type
    $proj_type = $_POST['project_type'] ?? '';
    if ($proj_type === '' || !isset($project_types[$proj_type])) { $ok = false; $error_fields[] = "Project Type"; }
    $proj_label = $project_types[$proj_type] ?? '';

    // Integrations (multi-select)
    $sel_integrations = $_POST['integrations'] ?? [];
    if (!is_array($sel_integrations) || count(array_filter($sel_integrations)) == 0) { $ok = false; $error_fields[] = "Integration(s) Required"; }
    $integrations_str = is_array($sel_integrations) ? implode(', ', array_map('htmlspecialchars', $sel_integrations)) : '';

    // Property type
    $property_type = $_POST['property_type'] ?? '';
    if ($property_type === '' || !in_array($property_type, $property_types)) { $ok = false; $error_fields[] = "Type of Property"; }

    // Bedrooms/Other rooms
    $bedrooms = trim($_POST['bedrooms'] ?? '');
    $rooms    = trim($_POST['rooms'] ?? '');
    if ($bedrooms === '' || $rooms === '') { $ok = false; $error_fields[] = "Bedroom and Room Counts"; }

    // Budget
    $budget = $_POST['budget'] ?? '';
    if ($budget === '' || !in_array($budget, $budget_options)) { $ok = false; $error_fields[] = "Budget"; }

    // Additional details (optional)
    $details = trim($_POST['details'] ?? '');

    if (!$ok) {
        $error = "All fields are required except Additional details. Please check: " . implode(", ", $error_fields) . ".";
    } else {
        $timestamp = date('c');
        $log_entry = "[$timestamp] [Home Automation Lead]\n";
        $data = [
            'Customer Name' => $customer_name,
            'Suburb'        => $suburb,
            'Postcode'      => $postcode,
            'State'         => $state,
            'Phone'         => $phone,
            'Email'         => $email,
            'Project type'  => $proj_label,
            'Integrations required' => $integrations_str,
            'Type of property' => $property_type,
            'Number of bedrooms' => $bedrooms,
            'Number of other rooms' => $rooms,
            'Budget' => $budget,
        ];
        if ($details !== '') {
            $data['Additional details'] = $details;
        }
        foreach ($data as $label => $value) {
            $log_entry .= "$label: $value\n";
        }
        $log_entry .= str_repeat('-', 40) . "\n";
        file_put_contents($logfile, $log_entry, FILE_APPEND);

        // Email body: ensure pure ASCII, no smart quotes or euro sign
        $email_body = '';
        foreach ($data as $label => $value) {
            $safe_value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
            $email_body .= "$label:\n$safe_value\n\n";
        }

        // --- PHPMailer for Mailgun SMTP ---
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

            $mail->setFrom('info@ktp.digital', 'KTP Digital Lead Form');
            $mail->addAddress($internal_notification_address);
            $mail->addReplyTo($email, $customer_name);

            $mail->Subject = "New Lead – $proj_label [$customer_name]";
            $mail->Body    = $email_body;

            $mail->send();
            $mail_success = true;
        } catch (Exception $e) {
            $error = "Sorry, we couldn’t send your enquiry at this time. Please try again later or email us directly.";
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
  <h1 class="font-bold text-3xl sm:text-4xl mb-1">Request a Quote or Callback</h1>
  <?php if (!empty($thanks)): ?>
    <div class="text-blue-700 font-bold mb-6 text-lg">Thank you, your enquiry has been submitted. We’ll get back to you soon!</div>
  <?php else: ?>
    <?php if (!empty($error)): ?>
      <div class="text-red-700 font-semibold mb-3"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" autocomplete="off" novalidate>
      <label class="block font-semibold mt-2 mb-1">First Name<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="first_name" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Surname<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="surname" required value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Suburb<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="suburb" required value="<?php echo htmlspecialchars($_POST['suburb'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Postcode<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="text" name="postcode" required maxlength="4" pattern="\d{4}" value="<?php echo htmlspecialchars($_POST['postcode'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Phone<span class="text-red-700">*</span> <span class="text-gray-500 text-sm">(10 digits, start with 0)</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="tel" name="phone" required pattern="^0\d{9}$" maxlength="10" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Email<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">Type of Project<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="project_type" required>
        <option value="">Select a project type</option>
        <?php foreach ($project_types as $key=>$proj): ?>
            <option value="<?php echo $key; ?>" <?php if(($_POST['project_type']??'')==$key) echo 'selected'; ?>>
                <?php echo $proj; ?>
            </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Please select the integration(s) required<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="integrations[]" multiple required size="8">
        <?php foreach ($integrations as $opt): ?>
            <option value="<?php echo htmlspecialchars($opt); ?>" <?php echo (isset($_POST['integrations']) && in_array($opt, $_POST['integrations'])) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($opt); ?>
            </option>
        <?php endforeach; ?>
      </select>
      <small class="block text-gray-500 mb-2">Hold Command (Mac) or Ctrl (Windows) to select multiple</small>

      <label class="block font-semibold mt-2 mb-1">Type of property<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded mb-2" name="property_type" required>
        <option value="">Select one</option>
        <?php foreach ($property_types as $ptype): ?>
            <option value="<?php echo htmlspecialchars($ptype); ?>" <?php if(($_POST['property_type']??'')==$ptype) echo 'selected'; ?>>
                <?php echo htmlspecialchars($ptype); ?>
            </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">How many bedrooms are there in the property?<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="number" name="bedrooms" required min="0" value="<?php echo htmlspecialchars($_POST['bedrooms'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">How many other rooms are there in the property?<span class="text-red-700">*</span></label>
      <input class="w-full px-3 py-2 border rounded mb-2" type="number" name="rooms" required min="0" value="<?php echo htmlspecialchars($_POST['rooms'] ?? ''); ?>">

      <label class="block font-semibold mt-2 mb-1">What budget do you have in mind for this service?<span class="text-red-700">*</span></label>
      <select class="w-full px-3 py-2 border rounded" name="budget" required>
        <option value="">Select a budget range</option>
        <?php foreach ($budget_options as $budget_option): ?>
            <option value="<?php echo htmlspecialchars($budget_option); ?>" <?php if(($_POST['budget']??'')==$budget_option) echo 'selected'; ?>>
                <?php echo htmlspecialchars($budget_option); ?>
            </option>
        <?php endforeach; ?>
      </select>

      <label class="block font-semibold mt-2 mb-1">Additional details (optional)</label>
      <textarea class="w-full px-3 py-2 border rounded" name="details" rows="2"
          placeholder="E.g. Types of existing equipment, specific integration needs, special requests, or something not covered above."><?php
          echo htmlspecialchars($_POST['details'] ?? ''); ?></textarea>

      <button type="submit"
  		class="mt-4 w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
  		Send Enquiry
	  </button>
    </form>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();

renderLayout(
    'Request a Quote or Callback',
    $content,
    '',
    'Request a quote or callback for home automation, networking, and digital services by KTP Digital.',
    '/lead_form.php'
);
