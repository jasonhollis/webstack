<?php
/**
 * KTP Digital Automation API
 * Integrated with existing webstack
 */

// Set content type
header('Content-Type: application/json');
header('X-Powered-By: KTP Digital Automation');

// Enable CORS for client portal
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Include the job queue manager
require_once '../lib/JobQueueManager.php';

try {
    $queue = new JobQueueManager();
    $method = $_SERVER['REQUEST_METHOD'];
    $path = trim($_SERVER['PATH_INFO'] ?? '', '/');
    
    switch ("$method:$path") {
        case 'GET:status':
        case 'GET:':
            $clientId = $_GET['client_id'] ?? null;
            echo json_encode($queue->getStatus($clientId));
            break;
            
        case 'POST:jobs':
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['client_id'], $input['job_type'])) {
                http_response_code(400);
                echo json_encode(['error' => 'client_id and job_type required']);
                break;
            }
            
            $result = $queue->queueJob(
                $input['client_id'],
                $input['job_type'],
                $input['parameters'] ?? [],
                $input['priority'] ?? 5
            );
            
            echo json_encode($result);
            break;
            
        case 'GET:health':
            echo json_encode([
                'status' => 'healthy',
                'timestamp' => time(),
                'server' => gethostname(),
                'php_version' => PHP_VERSION,
                'memory_usage' => memory_get_usage(true),
                'integration' => 'webstack'
            ]);
            break;
            
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
    }
    
} catch (Exception $e) {
    error_log("KTP Automation API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal server error',
        'message' => 'Check logs for details'
    ]);
}
