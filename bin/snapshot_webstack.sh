#!/bin/bash
set -e

VERSION="${1:-$(cat /opt/webstack/html/VERSION || echo unknown)}"
TS=$(date +"%Y-%m-%d-%H%M%S")
SNAP="/opt/webstack/snapshots/webstack-${VERSION}-${TS}.zip"
echo "$VERSION" > /opt/webstack/html/VERSION

cd /opt/webstack

# Create snapshot including all key content and configs, but excluding snapshots dir and old logs
zip -r "$SNAP" \
  html \
  bin \
  logs \
  objectives \
  assets \
  html/VERSION \
  /etc/nginx/nginx.conf \
  /etc/nginx/sites-available \
  -x "snapshots/*" "html/snapshots/*" "logs/*.gz" "logs/*old*" "logs/*.zip" > /dev/null

echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")" >> /opt/webstack/logs/deploy.log
echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")"

# Clean logs (truncate all except deploy.log)
find /opt/webstack/logs -type f ! -name 'deploy.log' -exec truncate -s 0 {} \;

exit 0

