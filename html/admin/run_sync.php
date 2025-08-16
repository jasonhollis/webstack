<?php
include 'admin_auth.php';

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Run the sync command
$command = "/opt/webstack/bin/sync_to_qnap.sh 2>&1";
$output = [];
$return_code = 0;

exec($command, $output, $return_code);

if ($return_code === 0) {
    // Parse output for statistics
    $output_text = implode("\n", $output);
    $message = 'Sync completed';
    
    // Extract statistics from output
    if (preg_match('/Statistics: (\d+) backup files.*Total size: (.+)/', $output_text, $matches)) {
        $message = "Synced {$matches[1]} backup files ({$matches[2]})";
    }
    
    echo json_encode([
        'success' => true,
        'message' => $message,
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