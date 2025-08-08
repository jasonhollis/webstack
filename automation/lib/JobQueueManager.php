<?php
/**
 * KTP Digital Job Queue Manager
 * Integrated version that respects existing webstack configuration
 */

require_once dirname(__DIR__) . '/config/integration.php';

class JobQueueManager {
    private $redis;
    private $mysql;
    private $maxWorkers;
    private $queuePrefix = 'ktp:queue:';
    
    public function __construct() {
        $this->maxWorkers = AUTOMATION_MAX_WORKERS;
        
        // Initialize Redis connection
        $this->redis = new Redis();
        $this->redis->connect(AUTOMATION_REDIS_HOST, AUTOMATION_REDIS_PORT);
        
        // Initialize MySQL connection using existing configuration
        try {
            $this->mysql = new PDO(
                sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', 
                    AUTOMATION_DB_HOST, 
                    AUTOMATION_DB_NAME
                ),
                AUTOMATION_DB_USER,
                AUTOMATION_DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode='STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'"
                ]
            );
            
            $this->initializeDatabase();
        } catch (PDOException $e) {
            error_log("KTP Automation: Database connection failed - " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }
    
    private function initializeDatabase() {
        // Create automation tables if they don't exist
        $sql = "
        CREATE TABLE IF NOT EXISTS automation_jobs (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            job_id VARCHAR(64) UNIQUE NOT NULL,
            client_id VARCHAR(64) NOT NULL,
            job_type VARCHAR(64) NOT NULL,
            priority TINYINT DEFAULT 5,
            status ENUM('queued', 'processing', 'completed', 'failed', 'cancelled') DEFAULT 'queued',
            parameters JSON,
            result JSON,
            error_message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            started_at TIMESTAMP NULL,
            completed_at TIMESTAMP NULL,
            worker_id VARCHAR(64),
            retry_count TINYINT DEFAULT 0,
            max_retries TINYINT DEFAULT 3,
            INDEX idx_status (status),
            INDEX idx_client (client_id),
            INDEX idx_type (job_type),
            INDEX idx_priority (priority),
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB ROW_FORMAT=DYNAMIC;
        
        CREATE TABLE IF NOT EXISTS automation_workers (
            worker_id VARCHAR(64) PRIMARY KEY,
            status ENUM('idle', 'busy', 'offline') DEFAULT 'idle',
            current_job_id VARCHAR(64),
            last_heartbeat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            jobs_processed INT DEFAULT 0,
            INDEX idx_status (status),
            INDEX idx_heartbeat (last_heartbeat)
        ) ENGINE=InnoDB;
        
        CREATE TABLE IF NOT EXISTS automation_metrics (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            metric_type VARCHAR(64) NOT NULL,
            metric_value DECIMAL(10,4),
            recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            metadata JSON,
            INDEX idx_type_time (metric_type, recorded_at)
        ) ENGINE=InnoDB;
        ";
        
        $this->mysql->exec($sql);
    }
    
    /**
     * Queue automation job
     */
    public function queueJob($clientId, $jobType, $parameters = [], $priority = 5) {
        $jobId = 'job_' . uniqid() . '_' . time();
        
        try {
            // Store in MySQL for persistence
            $stmt = $this->mysql->prepare("
                INSERT INTO automation_jobs (job_id, client_id, job_type, priority, parameters)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $jobId,
                $clientId,
                $jobType,
                $priority,
                json_encode($parameters)
            ]);
            
            // Add to Redis queue for fast processing
            $queueData = [
                'job_id' => $jobId,
                'client_id' => $clientId,
                'job_type' => $jobType,
                'priority' => $priority,
                'queued_at' => time()
            ];
            
            $this->redis->zadd($this->queuePrefix . 'pending', $priority, json_encode($queueData));
            
            // Trigger worker notification
            $this->redis->publish('ktp:workers:wakeup', $jobId);
            
            return [
                'success' => true,
                'job_id' => $jobId,
                'position' => $this->getQueuePosition($jobId)
            ];
            
        } catch (Exception $e) {
            error_log("KTP Automation: Failed to queue job - " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to queue job'
            ];
        }
    }
    
    /**
     * Get processing status
     */
    public function getStatus($clientId = null) {
        try {
            $where = $clientId ? "WHERE client_id = ?" : "";
            $params = $clientId ? [$clientId] : [];
            
            $stmt = $this->mysql->prepare("
                SELECT 
                    status,
                    COUNT(*) as count,
                    AVG(CASE WHEN completed_at IS NOT NULL 
                        THEN UNIX_TIMESTAMP(completed_at) - UNIX_TIMESTAMP(started_at) 
                        ELSE NULL END) as avg_duration
                FROM automation_jobs 
                $where
                GROUP BY status
            ");
            
            $stmt->execute($params);
            $statusCounts = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
            
            // Get active workers
            $workerStmt = $this->mysql->query("
                SELECT status, COUNT(*) as count
                FROM automation_workers 
                WHERE last_heartbeat > DATE_SUB(NOW(), INTERVAL 30 SECOND)
                GROUP BY status
            ");
            
            $workerStatus = $workerStmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
            
            return [
                'jobs' => [
                    'queued' => $statusCounts['queued']['count'] ?? 0,
                    'processing' => $statusCounts['processing']['count'] ?? 0,
                    'completed' => $statusCounts['completed']['count'] ?? 0,
                    'failed' => $statusCounts['failed']['count'] ?? 0
                ],
                'workers' => [
                    'idle' => $workerStatus['idle']['count'] ?? 0,
                    'busy' => $workerStatus['busy']['count'] ?? 0,
                    'total' => array_sum(array_column($workerStatus, 'count'))
                ],
                'performance' => [
                    'avg_duration' => round($statusCounts['completed']['avg_duration'] ?? 0, 2),
                    'queue_length' => $this->redis->zcard($this->queuePrefix . 'pending')
                ]
            ];
            
        } catch (Exception $e) {
            error_log("KTP Automation: Failed to get status - " . $e->getMessage());
            return [
                'jobs' => ['queued' => 0, 'processing' => 0, 'completed' => 0, 'failed' => 0],
                'workers' => ['idle' => 0, 'busy' => 0, 'total' => 0],
                'performance' => ['avg_duration' => 0, 'queue_length' => 0]
            ];
        }
    }
    
    private function getQueuePosition($jobId) {
        $jobs = $this->redis->zrevrange($this->queuePrefix . 'pending', 0, -1);
        foreach ($jobs as $index => $job) {
            $data = json_decode($job, true);
            if ($data['job_id'] === $jobId) {
                return $index + 1;
            }
        }
        return -1;
    }
}
