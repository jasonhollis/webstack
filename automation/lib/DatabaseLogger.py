#!/usr/bin/env python3
"""
DatabaseLogger - Centralized database logging for all KTP operations
Replaces file-based logging with structured database storage
"""

import json
import time
import subprocess
import traceback
from datetime import datetime
from typing import Optional, Dict, Any, Tuple
import pymysql
from pymysql.cursors import DictCursor

class DatabaseLogger:
    """Handle all database logging operations"""
    
    def __init__(self, host='localhost', user='root', password='', database='ktp_digital'):
        self.connection_params = {
            'host': host,
            'user': user,
            'password': password,
            'database': database,
            'unix_socket': '/var/run/mysqld/mysqld.sock',  # Use socket for root
            'cursorclass': DictCursor,
            'autocommit': True
        }
    
    def get_connection(self):
        """Get database connection"""
        return pymysql.connect(**self.connection_params)
    
    def log_version_deployment(self, version: str, previous_version: str = None, 
                              git_commit: str = None) -> int:
        """Log start of version deployment"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO version_history 
                    (version, previous_version, git_commit, timestamp, status)
                    VALUES (%s, %s, %s, NOW(), 'started')
                """, (version, previous_version, git_commit))
                return cursor.lastrowid
    
    def update_version_deployment(self, deployment_id: int, **kwargs):
        """Update version deployment record"""
        allowed_fields = [
            'git_tag', 'snapshot_path', 'snapshot_size_mb', 'snapshot_duration_ms',
            'total_duration_ms', 'files_changed', 'lines_added', 'lines_removed',
            'status', 'error_message'
        ]
        
        updates = []
        values = []
        for field in allowed_fields:
            if field in kwargs:
                updates.append(f"{field} = %s")
                values.append(kwargs[field])
        
        if updates:
            values.append(deployment_id)
            with self.get_connection() as conn:
                with conn.cursor() as cursor:
                    cursor.execute(
                        f"UPDATE version_history SET {', '.join(updates)} WHERE id = %s",
                        values
                    )
    
    def log_operation(self, operation_type: str, operation_name: str, 
                     script_path: str = None) -> int:
        """Log start of an operation"""
        start_time = time.time()
        
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO operation_logs 
                    (operation_type, operation_name, script_path, timestamp, status)
                    VALUES (%s, %s, %s, NOW(), 'started')
                """, (operation_type, operation_name, script_path))
                return cursor.lastrowid
    
    def complete_operation(self, operation_id: int, status: str = 'success',
                          exit_code: int = 0, stdout: str = None, 
                          stderr: str = None, duration_ms: int = None):
        """Complete an operation log entry"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    UPDATE operation_logs 
                    SET status = %s, exit_code = %s, stdout = %s, stderr = %s,
                        duration_ms = %s
                    WHERE id = %s
                """, (status, exit_code, stdout, stderr, duration_ms, operation_id))
    
    def log_web_analytics(self, ip: str, page: str, user_agent: str,
                         referer: str = None, status_code: int = 200,
                         load_time_ms: int = None, **kwargs):
        """Log web analytics data"""
        # Parse UTM parameters if present
        utm_fields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content']
        
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO web_analytics 
                    (ip, page, user_agent, referer, status_code, load_time_ms,
                     utm_source, utm_medium, utm_campaign, utm_term, utm_content,
                     query_string, session_id, is_bot, bot_name)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """, (
                    ip, page, user_agent, referer, status_code, load_time_ms,
                    kwargs.get('utm_source'), kwargs.get('utm_medium'),
                    kwargs.get('utm_campaign'), kwargs.get('utm_term'),
                    kwargs.get('utm_content'), kwargs.get('query_string'),
                    kwargs.get('session_id'), kwargs.get('is_bot', False),
                    kwargs.get('bot_name')
                ))
    
    def log_cleanup(self, cleanup_type: str, files_deleted: int = 0,
                   space_freed_mb: float = 0, details: dict = None):
        """Log cleanup operations"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO cleanup_logs 
                    (cleanup_type, files_deleted, space_freed_mb, details, timestamp)
                    VALUES (%s, %s, %s, %s, NOW())
                """, (cleanup_type, files_deleted, space_freed_mb, 
                     json.dumps(details) if details else None))
    
    def log_git_operation(self, operation: str, branch: str = None,
                         commit_hash: str = None, commit_message: str = None,
                         duration_ms: int = None, status: str = 'success',
                         error_message: str = None, **kwargs):
        """Log git operations"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO git_operations 
                    (operation, branch, commit_hash, commit_message, duration_ms,
                     status, error_message, files_changed, remote, network_latency_ms)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """, (operation, branch, commit_hash, commit_message, duration_ms,
                     status, error_message, kwargs.get('files_changed'),
                     kwargs.get('remote'), kwargs.get('network_latency_ms')))
    
    def log_error(self, error_level: str, error_source: str, error_message: str,
                 error_code: str = None, file_path: str = None, 
                 line_number: int = None, **kwargs):
        """Log errors"""
        stack_trace = kwargs.get('stack_trace', traceback.format_exc())
        
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO error_logs 
                    (error_level, error_source, error_message, error_code,
                     file_path, line_number, stack_trace, user_ip, user_agent,
                     request_url, request_method, timestamp)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW())
                """, (error_level, error_source, error_message, error_code,
                     file_path, line_number, stack_trace, kwargs.get('user_ip'),
                     kwargs.get('user_agent'), kwargs.get('request_url'),
                     kwargs.get('request_method')))
    
    def log_notification(self, service: str, recipient: str, subject: str,
                        message: str, status: str = 'sent', 
                        response_time_ms: int = None, error_message: str = None):
        """Log notification attempts"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO notifications 
                    (service, recipient, subject, message, status, 
                     response_time_ms, error_message, timestamp)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, NOW())
                """, (service, recipient, subject, message, status,
                     response_time_ms, error_message))
    
    def log_system_metric(self, metric_type: str, metric_name: str,
                         metric_value: float, metric_unit: str = None,
                         details: dict = None):
        """Log system metrics"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    INSERT INTO system_metrics 
                    (metric_type, metric_name, metric_value, metric_unit, 
                     details, timestamp)
                    VALUES (%s, %s, %s, %s, %s, NOW())
                """, (metric_type, metric_name, metric_value, metric_unit,
                     json.dumps(details) if details else None))
    
    def execute_command_with_logging(self, command: str, operation_name: str,
                                    timeout: int = 300) -> Tuple[int, str, str]:
        """Execute a shell command and log it to database"""
        operation_id = self.log_operation('shell_command', operation_name, command)
        start_time = time.time()
        
        try:
            result = subprocess.run(
                command,
                shell=True,
                capture_output=True,
                text=True,
                timeout=timeout
            )
            
            duration_ms = int((time.time() - start_time) * 1000)
            status = 'success' if result.returncode == 0 else 'failed'
            
            self.complete_operation(
                operation_id,
                status=status,
                exit_code=result.returncode,
                stdout=result.stdout[:65000],  # Limit to TEXT field size
                stderr=result.stderr[:65000],
                duration_ms=duration_ms
            )
            
            return result.returncode, result.stdout, result.stderr
            
        except subprocess.TimeoutExpired:
            duration_ms = int((time.time() - start_time) * 1000)
            self.complete_operation(
                operation_id,
                status='timeout',
                exit_code=-1,
                stderr=f"Command timed out after {timeout} seconds",
                duration_ms=duration_ms
            )
            raise
        except Exception as e:
            duration_ms = int((time.time() - start_time) * 1000)
            self.complete_operation(
                operation_id,
                status='failed',
                exit_code=-1,
                stderr=str(e),
                duration_ms=duration_ms
            )
            raise
    
    def get_recent_operations(self, limit: int = 10) -> list:
        """Get recent operations"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    SELECT * FROM operation_logs 
                    ORDER BY timestamp DESC 
                    LIMIT %s
                """, (limit,))
                return cursor.fetchall()
    
    def get_deployment_stats(self, days: int = 30) -> dict:
        """Get deployment statistics"""
        with self.get_connection() as conn:
            with conn.cursor() as cursor:
                cursor.execute("""
                    SELECT 
                        COUNT(*) as total_deployments,
                        SUM(CASE WHEN status = 'pushed' THEN 1 ELSE 0 END) as successful,
                        SUM(CASE WHEN status IN ('failed', 'rolled_back') THEN 1 ELSE 0 END) as failed,
                        AVG(total_duration_ms) as avg_duration_ms,
                        AVG(snapshot_size_mb) as avg_snapshot_mb
                    FROM version_history
                    WHERE timestamp > DATE_SUB(NOW(), INTERVAL %s DAY)
                """, (days,))
                return cursor.fetchone()


# Example usage functions for shell scripts to call
def log_script_start(script_name: str) -> int:
    """Called from shell scripts at start"""
    logger = DatabaseLogger()
    return logger.log_operation('script', script_name, script_name)

def log_script_end(operation_id: int, exit_code: int = 0):
    """Called from shell scripts at end"""
    logger = DatabaseLogger()
    status = 'success' if exit_code == 0 else 'failed'
    logger.complete_operation(operation_id, status=status, exit_code=exit_code)

if __name__ == "__main__":
    # Test the logger
    logger = DatabaseLogger()
    
    # Test version deployment logging
    deployment_id = logger.log_version_deployment('v1.8.5', 'v1.8.4', 'abc123')
    print(f"Created deployment {deployment_id}")
    
    # Test operation logging
    op_id = logger.log_operation('manual_script', 'test_operation', '/bin/test.sh')
    print(f"Created operation {op_id}")
    logger.complete_operation(op_id, status='success', exit_code=0)
    
    # Get recent operations
    recent = logger.get_recent_operations(5)
    print(f"Recent operations: {recent}")
    
    # Get deployment stats
    stats = logger.get_deployment_stats()
    print(f"Deployment stats: {stats}")