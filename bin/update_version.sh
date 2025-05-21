#!/bin/bash
set -e

REPO_DIR="/opt/webstack/html"
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="$REPO_DIR/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"
CONFIG_BACKUP="/opt/webstack/config_backup"
LIVE_DOMAIN="www.ktp.digital"

CERT_DIR="/etc/letsencrypt/live/$LIVE_DOMAIN"
FULLCHAIN="$CERT_DIR/fullchain.pem"
PRIVKEY="$CERT_DIR/privkey.pem"
NGINX_CONF="/etc/nginx/sites-available/webstack.site"

# Accept version from argument or prompt
if [[ -n "$1" ]]; then
  NEW_VERSION="$1"
else
  read -p "🔢 Enter new version (e.g. v1.0.2): " NEW_VERSION
fi

if [[ -z "$NEW_VERSION" ]]; then
  echo "❌ No version entered. Aborting."
  exit 1
fi

echo "$NEW_VERSION" > "$VERSION_FILE"

mkdir -p "$CONFIG_BACKUP"
cd "$CONFIG_BACKUP"

# Copy configs and certs if present
if [[ -f "$FULLCHAIN" ]]; then
  cp "$FULLCHAIN" fullchain.pem
  echo "✅ Backed up fullchain.pem"
else
  echo "⚠️  fullchain.pem not found! ($FULLCHAIN)" | tee -a "$LOG_FILE"
fi

if [[ -f "$PRIVKEY" ]]; then
  cp "$PRIVKEY" privkey.pem
  echo "✅ Backed up privkey.pem"
else
  echo "⚠️  privkey.pem not found! ($PRIVKEY)" | tee -a "$LOG_FILE"
fi

if [[ -f "$NGINX_CONF" ]]; then
  cp "$NGINX_CONF" webstack.site
  echo "✅ Backed up nginx config"
else
  echo "⚠️  nginx config not found! ($NGINX_CONF)" | tee -a "$LOG_FILE"
fi

# Snapshot the codebase
"$SNAPSHOT_SCRIPT"

# Clear logs
find /opt/webstack/logs/ -type f -exec truncate -s 0 {} \;

cd "$REPO_DIR"
git add -A
git commit -m "⬆️ Version bump: $NEW_VERSION"
git push origin master

# Pushover notification (optional, can remove/comment out if not wanted)
if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Deployed" \
    -F "message=Version $NEW_VERSION deployed, config/certs backed up, logs cleared." \
    -F "priority=1" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json >/dev/null
fi

echo "✅ Version $NEW_VERSION deployed, pushed, config/certs backed up, logs cleared, and objectives file created!"

