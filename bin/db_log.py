#!/usr/bin/env python3
"""
Database logging wrapper for shell scripts
Usage: db_log.py <action> <args>

Examples:
    db_log.py start_operation "version_bump" "update_version.sh"
    db_log.py end_operation 123 0
    db_log.py log_error "Script failed" "update_version.sh"
    db_log.py log_cleanup "screenshots" 45 1234
"""

import sys
import os
import json
sys.path.append('/opt/webstack/automation/lib')
from DatabaseLogger import DatabaseLogger

def main():
    if len(sys.argv) < 2:
        print("Usage: db_log.py <action> <args>")
        sys.exit(1)
    
    action = sys.argv[1]
    logger = DatabaseLogger()
    
    if action == "start_operation":
        if len(sys.argv) < 4:
            print("Usage: db_log.py start_operation <type> <name> [script_path]")
            sys.exit(1)
        
        op_type = sys.argv[2]
        op_name = sys.argv[3]
        script_path = sys.argv[4] if len(sys.argv) > 4 else None
        
        op_id = logger.log_operation(op_type, op_name, script_path)
        print(op_id)  # Return ID for shell script to capture
        
    elif action == "end_operation":
        if len(sys.argv) < 4:
            print("Usage: db_log.py end_operation <op_id> <exit_code> [stdout] [stderr]")
            sys.exit(1)
        
        op_id = int(sys.argv[2])
        exit_code = int(sys.argv[3])
        stdout = sys.argv[4] if len(sys.argv) > 4 else None
        stderr = sys.argv[5] if len(sys.argv) > 5 else None
        status = 'success' if exit_code == 0 else 'failed'
        
        logger.complete_operation(op_id, status=status, exit_code=exit_code,
                                stdout=stdout, stderr=stderr)
        
    elif action == "log_version":
        if len(sys.argv) < 3:
            print("Usage: db_log.py log_version <new_version> [old_version] [git_commit]")
            sys.exit(1)
        
        new_version = sys.argv[2]
        old_version = sys.argv[3] if len(sys.argv) > 3 else None
        git_commit = sys.argv[4] if len(sys.argv) > 4 else None
        
        deployment_id = logger.log_version_deployment(new_version, old_version, git_commit)
        print(deployment_id)
        
    elif action == "update_version":
        if len(sys.argv) < 4:
            print("Usage: db_log.py update_version <deployment_id> <field> <value>")
            sys.exit(1)
        
        deployment_id = int(sys.argv[2])
        field = sys.argv[3]
        value = sys.argv[4]
        
        # Convert numeric fields
        if field in ['snapshot_size_mb', 'snapshot_duration_ms', 'total_duration_ms',
                    'files_changed', 'lines_added', 'lines_removed']:
            value = int(value)
        
        logger.update_version_deployment(deployment_id, **{field: value})
        
    elif action == "log_cleanup":
        if len(sys.argv) < 5:
            print("Usage: db_log.py log_cleanup <type> <files_deleted> <space_freed_mb>")
            sys.exit(1)
        
        cleanup_type = sys.argv[2]
        files_deleted = int(sys.argv[3])
        space_freed_mb = float(sys.argv[4])
        
        logger.log_cleanup(cleanup_type, files_deleted, space_freed_mb)
        
    elif action == "log_error":
        if len(sys.argv) < 4:
            print("Usage: db_log.py log_error <level> <source> <message>")
            sys.exit(1)
        
        level = sys.argv[2]
        source = sys.argv[3]
        message = sys.argv[4]
        
        logger.log_error(level, source, message)
        
    elif action == "log_git":
        if len(sys.argv) < 3:
            print("Usage: db_log.py log_git <operation> [commit_hash] [message]")
            sys.exit(1)
        
        operation = sys.argv[2]
        commit_hash = sys.argv[3] if len(sys.argv) > 3 else None
        message = sys.argv[4] if len(sys.argv) > 4 else None
        
        logger.log_git_operation(operation, commit_hash=commit_hash, 
                               commit_message=message)
    
    else:
        print(f"Unknown action: {action}")
        sys.exit(1)

if __name__ == "__main__":
    main()