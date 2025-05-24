<?php
// analytics_logger.php — JSON-based analytics logger for KTP Webstack

$log_path = "/opt/webstack/logs/web_analytics.log";
$ts = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$page = $_SERVER['REQUEST_URI'] ?? 'unknown';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$ref = $_SERVER['HTTP_REFERER'] ?? '-';
$status = http_response_code();
$load_time = microtime(true) - ($_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true));
$context = (strpos($page, '/admin/') !== false) ? 'ADMIN' : 'PUBLIC';

$entry = [
    'ts' => $ts,
    'ip' => $ip,
    'page' => $page,
    'ua' => $ua,
    'referer' => $ref,
    'status' => $status,
    'load_time' => round($load_time, 4),
    'context' => $context
];

$line = json_encode($entry) . PHP_EOL;
file_put_contents($log_path, $line, FILE_APPEND | LOCK_EX);
?>
