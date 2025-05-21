#!/bin/bash
set -euo pipefail

REPO_DIR="/opt/webstack/html"
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="$REPO_DIR/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
NOTIFY_SCRIPT="/opt/webstack/bin/notify_pushover.sh"
WEBSTACK_URL="https://www.ktp.digital/admin/maintenance.php"
SOUND="Intro"      # Stones Satisfaction Intro (custom Pushover sound)
PRIORITY=1         # High priority

# Accept version from argument or prompt, showing current version if prompting
if [[ -n "$1" ]]; then
  NEW_VERSION="$1"
else
  CUR_VERSION=$(cat "$VERSION_FILE" 2>/dev/null || echo "unknown")
  read -p "🔢 Enter new version (current: $CUR_VERSION): " NEW_VERSION
fi

if [[ -z "$NEW_VERSION" ]]; then
  echo "❌ No version entered. Aborting."
  exit 1
fi

# Create snapshot BEFORE updating version file, so snapshot always matches prior state
"$SNAPSHOT_SCRIPT" "$(cat "$VERSION_FILE")" >> "$LOG_FILE" 2>&1

# Now update version file and continue workflow
echo "$NEW_VERSION" > "$VERSION_FILE"
echo "[$(date)] ✍️  Version bumped to $NEW_VERSION" >> "$LOG_FILE"

cd "$REPO_DIR"

git add VERSION
git commit -m "⬆️ Version bump: $NEW_VERSION" || echo "No changes to commit."
git push origin master >> "$LOG_FILE" 2>&1

# ---- OBJECTIVES .md HANDLING ----
OBJECTIVES_MD="${OBJECTIVES_DIR}/${NEW_VERSION}_objectives.md"
TEMPLATE_MD="${OBJECTIVES_DIR}/PROJECT_OBJECTIVES.md"

if [[ -f "$TEMPLATE_MD" ]]; then
  cp "$TEMPLATE_MD" "$OBJECTIVES_MD"
  {
    echo ""
    echo "## Objectives & Changelog for $NEW_VERSION"
    echo "*Created: $(TZ='Australia/Melbourne' date '+%Y-%m-%d %H:%M:%S %Z')*"
    echo ""
    echo "---"
    echo ""
  } >> "$OBJECTIVES_MD"
else
  {
    echo "# Objectives & Changelog for $NEW_VERSION"
    echo "*Created: $(TZ='Australia/Melbourne' date '+%Y-%m-%d %H:%M:%S %Z')*"
    echo ""
    echo "---"
    echo ""
  } > "$OBJECTIVES_MD"
fi

echo "[$(date)] 📝 Created new objectives file: $OBJECTIVES_MD" >> "$LOG_FILE"

# --- PUSHOVER NOTIFICATION ---
DEPLOY_TIME="$(date '+%Y-%m-%d %H:%M:%S')"
"$NOTIFY_SCRIPT" \
  "📦 Version $NEW_VERSION deployed at $DEPLOY_TIME" \
  "Version Bump to $NEW_VERSION" \
  "$WEBSTACK_URL" \
  "View Snapshots" \
  "$SOUND" \
  "$PRIORITY" || echo "Warning: Pushover notification failed."

echo "✅ Version $NEW_VERSION deployed, pushed, and objectives file created!"
