#!/usr/bin/env python3
"""
Test dual logging implementation
"""

import sys
sys.path.append('/opt/webstack/automation/lib')

from DatabaseLogger import DatabaseLogger

def test_database_logging():
    """Test that database logging is working"""
    print("Testing database logging...")
    
    try:
        db_logger = DatabaseLogger()
        
        # Test operation logging
        op_id = db_logger.log_operation(
            operation_type='manual_script',
            operation_name='dual_logging_test',
            script_path='bin/test_dual_logging.py'
        )
        print(f"✅ Created operation log with ID: {op_id}")
        
        # Complete the operation
        db_logger.complete_operation(
            operation_id=op_id,
            status='success',
            exit_code=0,
            stdout='Test completed successfully',
            duration_ms=100
        )
        print(f"✅ Completed operation log")
        
        # Test version deployment logging
        deployment_id = db_logger.log_version_deployment(
            version='v2.1.2-test',
            previous_version='v2.1.1',
            git_commit='abc123test'
        )
        print(f"✅ Created version deployment with ID: {deployment_id}")
        
        # Update deployment with stats
        db_logger.update_version_deployment(
            deployment_id,
            status='pushed',
            files_changed=5,
            lines_added=100,
            lines_removed=50
        )
        print(f"✅ Updated version deployment")
        
        print("\n✅ All database logging tests passed!")
        return True
        
    except Exception as e:
        print(f"❌ Database logging test failed: {e}")
        return False

if __name__ == "__main__":
    success = test_database_logging()
    sys.exit(0 if success else 1)