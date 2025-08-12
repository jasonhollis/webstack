<?php
// analytics_logger.php — Database + JSON analytics logger for KTP Webstack

$log_path = "/opt/webstack/logs/web_analytics.log";
$ts = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$page = $_SERVER['REQUEST_URI'] ?? 'unknown';
$query_string = $_SERVER['QUERY_STRING'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$ref = $_SERVER['HTTP_REFERER'] ?? '-';
$status = http_response_code() ?: 200;
$load_time = microtime(true) - ($_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true));
$context = (strpos($page, '/admin/') !== false) ? 'ADMIN' : 'PUBLIC';

// Parse UTM parameters
$utm_source = $_GET['utm_source'] ?? null;
$utm_medium = $_GET['utm_medium'] ?? null;
$utm_campaign = $_GET['utm_campaign'] ?? null;

// Enhanced bot detection
if (!function_exists('detectBot')) {
function detectBot($user_agent) {
    $bot_patterns = [
        '/(bot|crawl|spider|scraper|curl|wget|python|zgrab|scanner)/i',
        '/(googlebot|bingbot|facebookexternalhit|twitterbot)/i',
        '/(gptbot|oai-searchbot|searchbot)/i',
        '/(facebot|slurp|duckduckgo|baidu|yandex)/i'
    ];
    
    foreach ($bot_patterns as $pattern) {
        if (preg_match($pattern, $user_agent)) {
            return true;
        }
    }
    return false;
}
} // end if !function_exists

// Device type detection
if (!function_exists('parseDeviceType')) {
function parseDeviceType($user_agent) {
    if (!$user_agent || $user_agent === 'unknown') return 'unknown';
    
    $ua_lower = strtolower($user_agent);
    
    if (detectBot($user_agent)) return 'bot';
    
    $mobile_indicators = ['mobile', 'android', 'iphone', 'ipad', 'ipod', 'windows phone'];
    foreach ($mobile_indicators as $indicator) {
        if (strpos($ua_lower, $indicator) !== false) {
            if (strpos($ua_lower, 'ipad') !== false || strpos($ua_lower, 'tablet') !== false) {
                return 'tablet';
            }
            return 'mobile';
        }
    }
    return 'desktop';
}
} // end if !function_exists

// Browser detection
if (!function_exists('parseBrowser')) {
function parseBrowser($user_agent) {
    if (!$user_agent || $user_agent === 'unknown') return null;
    
    $ua_lower = strtolower($user_agent);
    if (strpos($ua_lower, 'chrome/') !== false) return 'Chrome';
    if (strpos($ua_lower, 'firefox/') !== false) return 'Firefox';
    if (strpos($ua_lower, 'safari/') !== false && strpos($ua_lower, 'chrome') === false) return 'Safari';
    if (strpos($ua_lower, 'edge/') !== false) return 'Edge';
    if (strpos($ua_lower, 'bot') !== false) return 'Bot';
    
    return null;
}
} // end if !function_exists

// OS detection
if (!function_exists('parseOS')) {
function parseOS($user_agent) {
    if (!$user_agent || $user_agent === 'unknown') return null;
    
    $ua_lower = strtolower($user_agent);
    if (strpos($ua_lower, 'windows') !== false) return 'Windows';
    if (strpos($ua_lower, 'macintosh') !== false || strpos($ua_lower, 'mac os') !== false) return 'macOS';
    if (strpos($ua_lower, 'linux') !== false) return 'Linux';
    if (strpos($ua_lower, 'android') !== false) return 'Android';
    if (strpos($ua_lower, 'iphone') !== false || strpos($ua_lower, 'ipad') !== false) return 'iOS';
    
    return null;
}
} // end if !function_exists

$is_bot = detectBot($ua) ? 1 : 0;
$device_type = parseDeviceType($ua);
$browser = parseBrowser($ua);
$os = parseOS($ua);

// Parse query string from page URL
if (strpos($page, '?') !== false) {
    $page_parts = explode('?', $page, 2);
    $page = $page_parts[0];
    $query_string = $page_parts[1];
}

// Get session ID if available
$session_id = session_id() ?: null;

// Database logging
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ktp_digital', 'root', '');
    $stmt = $pdo->prepare("
        INSERT INTO web_analytics 
        (ip, page, query_string, user_agent, browser, os, device_type, referer, 
         status_code, load_time_ms, is_bot, session_id, utm_source, utm_medium, utm_campaign)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $ip, $page, $query_string, $ua, $browser, $os, $device_type, 
        ($ref === '-' ? null : $ref), $status,
        round($load_time * 1000), $is_bot, $session_id,
        $utm_source, $utm_medium, $utm_campaign
    ]);
} catch (Exception $e) {
    // Silently fail - don't break the page
    error_log("Analytics DB: " . $e->getMessage());
}

// Legacy JSON logging for backwards compatibility
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
