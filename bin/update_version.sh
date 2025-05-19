#!/bin/bash

REPO_DIR="/opt/webstack/html"
VERSION_FILE="$REPO_DIR/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"

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
echo "[$(date)] ✍️  Version bumped to $NEW_VERSION" >> "$LOG_FILE"

"$SNAPSHOT_SCRIPT" "$NEW_VERSION" >> "$LOG_FILE" 2>&1

cd "$REPO_DIR" || {
  echo "❌ Cannot cd to repo: $REPO_DIR" >> "$LOG_FILE"
  exit 1
}

git add VERSION
git commit -m "⬆️ Version bump: $NEW_VERSION"
git push origin master >> "$LOG_FILE" 2>&1

# Send Pushover notification
curl -s \
  --form-string "token=$PUSHOVER_TOKEN" \
  --form-string "user=$PUSHOVER_USER" \
  --form-string "title=Webstack Deployed" \
  --form-string "message=📦 Version $NEW_VERSION deployed at $(date '+%H:%M:%S')" \
  --form-string "sound=$SOUND" \
  https://api.pushover.net/1/messages.json >/dev/null

echo "✅ Version $NEW_VERSION deployed and pushed!"
