#!/bin/bash

HTML_PATH="/opt/webstack/html/index.html"
LOG_PATH="/opt/webstack/logs/deploy_webhook.log"
MSG="🚀 Auto push: $(date)"

echo "<p>${MSG}</p>" >> "$HTML_PATH"

cd /opt/webstack/html || {
  echo "❌ Failed to cd to repo" >> "$LOG_PATH"
  exit 1
}

echo "[$(date)] ✍️  Committing update: $MSG" >> "$LOG_PATH"
git add index.html
git commit -m "$MSG"
git push origin master >> "$LOG_PATH" 2>&1 && \
echo "[$(date)] ✅ Push complete" >> "$LOG_PATH"
