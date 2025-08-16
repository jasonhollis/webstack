#!/bin/bash
# Off-site Database Backup Sync Script
# Syncs local backups to remote location

# Configuration
BACKUP_DIR="/opt/webstack/backups"
LOG_FILE="/opt/webstack/backups/offsite_sync.log"

# Remote backup destinations (configure as needed)
# Option 1: rsync to another server
# REMOTE_HOST="backup.example.com"
# REMOTE_USER="backup"
# REMOTE_PATH="/backups/ktp-digital"

# Option 2: Mount point for cloud storage (rclone, s3fs, etc)
# CLOUD_MOUNT="/mnt/cloud-backup"

# Option 3: Backblaze B2 using rclone
# Requires: apt install rclone && rclone config
# RCLONE_REMOTE="b2:ktp-digital-backups"

log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

# Function for rsync to remote server
sync_to_remote_server() {
    if [ -z "$REMOTE_HOST" ] || [ -z "$REMOTE_USER" ] || [ -z "$REMOTE_PATH" ]; then
        log_message "ERROR: Remote server configuration not set"
        return 1
    fi
    
    log_message "Starting sync to $REMOTE_HOST"
    
    rsync -avz --delete \
        --exclude="*.log" \
        --exclude="scripts/" \
        "$BACKUP_DIR/" \
        "${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_PATH}/"
    
    if [ $? -eq 0 ]; then
        log_message "Sync to remote server completed successfully"
        return 0
    else
        log_message "ERROR: Sync to remote server failed"
        return 1
    fi
}

# Function for cloud storage sync using rclone
sync_to_cloud() {
    if ! command -v rclone &> /dev/null; then
        log_message "ERROR: rclone not installed"
        return 1
    fi
    
    if [ -z "$RCLONE_REMOTE" ]; then
        log_message "ERROR: RCLONE_REMOTE not configured"
        return 1
    fi
    
    log_message "Starting sync to cloud storage"
    
    rclone sync "$BACKUP_DIR" "$RCLONE_REMOTE" \
        --exclude="*.log" \
        --exclude="scripts/" \
        --transfers 4 \
        --checkers 8 \
        --contimeout 60s \
        --timeout 300s \
        --retries 3 \
        --low-level-retries 10 \
        --stats 10s \
        --stats-file-name-length 0
    
    if [ $? -eq 0 ]; then
        log_message "Sync to cloud storage completed successfully"
        return 0
    else
        log_message "ERROR: Sync to cloud storage failed"
        return 1
    fi
}

# Function for local mount point sync
sync_to_mount() {
    if [ -z "$CLOUD_MOUNT" ]; then
        log_message "ERROR: CLOUD_MOUNT not configured"
        return 1
    fi
    
    if [ ! -d "$CLOUD_MOUNT" ]; then
        log_message "ERROR: Cloud mount point $CLOUD_MOUNT does not exist"
        return 1
    fi
    
    log_message "Starting sync to cloud mount"
    
    rsync -av --delete \
        --exclude="*.log" \
        --exclude="scripts/" \
        "$BACKUP_DIR/" \
        "$CLOUD_MOUNT/"
    
    if [ $? -eq 0 ]; then
        log_message "Sync to cloud mount completed successfully"
        return 0
    else
        log_message "ERROR: Sync to cloud mount failed"
        return 1
    fi
}

# Main execution
log_message "=== Starting off-site backup sync ==="

# Uncomment the sync method you want to use:

# sync_to_remote_server
# sync_to_cloud
# sync_to_mount

log_message "Off-site backup sync completed"

# Send notification if failure.py is available
if [ -f "/opt/webstack/bin/failure.py" ] && [ $? -ne 0 ]; then
    python3 /opt/webstack/bin/failure.py "offsite_backup" "Off-site backup sync failed"
fi