#!/bin/bash

# KTP Digital Rollback Script
# Safely removes automation integration if needed

echo "=== KTP DIGITAL ROLLBACK ==="
echo "This will remove the automation integration from your webstack"
echo ""

# Find backup directory
backup_dir=$(ls -d /opt/webstack-backup-* 2>/dev/null | tail -1)

if [ -z "$backup_dir" ]; then
    echo "❌ No backup directory found"
    echo "Manual rollback required"
    exit 1
fi

echo "Found backup: $backup_dir"
echo ""
echo "This will:"
echo "  1. Stop automation services"
echo "  2. Remove automation directories"
echo "  3. Restore nginx configuration"
echo "  4. Restore git state"
echo ""
echo "Are you sure you want to continue? (type 'ROLLBACK' to confirm)"
read -r confirmation

if [ "$confirmation" != "ROLLBACK" ]; then
    echo "Rollback cancelled"
    exit 0
fi

echo "Starting rollback..."

# Stop services
echo "Stopping automation services..."
if systemctl is-active --quiet supervisor; then
    supervisorctl stop ktp-automation:*
fi

# Remove automation directories
echo "Removing automation directories..."
rm -rf /opt/webstack/automation
rm -rf /opt/webstack/client-portal
rm -rf /opt/webstack/infrastructure

# Restore nginx configuration
echo "Restoring nginx configuration..."
if [ -f "/etc/nginx/sites-available/default.backup" ]; then
    cp /etc/nginx/sites-available/default.backup /etc/nginx/sites-available/default
    nginx -t && systemctl reload nginx
fi

# Restore git state
echo "Restoring git state..."
cd /opt/webstack
git checkout main 2>/dev/null || git checkout master 2>/dev/null || true

# Drop automation database
echo "Cleaning up database..."
mysql -u root -e "DROP DATABASE IF EXISTS ktp_digital;" 2>/dev/null || true
mysql -u root -p -e "DROP DATABASE IF EXISTS ktp_digital;" 2>/dev/null || true

echo ""
echo "✅ Rollback completed"
echo "Your webstack has been restored to its pre-automation state"
echo "Backup is still available at: $backup_dir"
