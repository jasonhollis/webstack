<?php
include 'admin_auth.php';

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get backup type
$type = $_POST['type'] ?? 'manual';

// Validate type
if (!in_array($type, ['manual', 'hourly', 'daily', 'weekly', 'monthly'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid backup type']);
    exit;
}

// Run the backup command
$command = "/usr/bin/python3 /opt/webstack/bin/backup_database.py backup --type " . escapeshellarg($type) . " 2>&1";
$output = [];
$return_code = 0;

exec($command, $output, $return_code);

if ($return_code === 0) {
    // Parse output to get backup file
    $output_text = implode("\n", $output);
    $file = null;
    
    if (preg_match('/Backup created: (.+)/', $output_text, $matches)) {
        $file = basename($matches[1]);
    }
    
    echo json_encode([
        'success' => true,
        'file' => $file ?: 'backup completed',
        'output' => $output_text
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => implode("\n", $output),
        'return_code' => $return_code
    ]);
}
?>