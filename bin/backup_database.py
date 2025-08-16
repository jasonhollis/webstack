#!/usr/bin/env python3
"""
Database Backup Manager for KTP Digital
Handles automated MariaDB backups with rotation and retention policies
"""

import os
import sys
import subprocess
import datetime
import gzip
import shutil
import json
from pathlib import Path
import argparse
import hashlib

sys.path.insert(0, '/opt/webstack/automation/lib')

try:
    from DatabaseLogger import DatabaseLogger
    db_logger = DatabaseLogger()
    USE_DB_LOGGING = True
except ImportError:
    USE_DB_LOGGING = False
    print("Warning: DatabaseLogger not available, using file logging only")

from failure import FailureHandler

class DatabaseBackupManager:
    def __init__(self):
        self.base_dir = Path('/opt/webstack/backups')
        self.db_name = 'ktp_digital'
        self.db_user = 'root'
        self.failure_handler = FailureHandler()
        self.send_notifications = True  # Enable notifications
        
        # Retention policies (in days)
        self.retention = {
            'hourly': 1,    # Keep hourly backups for 24 hours
            'daily': 7,     # Keep daily backups for 7 days
            'weekly': 28,   # Keep weekly backups for 4 weeks
            'monthly': 90   # Keep monthly backups for 3 months
        }
        
        # Ensure backup directories exist
        for backup_type in ['hourly', 'daily', 'weekly', 'monthly', 'manual']:
            (self.base_dir / backup_type).mkdir(parents=True, exist_ok=True)
            
    def send_success_notification(self, backup_type, filename, size_mb):
        """Send Pushover notification for successful backup"""
        try:
            # Only send for hourly backups and manual for now
            if backup_type not in ['hourly', 'manual']:
                return
                
            import requests
            
            # Use same credentials as failure.py
            api_token = "aqfyb8hsfb6txs6pd4qwchjwd3iccb"
            user_key = "uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
            
            # Format message
            title = f"✅ DB Backup: {backup_type.capitalize()}"
            message = f"Backup completed successfully\nFile: {filename}\nSize: {size_mb:.2f} MB\nTime: {datetime.datetime.now().strftime('%H:%M:%S')}"
            
            # Send notification
            response = requests.post(
                'https://api.pushover.net/1/messages.json',
                data={
                    'token': api_token,
                    'user': user_key,
                    'title': title,
                    'message': message,
                    'priority': -1  # Low priority (no sound/vibration)
                },
                timeout=5
            )
            
            if response.status_code == 200:
                self.log_operation(f"Pushover notification sent for {backup_type} backup")
        except Exception as e:
            # Don't fail backup if notification fails
            self.log_operation(f"Failed to send notification: {e}", 'warning')
    
    def log_operation(self, message, level='info'):
        """Log to both database and file"""
        timestamp = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        log_entry = f"[{timestamp}] {level.upper()}: {message}"
        
        # File logging
        log_file = self.base_dir / 'backup.log'
        with open(log_file, 'a') as f:
            f.write(log_entry + '\n')
            
        # Database logging if available
        if USE_DB_LOGGING and level == 'error':
            try:
                db_logger.log_error(
                    error_level='error',
                    error_source='backup_database.py',
                    error_message=message
                )
            except Exception as e:
                print(f"Warning: Could not log to database: {e}")
            
    def log_backup_to_db(self, backup_type, filename, file_path, file_size, checksum, status='completed', error_message=None):
        """Log backup information to database"""
        try:
            import pymysql
            conn = pymysql.connect(
                host='localhost',
                user='root',
                database='ktp_digital',
                charset='utf8mb4'
            )
            cursor = conn.cursor()
            
            cursor.execute("""
                INSERT INTO database_backups 
                (backup_type, filename, file_path, file_size, checksum, status, error_message)
                VALUES (%s, %s, %s, %s, %s, %s, %s)
            """, (backup_type, filename, file_path, file_size, checksum, status, error_message))
            
            conn.commit()
            cursor.close()
            conn.close()
            self.log_operation(f"Logged backup to database: {filename}")
        except Exception as e:
            self.log_operation(f"Failed to log backup to database: {e}", 'warning')
    
    def create_backup(self, backup_type='manual'):
        """Create a database backup"""
        try:
            # Start operation logging
            if USE_DB_LOGGING:
                op_id = db_logger.log_operation(
                    operation_type='backup',
                    operation_name=f'{backup_type} database backup',
                    script_path='/opt/webstack/bin/backup_database.py'
                )
            
            timestamp = datetime.datetime.now().strftime('%Y%m%d_%H%M%S')
            backup_file = self.base_dir / backup_type / f"{self.db_name}_{backup_type}_{timestamp}.sql"
            backup_gz = f"{backup_file}.gz"
            
            self.log_operation(f"Starting {backup_type} backup to {backup_file}")
            
            # Create the backup using mysqldump
            dump_cmd = [
                'mysqldump',
                '-u', self.db_user,
                '--single-transaction',  # Consistent backup without locking
                '--routines',            # Include stored procedures
                '--triggers',            # Include triggers
                '--events',              # Include events
                '--add-drop-database',   # Add DROP DATABASE before CREATE
                '--create-options',      # Include all table options
                '--extended-insert',     # Use extended INSERT syntax
                '--databases', self.db_name
            ]
            
            # Execute backup
            with open(backup_file, 'w') as f:
                result = subprocess.run(dump_cmd, stdout=f, stderr=subprocess.PIPE, text=True)
                
            if result.returncode != 0:
                error_msg = f"Backup failed: {result.stderr}"
                self.log_operation(error_msg, 'error')
                if USE_DB_LOGGING:
                    db_logger.complete_operation(op_id, 'failed', result.returncode, '', result.stderr)
                self.failure_handler.notify_failure('backup_database', error_msg)
                return None
                
            # Compress the backup
            self.log_operation(f"Compressing backup to {backup_gz}")
            with open(backup_file, 'rb') as f_in:
                with gzip.open(backup_gz, 'wb', compresslevel=9) as f_out:
                    shutil.copyfileobj(f_in, f_out)
                    
            # Remove uncompressed file
            os.remove(backup_file)
            
            # Calculate checksum
            checksum = self.calculate_checksum(backup_gz)
            self.log_operation(f"Backup complete: {backup_gz} (checksum: {checksum})")
            
            # Store backup metadata
            file_size = os.path.getsize(backup_gz)
            metadata = {
                'timestamp': timestamp,
                'type': backup_type,
                'file': str(backup_gz),
                'size': file_size,
                'checksum': checksum,
                'db_name': self.db_name
            }
            
            metadata_file = f"{backup_gz}.meta"
            with open(metadata_file, 'w') as f:
                json.dump(metadata, f, indent=2)
            
            # Log to database
            self.log_backup_to_db(
                backup_type=backup_type,
                filename=os.path.basename(backup_gz),
                file_path=str(backup_gz),
                file_size=file_size,
                checksum=checksum,
                status='completed'
            )
            
            # Send success notification
            if self.send_notifications:
                size_mb = file_size / (1024 * 1024)
                self.send_success_notification(backup_type, os.path.basename(backup_gz), size_mb)
                
            # Complete operation logging
            if USE_DB_LOGGING:
                db_logger.complete_operation(
                    op_id, 'success', 0,
                    f"Backup created: {backup_gz} ({metadata['size']} bytes)",
                    ''
                )
                
            return backup_gz
            
        except Exception as e:
            error_msg = f"Backup exception: {str(e)}"
            self.log_operation(error_msg, 'error')
            if USE_DB_LOGGING:
                db_logger.complete_operation(op_id, 'failed', 1, '', error_msg)
            self.failure_handler.notify_failure('backup_database', error_msg)
            return None
            
    def calculate_checksum(self, file_path):
        """Calculate SHA256 checksum of backup file"""
        sha256_hash = hashlib.sha256()
        with open(file_path, "rb") as f:
            for byte_block in iter(lambda: f.read(4096), b""):
                sha256_hash.update(byte_block)
        return sha256_hash.hexdigest()
        
    def cleanup_old_backups(self, backup_type):
        """Remove backups older than retention period"""
        retention_days = self.retention.get(backup_type, 7)
        cutoff_date = datetime.datetime.now() - datetime.timedelta(days=retention_days)
        
        backup_dir = self.base_dir / backup_type
        removed_count = 0
        
        for backup_file in backup_dir.glob(f"{self.db_name}_{backup_type}_*.sql.gz"):
            # Parse timestamp from filename
            try:
                filename = backup_file.name
                timestamp_str = filename.split('_')[2] + '_' + filename.split('_')[3].replace('.sql.gz', '')
                file_date = datetime.datetime.strptime(timestamp_str, '%Y%m%d_%H%M%S')
                
                if file_date < cutoff_date:
                    self.log_operation(f"Removing old backup: {backup_file}")
                    backup_file.unlink()
                    # Also remove metadata file
                    meta_file = Path(f"{backup_file}.meta")
                    if meta_file.exists():
                        meta_file.unlink()
                    removed_count += 1
                    
            except Exception as e:
                self.log_operation(f"Error processing {backup_file}: {e}", 'warning')
                
        if removed_count > 0:
            self.log_operation(f"Cleaned up {removed_count} old {backup_type} backups")
            
    def verify_backup(self, backup_file):
        """Verify backup integrity"""
        try:
            # Check if file exists
            if not Path(backup_file).exists():
                return False, "Backup file not found"
                
            # Verify checksum if metadata exists
            meta_file = f"{backup_file}.meta"
            if Path(meta_file).exists():
                with open(meta_file, 'r') as f:
                    metadata = json.load(f)
                    
                stored_checksum = metadata.get('checksum')
                current_checksum = self.calculate_checksum(backup_file)
                
                if stored_checksum != current_checksum:
                    return False, "Checksum mismatch"
                    
            # Test decompression
            test_cmd = ['gzip', '-t', backup_file]
            result = subprocess.run(test_cmd, capture_output=True, text=True)
            
            if result.returncode != 0:
                return False, f"Compression test failed: {result.stderr}"
                
            return True, "Backup verified successfully"
            
        except Exception as e:
            return False, f"Verification error: {str(e)}"
            
    def restore_backup(self, backup_file, test_mode=False):
        """Restore a database backup"""
        try:
            if not Path(backup_file).exists():
                return False, "Backup file not found"
                
            self.log_operation(f"Starting restore from {backup_file}")
            
            # Decompress and restore
            if test_mode:
                # Just test the backup can be read
                test_cmd = f"gzip -dc {backup_file} | head -100"
                result = subprocess.run(test_cmd, shell=True, capture_output=True, text=True)
                if result.returncode == 0:
                    return True, "Test restore successful (first 100 lines readable)"
                else:
                    return False, f"Test restore failed: {result.stderr}"
            else:
                # Actual restore
                restore_cmd = f"gzip -dc {backup_file} | mariadb -u {self.db_user}"
                result = subprocess.run(restore_cmd, shell=True, capture_output=True, text=True)
                
                if result.returncode == 0:
                    self.log_operation("Database restored successfully")
                    return True, "Restore completed successfully"
                else:
                    error_msg = f"Restore failed: {result.stderr}"
                    self.log_operation(error_msg, 'error')
                    return False, error_msg
                    
        except Exception as e:
            error_msg = f"Restore exception: {str(e)}"
            self.log_operation(error_msg, 'error')
            return False, error_msg
            
    def get_backup_stats(self):
        """Get statistics about current backups"""
        stats = {}
        total_size = 0
        total_count = 0
        
        for backup_type in self.retention.keys():
            backup_dir = self.base_dir / backup_type
            backups = list(backup_dir.glob(f"{self.db_name}_{backup_type}_*.sql.gz"))
            
            type_size = sum(b.stat().st_size for b in backups)
            stats[backup_type] = {
                'count': len(backups),
                'size_mb': round(type_size / (1024 * 1024), 2),
                'latest': max(backups, key=os.path.getctime).name if backups else None
            }
            
            total_size += type_size
            total_count += len(backups)
            
        stats['total'] = {
            'count': total_count,
            'size_mb': round(total_size / (1024 * 1024), 2)
        }
        
        return stats

def main():
    parser = argparse.ArgumentParser(description='Database Backup Manager')
    parser.add_argument('action', choices=['backup', 'cleanup', 'verify', 'restore', 'stats'],
                       help='Action to perform')
    parser.add_argument('--type', choices=['hourly', 'daily', 'weekly', 'monthly', 'manual'],
                       default='manual', help='Backup type')
    parser.add_argument('--file', help='Backup file for verify/restore operations')
    parser.add_argument('--test', action='store_true', help='Test mode for restore')
    
    args = parser.parse_args()
    
    manager = DatabaseBackupManager()
    
    if args.action == 'backup':
        backup_file = manager.create_backup(args.type)
        if backup_file:
            manager.cleanup_old_backups(args.type)
            print(f"Backup created: {backup_file}")
            sys.exit(0)
        else:
            print("Backup failed")
            sys.exit(1)
            
    elif args.action == 'cleanup':
        manager.cleanup_old_backups(args.type)
        print(f"Cleaned up old {args.type} backups")
        
    elif args.action == 'verify':
        if not args.file:
            print("Error: --file required for verify")
            sys.exit(1)
        success, message = manager.verify_backup(args.file)
        print(message)
        sys.exit(0 if success else 1)
        
    elif args.action == 'restore':
        if not args.file:
            print("Error: --file required for restore")
            sys.exit(1)
        success, message = manager.restore_backup(args.file, args.test)
        print(message)
        sys.exit(0 if success else 1)
        
    elif args.action == 'stats':
        stats = manager.get_backup_stats()
        print("\n=== Backup Statistics ===")
        for backup_type, info in stats.items():
            if backup_type != 'total':
                print(f"\n{backup_type.capitalize()}:")
                print(f"  Count: {info['count']}")
                print(f"  Size: {info['size_mb']} MB")
                if info['latest']:
                    print(f"  Latest: {info['latest']}")
        print(f"\nTotal: {stats['total']['count']} backups, {stats['total']['size_mb']} MB")

if __name__ == '__main__':
    main()