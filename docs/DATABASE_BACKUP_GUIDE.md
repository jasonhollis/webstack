# Database Backup and Recovery Guide

## Overview
This document describes the comprehensive backup strategy for the KTP Digital MariaDB database.

## Current Database Information
- **Database Name**: ktp_digital
- **Current Size**: ~12MB
- **Critical Tables**: premium_leads, web_analytics, automation_jobs, version_history

## Backup Architecture

### 1. Local Automated Backups
Located in `/opt/webstack/backups/`

#### Backup Schedule (via cron)
- **Hourly**: Every hour (24-hour retention)
- **Daily**: 2:30 AM (7-day retention)
- **Weekly**: Sunday 3:00 AM (4-week retention)
- **Monthly**: 1st of month 3:30 AM (3-month retention)

#### Backup Features
- Compressed with gzip (level 9)
- SHA256 checksum verification
- Metadata stored with each backup
- Automatic rotation/cleanup
- Transaction-consistent backups (no table locks)

### 2. Off-site Backup Options
Script: `/opt/webstack/bin/offsite_backup.sh`

Configure one of:
- rsync to remote server
- Backblaze B2 via rclone
- Cloud mount point sync

## Quick Commands

### Create Manual Backup
```bash
python3 /opt/webstack/bin/backup_database.py backup --type manual
```

### Check Backup Statistics
```bash
python3 /opt/webstack/bin/backup_database.py stats
```

### Verify Backup Integrity
```bash
python3 /opt/webstack/bin/backup_database.py verify --file /path/to/backup.sql.gz
```

### Test Restore (dry run)
```bash
python3 /opt/webstack/bin/backup_database.py restore --file /path/to/backup.sql.gz --test
```

### Full Restore
```bash
# WARNING: This will replace the entire database!
python3 /opt/webstack/bin/backup_database.py restore --file /path/to/backup.sql.gz
```

## Emergency Recovery Procedures

### Scenario 1: Accidental Data Deletion
1. Stop application services to prevent further changes:
   ```bash
   systemctl stop nginx php8.2-fpm
   ```

2. Find the most recent backup before the deletion:
   ```bash
   ls -lat /opt/webstack/backups/hourly/
   ```

3. Restore from backup:
   ```bash
   python3 /opt/webstack/bin/backup_database.py restore --file /opt/webstack/backups/hourly/[backup_file]
   ```

4. Restart services:
   ```bash
   systemctl start nginx php8.2-fpm
   ```

### Scenario 2: Database Corruption
1. Stop MariaDB:
   ```bash
   systemctl stop mariadb
   ```

2. Move corrupted database:
   ```bash
   mv /var/lib/mysql/ktp_digital /var/lib/mysql/ktp_digital.corrupted
   ```

3. Start MariaDB:
   ```bash
   systemctl start mariadb
   ```

4. Create new database:
   ```bash
   mariadb -u root -e "CREATE DATABASE ktp_digital;"
   ```

5. Restore from latest backup:
   ```bash
   python3 /opt/webstack/bin/backup_database.py restore --file /opt/webstack/backups/daily/[latest_backup]
   ```

### Scenario 3: Point-in-Time Recovery
For transactions between backups, you'll need binary logs (not currently enabled).

To enable:
1. Edit `/etc/mysql/mariadb.conf.d/50-server.cnf`
2. Add: `log_bin = /var/log/mysql/mariadb-bin`
3. Restart MariaDB

## Manual Backup Methods

### Using mysqldump directly
```bash
# Full backup with compression
mysqldump -u root --single-transaction --routines --triggers --events \
  --databases ktp_digital | gzip -9 > backup_$(date +%Y%m%d_%H%M%S).sql.gz
```

### Using mariabackup (for large databases)
```bash
# Install if needed
apt install mariadb-backup

# Full backup
mariabackup --backup --target-dir=/opt/webstack/backups/mariabackup/ --user=root
```

## Monitoring and Alerts

### Check Backup Health
```bash
# View backup log
tail -f /opt/webstack/backups/backup.log

# Check cron execution
grep backup /var/log/syslog

# View daily statistics
cat /opt/webstack/backups/daily_report.log
```

### Alert Integration
Backup failures are sent via Pushover using the failure.py handler.

## Best Practices

1. **Test Restores Regularly**: Verify backups monthly by restoring to a test database
2. **Monitor Disk Space**: Ensure sufficient space for backup retention
3. **Secure Backups**: Set appropriate permissions (600) on backup files
4. **Encrypt Off-site**: Use encryption for cloud/remote backups
5. **Document Changes**: Update this guide when modifying backup procedures

## Storage Requirements

Current estimates:
- Database size: 12MB
- Compressed backup: ~64KB
- Monthly storage: ~50MB (all retention levels)
- Yearly projection: ~600MB

## Configuration Files

- **Backup Script**: `/opt/webstack/bin/backup_database.py`
- **Cron Schedule**: `/etc/cron.d/database-backup`
- **Off-site Sync**: `/opt/webstack/bin/offsite_backup.sh`
- **Backup Directory**: `/opt/webstack/backups/`

## Troubleshooting

### Backup Fails
1. Check disk space: `df -h /opt/webstack`
2. Verify MariaDB running: `systemctl status mariadb`
3. Check permissions: `ls -la /opt/webstack/backups/`
4. Review logs: `tail /opt/webstack/backups/backup.log`

### Restore Fails
1. Verify backup file integrity: `gzip -t backup.sql.gz`
2. Check MariaDB status: `systemctl status mariadb`
3. Ensure database exists: `mariadb -e "SHOW DATABASES;"`
4. Check user permissions: `mariadb -e "SHOW GRANTS;"`

## Contact

For backup issues, check:
- Pushover notifications for immediate alerts
- `/opt/webstack/backups/backup.log` for detailed logs
- System admin for off-site backup configuration