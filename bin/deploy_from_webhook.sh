#!/bin/bash

REPO_DIR="/opt/webstack/html"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
VERSION_FILE="/opt/webstack/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
PHP_SERVICE="php8.2-fpm"
NGINX_SERVICE="nginx"

echo "[$(date)] 🚀 GitHub webhook received" >> "$LOG_FILE"

cd "$REPO_DIR" || {
  echo "[$(date)] ❌ Failed to cd into $REPO_DIR" >> "$LOG_FILE"
  exit 1
}

# Ensure we are on the correct branch and pull
git fetch origin master >> "$LOG_FILE" 2>&1
git reset --hard origin/master >> "$LOG_FILE" 2>&1

if [ $? -eq 0 ]; then
  echo "[$(date)] ✅ Pull complete" >> "$LOG_FILE"
else
  echo "[$(date)] ❌ Git pull failed" >> "$LOG_FILE"
  exit 1
fi

# Snapshot current deploy state
if [ -x "$SNAPSHOT_SCRIPT" ]; then
  "$SNAPSHOT_SCRIPT" >> "$LOG_FILE" 2>&1
else
  echo "[$(date)] ⚠️ Snapshot script not found or not executable" >> "$LOG_FILE"
fi

VERSION=$(cat "$VERSION_FILE" 2>/dev/null || echo "unknown")
echo "[$(date)] 📌 Deployed version: $VERSION" >> "$LOG_FILE"

# Check if config changed and reload services if needed
CHANGED_FILES=$(git diff --name-only HEAD@{1} HEAD)
if echo "$CHANGED_FILES" | grep -E '\.php$|nginx|php.*\.conf' >/dev/null; then
  echo "[$(date)] 🔄 Config changed, reloading $PHP_SERVICE and $NGINX_SERVICE" >> "$LOG_FILE"
  systemctl reload "$PHP_SERVICE"
  systemctl reload "$NGINX_SERVICE"
else
  echo "[$(date)] 🟢 No service reload needed" >> "$LOG_FILE"
fi
