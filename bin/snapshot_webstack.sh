#!/bin/bash
set -e
VERSION="$1"
[ -z "$VERSION" ] && VERSION=$(cat /opt/webstack/html/VERSION || echo "unknown")
TS=$(date +"%Y-%m-%d-%H%M%S")
SNAP="/opt/webstack/snapshots/webstack-${VERSION}-${TS}.zip"
echo "$VERSION" > /opt/webstack/html/VERSION
cd /opt/webstack
zip -r "$SNAP" html logs VERSION > /dev/null
echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")" >> /opt/webstack/logs/deploy.log
echo "[$(date)] 📦 Snapshot created: $(basename "$SNAP")"
