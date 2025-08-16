#!/bin/bash
# Sync Database Backups to QNAP via Tailscale
# Secure off-site backup to QNAP NAS over Tailscale VPN

# Configuration - UPDATE THESE VALUES
QNAP_HOST="192.168.91.41"     # QNAP via Tailscale subnet routing
QNAP_USER="admin"              # Your QNAP username
QNAP_PATH="/share/Jason/Backups/ktp-digital"  # Destination path on QNAP
SSH_PORT="22"                  # Default SSH port (change if custom)

# Local paths
BACKUP_DIR="/opt/webstack/backups"
LOG_FILE="/opt/webstack/backups/qnap_sync.log"
LOCKFILE="/tmp/qnap_backup_sync.lock"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to log messages
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Function to check configuration
check_config() {
    local config_ok=true
    
    if [ -z "$QNAP_HOST" ]; then
        echo -e "${RED}ERROR: QNAP_HOST not configured${NC}"
        echo "Edit this script and set QNAP_HOST to your QNAP's Tailscale hostname or IP"
        config_ok=false
    fi
    
    if [ -z "$QNAP_USER" ]; then
        echo -e "${RED}ERROR: QNAP_USER not configured${NC}"
        echo "Edit this script and set QNAP_USER to your QNAP username"
        config_ok=false
    fi
    
    if [ -z "$QNAP_PATH" ]; then
        echo -e "${RED}ERROR: QNAP_PATH not configured${NC}"
        echo "Edit this script and set QNAP_PATH to the destination path on your QNAP"
        config_ok=false
    fi
    
    if [ "$config_ok" = false ]; then
        echo -e "${YELLOW}Please configure the variables at the top of this script${NC}"
        exit 1
    fi
}

# Function to test connectivity
test_connection() {
    log_message "Testing connection to QNAP at $QNAP_HOST"
    
    # Test SSH connection
    ssh -q -o ConnectTimeout=10 -o BatchMode=yes \
        -p "$SSH_PORT" \
        "${QNAP_USER}@${QNAP_HOST}" exit
    
    if [ $? -eq 0 ]; then
        log_message "Connection test successful"
        return 0
    else
        log_message "ERROR: Cannot connect to QNAP. Please check:"
        log_message "  1. Tailscale is running on both machines"
        log_message "  2. SSH is enabled on QNAP"
        log_message "  3. SSH keys are configured (or password auth enabled)"
        log_message "  4. QNAP hostname/IP is correct: $QNAP_HOST"
        return 1
    fi
}

# Function to setup SSH key if needed
setup_ssh_key() {
    local ssh_key="/root/.ssh/id_rsa"
    
    if [ ! -f "$ssh_key" ]; then
        echo -e "${YELLOW}No SSH key found. Generating one...${NC}"
        ssh-keygen -t rsa -b 4096 -f "$ssh_key" -N "" -C "ktp-backup@$(hostname)"
        
        echo -e "${GREEN}SSH key generated!${NC}"
        echo "Please add this public key to your QNAP:"
        echo "----------------------------------------"
        cat "${ssh_key}.pub"
        echo "----------------------------------------"
        echo ""
        echo "On your QNAP:"
        echo "1. SSH into QNAP or use the web interface"
        echo "2. Add the above key to ~/.ssh/authorized_keys for user: $QNAP_USER"
        echo "3. Ensure permissions: chmod 600 ~/.ssh/authorized_keys"
        echo ""
        read -p "Press Enter once you've added the key to continue..."
    fi
}

# Function to send Pushover notification
send_pushover_notification() {
    local title="$1"
    local message="$2"
    local priority="${3:--1}"  # Default to low priority
    
    # Use same credentials as failure.py
    API_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
    USER_KEY="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
    
    curl -s \
        --form-string "token=$API_TOKEN" \
        --form-string "user=$USER_KEY" \
        --form-string "title=$title" \
        --form-string "message=$message" \
        --form-string "priority=$priority" \
        https://api.pushover.net/1/messages.json > /dev/null 2>&1
    
    if [ $? -eq 0 ]; then
        log_message "Pushover notification sent: $title"
    else
        log_message "Failed to send Pushover notification"
    fi
}

# Function to log sync to database
log_sync_to_db() {
    local status="$1"
    local files_synced="${2:-0}"
    local bytes_transferred="${3:-0}"
    local error_message="$4"
    
    mariadb -u root ktp_digital -e "
        INSERT INTO backup_sync_log 
        (sync_type, files_synced, bytes_transferred, status, error_message, completed_at)
        VALUES ('qnap', $files_synced, $bytes_transferred, '$status', 
                $([ -z "$error_message" ] && echo "NULL" || echo "'$error_message'"),
                $([ "$status" = "started" ] && echo "NULL" || echo "NOW()"))
    " 2>/dev/null || log_message "Failed to log sync to database"
}

# Function to perform the sync
sync_backups() {
    log_message "Starting backup sync to QNAP"
    log_sync_to_db "started"
    
    # Create remote directory if it doesn't exist
    ssh -p "$SSH_PORT" "${QNAP_USER}@${QNAP_HOST}" "mkdir -p '$QNAP_PATH'" 2>/dev/null
    
    # Sync options
    RSYNC_OPTS=(
        -avz                    # archive, verbose, compress
        --delete                # Remove files that don't exist locally
        --delete-excluded       # Also delete excluded files from dest
        --exclude="*.log"       # Don't sync log files
        --exclude="scripts/"    # Don't sync scripts directory
        --exclude=".DS_Store"   # Exclude Mac files
        --exclude="*.tmp"       # Exclude temp files
        --stats                 # Show transfer statistics
        --human-readable        # Human-readable output
        --timeout=300           # 5-minute timeout
    )
    
    # Add bandwidth limit during business hours (optional)
    current_hour=$(date +%H)
    if [ "$current_hour" -ge 8 ] && [ "$current_hour" -lt 18 ]; then
        RSYNC_OPTS+=(--bwlimit=5000)  # Limit to 5MB/s during business hours
        log_message "Business hours detected - bandwidth limited to 5MB/s"
    fi
    
    # Perform the sync
    rsync "${RSYNC_OPTS[@]}" \
        -e "ssh -p $SSH_PORT" \
        "$BACKUP_DIR/" \
        "${QNAP_USER}@${QNAP_HOST}:${QNAP_PATH}/"
    
    if [ $? -eq 0 ]; then
        log_message "Sync completed successfully"
        
        # Get statistics
        local backup_count=$(find "$BACKUP_DIR" -name "*.sql.gz" | wc -l)
        local total_size_bytes=$(du -sb "$BACKUP_DIR" | cut -f1)
        local total_size=$(du -sh "$BACKUP_DIR" | cut -f1)
        
        log_message "Statistics: $backup_count backup files, Total size: $total_size"
        log_sync_to_db "completed" "$backup_count" "$total_size_bytes"
        
        # Optional: Verify remote files
        remote_count=$(ssh -p "$SSH_PORT" "${QNAP_USER}@${QNAP_HOST}" \
            "find '$QNAP_PATH' -name '*.sql.gz' | wc -l" 2>/dev/null)
        
        if [ "$backup_count" -eq "$remote_count" ]; then
            log_message "Verification: Remote file count matches local ($remote_count files)"
            # Send success notification
            send_pushover_notification \
                "✅ QNAP Sync Complete" \
                "Successfully synced $backup_count backup files ($total_size) to QNAP
Time: $(date '+%H:%M:%S')
Verified: $remote_count files on QNAP"
        else
            log_message "WARNING: File count mismatch - Local: $backup_count, Remote: $remote_count"
            # Send warning notification
            send_pushover_notification \
                "⚠️ QNAP Sync Warning" \
                "Sync completed with mismatch
Local: $backup_count files
Remote: $remote_count files
Size: $total_size" \
                "0"  # Normal priority for warnings
        fi
        
        return 0
    else
        log_message "ERROR: Sync failed"
        log_sync_to_db "failed" "0" "0" "Rsync command failed"
        
        # Send failure notification (already handled by failure.py but adding for consistency)
        send_pushover_notification \
            "❌ QNAP Sync Failed" \
            "Failed to sync backups to QNAP
Error: Rsync command failed
Time: $(date '+%H:%M:%S')" \
            "0"  # Normal priority for failures
        
        return 1
    fi
}

# Function to setup cron job
setup_cron() {
    local cron_file="/etc/cron.d/qnap-backup-sync"
    
    echo "Setting up automated sync schedule..."
    
    cat > "$cron_file" << 'EOF'
# Sync database backups to QNAP via Tailscale
# Runs every 6 hours: 3:15 AM, 9:15 AM, 3:15 PM, 9:15 PM
SHELL=/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

15 3,9,15,21 * * * root /opt/webstack/bin/sync_to_qnap.sh --quiet >/dev/null 2>&1
EOF
    
    echo -e "${GREEN}Cron job created: Syncs 4 times daily${NC}"
    log_message "Automated sync schedule configured"
}

# Main execution
main() {
    # Check for lock file to prevent concurrent runs
    if [ -f "$LOCKFILE" ]; then
        pid=$(cat "$LOCKFILE")
        if ps -p "$pid" > /dev/null 2>&1; then
            log_message "Sync already running (PID: $pid)"
            exit 0
        else
            rm -f "$LOCKFILE"
        fi
    fi
    
    # Create lock file
    echo $$ > "$LOCKFILE"
    trap "rm -f $LOCKFILE" EXIT
    
    # Parse arguments
    QUIET_MODE=false
    if [ "$1" == "--quiet" ]; then
        QUIET_MODE=true
    fi
    
    if [ "$1" == "--setup" ]; then
        check_config
        setup_ssh_key
        test_connection
        if [ $? -eq 0 ]; then
            setup_cron
            echo -e "${GREEN}Setup complete! Performing initial sync...${NC}"
            sync_backups
        fi
        exit $?
    fi
    
    # Regular sync operation
    check_config
    
    if ! $QUIET_MODE; then
        echo -e "${GREEN}=== QNAP Backup Sync ===${NC}"
        echo "Syncing to: ${QNAP_USER}@${QNAP_HOST}:${QNAP_PATH}"
    fi
    
    # Test connection first
    if ! test_connection; then
        # Send alert if failure.py exists
        if [ -f "/opt/webstack/bin/failure.py" ]; then
            python3 /opt/webstack/bin/failure.py "qnap_sync" "Cannot connect to QNAP for backup sync"
        fi
        exit 1
    fi
    
    # Perform sync
    sync_backups
    sync_result=$?
    
    # Send notification on failure
    if [ $sync_result -ne 0 ] && [ -f "/opt/webstack/bin/failure.py" ]; then
        python3 /opt/webstack/bin/failure.py "qnap_sync" "QNAP backup sync failed"
    fi
    
    exit $sync_result
}

# Run main function
main "$@"