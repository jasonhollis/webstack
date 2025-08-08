#!/bin/bash
set -e

VERSION="${1:-$(cat /opt/webstack/html/VERSION || echo unknown)}"
TS=$(date +"%Y-%m-%d-%H%M%S")
SNAP="/opt/webstack/snapshots/webstack-${VERSION}-${TS}.zip"
# DO NOT MODIFY VERSION FILE - this is just creating a backup!

cd /opt/webstack

echo "[$(date)] 📦 Starting snapshot for version $VERSION..." >&2

# Create snapshot including all key content and configs, but excluding large files
zip -r "$SNAP" \
  html \
  bin \
  logs \
  objectives \
  assets \
  html/VERSION \
  /etc/nginx/nginx.conf \
  /etc/nginx/sites-available \
  -x "snapshots/*" "html/snapshots/*" "logs/*.gz" "logs/*old*" "logs/*.zip" \
  -x "*.mp4" "*.mov" "*.webm" "*.psd" \
  -x "objectives/images/*" "screenshots/*" > /dev/null

echo "[$(date)] 📦 Snapshot completed (excluded videos and screenshots)" >&2

echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")" >> /opt/webstack/logs/deploy.log
echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")"

# Clean logs (truncate all except deploy.log)
#find /opt/webstack/logs -type f ! -name 'deploy.log' -exec truncate -s 0 {} \;

exit 0

