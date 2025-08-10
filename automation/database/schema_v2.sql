-- KTP Digital Operations Database Schema v2
-- Comprehensive tracking for all system operations

-- =====================================================
-- VERSION CONTROL & DEPLOYMENTS
-- =====================================================
CREATE TABLE IF NOT EXISTS version_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(20) NOT NULL,
    previous_version VARCHAR(20),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    git_commit VARCHAR(40),
    git_tag VARCHAR(40),
    snapshot_path VARCHAR(255),
    snapshot_size_mb INT,
    snapshot_duration_ms INT,
    total_duration_ms INT,
    files_changed INT,
    lines_added INT,
    lines_removed INT,
    status ENUM('started', 'snapshot_complete', 'committed', 'tagged', 'pushed', 'failed', 'rolled_back') DEFAULT 'started',
    error_message TEXT,
    initiated_by VARCHAR(100) DEFAULT 'manual',
    INDEX idx_version (version),
    INDEX idx_timestamp (timestamp),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- =====================================================
-- OPERATION LOGS (Shell scripts, API calls, etc)
-- =====================================================
CREATE TABLE IF NOT EXISTS operation_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    operation_type ENUM('version_bump', 'snapshot', 'git_push', 'cleanup', 'backup', 'restore', 'api_call', 'cron_job', 'manual_script') NOT NULL,
    operation_name VARCHAR(100) NOT NULL,
    script_path VARCHAR(255),
    status ENUM('started', 'running', 'success', 'failed', 'timeout', 'cancelled') DEFAULT 'started',
    duration_ms INT,
    exit_code INT,
    stdout TEXT,
    stderr TEXT,
    details JSON,
    server_load DECIMAL(5,2),
    memory_used_mb INT,
    disk_used_gb DECIMAL(10,2),
    INDEX idx_timestamp (timestamp),
    INDEX idx_operation (operation_type, operation_name),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- =====================================================
-- WEB ANALYTICS (Replace file-based logging)
-- =====================================================
CREATE TABLE IF NOT EXISTS web_analytics (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip VARCHAR(45) NOT NULL,
    ip_country VARCHAR(2),
    ip_city VARCHAR(100),
    ip_region VARCHAR(100),
    ip_isp VARCHAR(200),
    page VARCHAR(255) NOT NULL,
    query_string TEXT,
    user_agent TEXT,
    browser VARCHAR(50),
    browser_version VARCHAR(20),
    os VARCHAR(50),
    device_type ENUM('desktop', 'mobile', 'tablet', 'bot', 'unknown') DEFAULT 'unknown',
    referer VARCHAR(500),
    utm_source VARCHAR(100),
    utm_medium VARCHAR(100),
    utm_campaign VARCHAR(100),
    utm_term VARCHAR(100),
    utm_content VARCHAR(100),
    status_code INT,
    load_time_ms INT,
    response_size_bytes INT,
    is_bot BOOLEAN DEFAULT FALSE,
    bot_name VARCHAR(100),
    session_id VARCHAR(64),
    user_id INT,
    context VARCHAR(50),
    INDEX idx_timestamp (timestamp),
    INDEX idx_page (page),
    INDEX idx_ip (ip),
    INDEX idx_session (session_id),
    INDEX idx_utm (utm_source, utm_medium, utm_campaign),
    INDEX idx_bot (is_bot)
) ENGINE=InnoDB;

-- =====================================================
-- LEAD TRACKING ENHANCEMENTS
-- =====================================================
ALTER TABLE premium_leads ADD COLUMN IF NOT EXISTS
    analytics_session_id VARCHAR(64),
ADD COLUMN IF NOT EXISTS
    first_page_visited VARCHAR(255),
ADD COLUMN IF NOT EXISTS
    pages_viewed_count INT DEFAULT 1,
ADD COLUMN IF NOT EXISTS
    time_on_site_seconds INT,
ADD COLUMN IF NOT EXISTS
    conversion_page VARCHAR(255),
ADD INDEX idx_session (analytics_session_id);

-- =====================================================
-- SYSTEM METRICS (Server health)
-- =====================================================
CREATE TABLE IF NOT EXISTS system_metrics (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    metric_type ENUM('cpu', 'memory', 'disk', 'network', 'process', 'service') NOT NULL,
    metric_name VARCHAR(100) NOT NULL,
    metric_value DECIMAL(20,4),
    metric_unit VARCHAR(20),
    details JSON,
    INDEX idx_timestamp (timestamp),
    INDEX idx_metric (metric_type, metric_name)
) ENGINE=InnoDB;

-- =====================================================
-- CLEANUP HISTORY
-- =====================================================
CREATE TABLE IF NOT EXISTS cleanup_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    cleanup_type ENUM('screenshots', 'logs', 'snapshots', 'temp_files', 'old_backups') NOT NULL,
    files_deleted INT DEFAULT 0,
    space_freed_mb DECIMAL(10,2) DEFAULT 0,
    oldest_file_date DATE,
    newest_file_date DATE,
    details JSON,
    INDEX idx_timestamp (timestamp),
    INDEX idx_type (cleanup_type)
) ENGINE=InnoDB;

-- =====================================================
-- GIT OPERATIONS TRACKING
-- =====================================================
CREATE TABLE IF NOT EXISTS git_operations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    operation ENUM('commit', 'push', 'pull', 'tag', 'merge', 'branch') NOT NULL,
    branch VARCHAR(50),
    remote VARCHAR(100),
    commit_hash VARCHAR(40),
    commit_message TEXT,
    files_changed INT,
    duration_ms INT,
    status ENUM('success', 'failed', 'timeout') DEFAULT 'success',
    error_message TEXT,
    network_latency_ms INT,
    data_transferred_kb INT,
    INDEX idx_timestamp (timestamp),
    INDEX idx_operation (operation),
    INDEX idx_commit (commit_hash)
) ENGINE=InnoDB;

-- =====================================================
-- NOTIFICATION HISTORY
-- =====================================================
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    service ENUM('pushover', 'email', 'slack', 'webhook') NOT NULL,
    recipient VARCHAR(255),
    subject VARCHAR(255),
    message TEXT,
    priority INT DEFAULT 0,
    status ENUM('sent', 'failed', 'timeout') DEFAULT 'sent',
    response_time_ms INT,
    error_message TEXT,
    related_operation_id BIGINT,
    INDEX idx_timestamp (timestamp),
    INDEX idx_service (service),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- =====================================================
-- ERROR TRACKING
-- =====================================================
CREATE TABLE IF NOT EXISTS error_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    error_level ENUM('debug', 'info', 'warning', 'error', 'critical') NOT NULL,
    error_source VARCHAR(255) NOT NULL,
    error_message TEXT NOT NULL,
    error_code VARCHAR(50),
    file_path VARCHAR(255),
    line_number INT,
    stack_trace TEXT,
    user_ip VARCHAR(45),
    user_agent TEXT,
    request_url VARCHAR(500),
    request_method VARCHAR(10),
    post_data TEXT,
    session_data TEXT,
    resolved BOOLEAN DEFAULT FALSE,
    resolved_at DATETIME,
    resolved_by VARCHAR(100),
    notes TEXT,
    INDEX idx_timestamp (timestamp),
    INDEX idx_level (error_level),
    INDEX idx_source (error_source),
    INDEX idx_resolved (resolved)
) ENGINE=InnoDB;

-- =====================================================
-- STORAGE ANALYTICS
-- =====================================================
CREATE TABLE IF NOT EXISTS storage_analytics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    directory VARCHAR(255) NOT NULL,
    file_count INT,
    total_size_mb DECIMAL(10,2),
    largest_file VARCHAR(255),
    largest_file_mb DECIMAL(10,2),
    oldest_file VARCHAR(255),
    oldest_file_date DATETIME,
    file_types JSON,
    growth_rate_mb_per_day DECIMAL(10,2),
    INDEX idx_timestamp (timestamp),
    INDEX idx_directory (directory)
) ENGINE=InnoDB;

-- =====================================================
-- VIEWS FOR REPORTING
-- =====================================================

-- Version deployment success rate
CREATE OR REPLACE VIEW v_deployment_stats AS
SELECT 
    DATE(timestamp) as date,
    COUNT(*) as total_deployments,
    SUM(CASE WHEN status = 'pushed' THEN 1 ELSE 0 END) as successful,
    SUM(CASE WHEN status IN ('failed', 'rolled_back') THEN 1 ELSE 0 END) as failed,
    AVG(total_duration_ms) as avg_duration_ms,
    AVG(snapshot_size_mb) as avg_snapshot_mb
FROM version_history
GROUP BY DATE(timestamp);

-- Web traffic summary
CREATE OR REPLACE VIEW v_traffic_summary AS
SELECT 
    DATE(timestamp) as date,
    COUNT(DISTINCT ip) as unique_visitors,
    COUNT(*) as page_views,
    COUNT(DISTINCT session_id) as sessions,
    AVG(load_time_ms) as avg_load_time,
    SUM(CASE WHEN is_bot = 1 THEN 1 ELSE 0 END) as bot_visits,
    COUNT(DISTINCT CASE WHEN utm_source IS NOT NULL THEN session_id END) as campaign_sessions
FROM web_analytics
GROUP BY DATE(timestamp);

-- System health overview
CREATE OR REPLACE VIEW v_system_health AS
SELECT 
    DATE(timestamp) as date,
    AVG(CASE WHEN metric_type = 'cpu' THEN metric_value END) as avg_cpu,
    AVG(CASE WHEN metric_type = 'memory' THEN metric_value END) as avg_memory,
    AVG(CASE WHEN metric_type = 'disk' THEN metric_value END) as avg_disk,
    COUNT(DISTINCT CASE WHEN error_level IN ('error', 'critical') THEN id END) as error_count
FROM system_metrics
LEFT JOIN error_logs ON DATE(error_logs.timestamp) = DATE(system_metrics.timestamp)
GROUP BY DATE(timestamp);

-- =====================================================
-- STORED PROCEDURES
-- =====================================================

DELIMITER $$

-- Log version deployment
CREATE PROCEDURE sp_log_version_deployment(
    IN p_version VARCHAR(20),
    IN p_previous_version VARCHAR(20),
    IN p_git_commit VARCHAR(40)
)
BEGIN
    INSERT INTO version_history (version, previous_version, git_commit, status)
    VALUES (p_version, p_previous_version, p_git_commit, 'started');
    SELECT LAST_INSERT_ID() as deployment_id;
END$$

-- Log operation
CREATE PROCEDURE sp_log_operation(
    IN p_type VARCHAR(50),
    IN p_name VARCHAR(100),
    IN p_script VARCHAR(255)
)
BEGIN
    INSERT INTO operation_logs (operation_type, operation_name, script_path, status)
    VALUES (p_type, p_name, p_script, 'started');
    SELECT LAST_INSERT_ID() as operation_id;
END$$

-- Update operation status
CREATE PROCEDURE sp_update_operation(
    IN p_id BIGINT,
    IN p_status VARCHAR(20),
    IN p_duration INT,
    IN p_exit_code INT,
    IN p_stdout TEXT,
    IN p_stderr TEXT
)
BEGIN
    UPDATE operation_logs 
    SET status = p_status,
        duration_ms = p_duration,
        exit_code = p_exit_code,
        stdout = p_stdout,
        stderr = p_stderr
    WHERE id = p_id;
END$$

DELIMITER ;

-- =====================================================
-- INDEXES FOR PERFORMANCE
-- =====================================================
ALTER TABLE web_analytics ADD INDEX idx_date_page (DATE(timestamp), page);
ALTER TABLE operation_logs ADD INDEX idx_date_type (DATE(timestamp), operation_type);
ALTER TABLE error_logs ADD INDEX idx_date_level (DATE(timestamp), error_level);

-- =====================================================
-- MAINTENANCE EVENTS
-- =====================================================

-- Auto-cleanup old analytics data (keep 1 year)
CREATE EVENT IF NOT EXISTS e_cleanup_old_analytics
ON SCHEDULE EVERY 1 DAY
DO
    DELETE FROM web_analytics 
    WHERE timestamp < DATE_SUB(NOW(), INTERVAL 365 DAY);

-- Auto-cleanup old operation logs (keep 90 days)
CREATE EVENT IF NOT EXISTS e_cleanup_old_operations
ON SCHEDULE EVERY 1 DAY
DO
    DELETE FROM operation_logs 
    WHERE timestamp < DATE_SUB(NOW(), INTERVAL 90 DAY);