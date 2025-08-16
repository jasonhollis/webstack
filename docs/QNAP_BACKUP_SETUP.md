# QNAP Offsite Backup Setup Guide

## Overview
This guide helps you set up automated database backups to your QNAP NAS via Tailscale VPN.

## Prerequisites
- QNAP NAS with SSH enabled
- Tailscale installed on both VPS and QNAP
- Sufficient storage on QNAP

## Step 1: Install Tailscale on VPS (if not already installed)

```bash
# Quick install
curl -fsSL https://tailscale.com/install.sh | sh

# Start Tailscale
sudo tailscale up

# Get the Tailscale IP
tailscale ip -4
```

## Step 2: Install Tailscale on QNAP

1. **Via QNAP App Center**:
   - Open App Center on QNAP
   - Search for "Tailscale"
   - Install the app
   - Configure with your Tailscale account

2. **Or via Container Station** (if App Center version unavailable):
   - Use Docker container: `tailscale/tailscale`

## Step 3: Configure the Backup Script

Edit `/opt/webstack/bin/sync_to_qnap.sh` and set these variables:

```bash
QNAP_HOST="qnap"           # Your QNAP's Tailscale hostname or 100.x.x.x IP
QNAP_USER="admin"          # Your QNAP username
QNAP_PATH="/share/Backups/ktp-digital"  # Destination path on QNAP
SSH_PORT="22"              # Usually 22, might be different on QNAP
```

## Step 4: Setup SSH Key Authentication

Run the setup wizard:
```bash
/opt/webstack/bin/sync_to_qnap.sh --setup
```

This will:
1. Generate an SSH key (if needed)
2. Display the public key to add to your QNAP
3. Test the connection
4. Set up automated sync schedule

### Manual SSH Key Setup on QNAP

1. **SSH into your QNAP**:
   ```bash
   ssh admin@<qnap-local-ip>
   ```

2. **Add the public key**:
   ```bash
   mkdir -p ~/.ssh
   chmod 700 ~/.ssh
   echo "ssh-rsa AAAA... (paste key here)" >> ~/.ssh/authorized_keys
   chmod 600 ~/.ssh/authorized_keys
   ```

3. **Enable SSH key auth** (if needed):
   - QNAP Web UI → Control Panel → Network & File Services → Telnet/SSH
   - Ensure "Allow SSH connection" is checked
   - Set "Authentication method" to include public key

## Step 5: Test Manual Sync

```bash
# Test the sync manually
/opt/webstack/bin/sync_to_qnap.sh

# Check the log
tail -f /opt/webstack/backups/qnap_sync.log
```

## Step 6: Verify Automated Schedule

The setup creates a cron job that runs 4 times daily:
- 3:15 AM
- 9:15 AM  
- 3:15 PM
- 9:15 PM

Check the cron job:
```bash
cat /etc/cron.d/qnap-backup-sync
```

## Monitoring

### Check Sync Status
```bash
# View recent sync logs
tail -20 /opt/webstack/backups/qnap_sync.log

# Check if sync is running
ps aux | grep sync_to_qnap
```

### Verify Remote Backups
```bash
# List backups on QNAP (via Tailscale)
ssh admin@qnap "ls -la /share/Backups/ktp-digital/daily/"
```

## Troubleshooting

### Connection Issues
1. **Check Tailscale status**:
   ```bash
   tailscale status
   tailscale ping qnap
   ```

2. **Verify SSH access**:
   ```bash
   ssh -v admin@qnap
   ```

3. **Check QNAP firewall**:
   - Ensure port 22 is open for Tailscale network (100.x.x.x/8)

### Sync Failures
1. **Permission issues**:
   - Ensure QNAP user has write access to destination
   - Check: `ssh admin@qnap "touch /share/Backups/ktp-digital/test.txt"`

2. **Storage space**:
   - Verify QNAP has sufficient space
   - Check: `ssh admin@qnap "df -h /share/Backups"`

3. **Network issues**:
   - Check Tailscale connection stability
   - Try manual rsync with verbose: `rsync -avvz ...`

## Restore from QNAP

If you need to restore from QNAP backup:

```bash
# List available backups on QNAP
ssh admin@qnap "ls -la /share/Backups/ktp-digital/daily/"

# Copy backup from QNAP to local
scp admin@qnap:/share/Backups/ktp-digital/daily/ktp_digital_daily_*.sql.gz /tmp/

# Restore the backup
python3 /opt/webstack/bin/backup_database.py restore --file /tmp/ktp_digital_daily_*.sql.gz
```

## Security Notes

1. **Tailscale Security**:
   - All traffic is encrypted end-to-end via WireGuard
   - No port forwarding needed
   - Access controlled by Tailscale ACLs

2. **Backup Encryption** (optional):
   - For extra security, enable encryption in the sync script
   - Or use QNAP's encrypted folders feature

3. **Access Control**:
   - Use a dedicated QNAP user for backups
   - Restrict SSH key to backup operations only

## Backup Retention on QNAP

The sync uses `--delete` flag, so QNAP mirrors the VPS retention:
- Hourly: 24 hours
- Daily: 7 days
- Weekly: 4 weeks
- Monthly: 3 months

To keep longer archives on QNAP, create a separate archive script.

## Cost Analysis

Using QNAP via Tailscale:
- **Storage Cost**: $0 (using existing QNAP storage)
- **Transfer Cost**: $0 (Tailscale is free for personal use)
- **Total Monthly Cost**: $0

Compared to cloud alternatives:
- Backblaze B2: ~$0.06/month (for 12MB)
- AWS S3: ~$0.28/month
- rsync.net: ~$15/month minimum

## Support

- **Tailscale Issues**: https://tailscale.com/kb/
- **QNAP SSH Setup**: QNAP forums or documentation
- **Backup Script Issues**: Check `/opt/webstack/backups/qnap_sync.log`