<?php
/**
 * KTP Digital Integration Configuration
 * Safely integrates with existing webstack
 */

define('AUTOMATION_ROOT', dirname(__DIR__));
define('WEBSTACK_ROOT', dirname(AUTOMATION_ROOT));

// Check if existing database config exists
$existing_db_config = WEBSTACK_ROOT . '/html/config/database.php';
if (file_exists($existing_db_config)) {
    // Use existing database configuration
    require_once $existing_db_config;
    
    // Create automation database connection using existing credentials
    if (defined('DB_HOST')) {
        define('AUTOMATION_DB_HOST', DB_HOST);
        define('AUTOMATION_DB_NAME', DB_NAME ?? 'ktp_digital');
        define('AUTOMATION_DB_USER', DB_USER ?? 'root');
        define('AUTOMATION_DB_PASS', DB_PASS ?? '');
    }
} else {
    // Fallback configuration for new installations
    define('AUTOMATION_DB_HOST', 'localhost');
    define('AUTOMATION_DB_NAME', 'ktp_digital');
    define('AUTOMATION_DB_USER', 'ktp_user');
    define('AUTOMATION_DB_PASS', 'ktp_secure_2025!');
}

// Redis configuration
define('AUTOMATION_REDIS_HOST', '127.0.0.1');
define('AUTOMATION_REDIS_PORT', 6379);

// Automation settings
define('AUTOMATION_MAX_WORKERS', 8);
define('AUTOMATION_JOB_TIMEOUT', 300);
define('AUTOMATION_LOG_LEVEL', 'INFO');

// Integration flags
define('PRESERVE_EXISTING_ROUTES', true);
define('AUTOMATION_URL_PREFIX', '/automation');
define('CLIENT_PORTAL_PREFIX', '/portal');
