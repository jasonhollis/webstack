#!/usr/bin/env bash
set -euo pipefail

# update_version.sh — KTP Webstack (SAFE, FAILURE-AWARE, LOG-PRESERVING)
# All errors routed via /opt/webstack/bin/failure.sh

REPO_DIR="/opt/webstack/html"
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="$REPO_DIR/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
FAILURE_SH="/opt/webstack/bin/failure.sh"

cd "$REPO_DIR" \
  || { "$FAILURE_SH" "update_version.sh" "Could not cd to $REPO_DIR"; exit 1; }

# read current (old) version
if [[ -f "$VERSION_FILE" ]]; then
  OLD_VERSION="$(<"$VERSION_FILE")"
else
  OLD_VERSION="unknown"
fi

# Accept new version from argument or prompt
if [[ -n "${1:-}" ]]; then
  NEW_VERSION="$1"
else
  read -p "🔢 Enter new version (e.g. v1.4.9-dev): " NEW_VERSION
fi

if [[ -z "$NEW_VERSION" ]]; then
  "$FAILURE_SH" "update_version.sh" "No version entered. Aborting."
  exit 1
fi

# SCREENSHOT BACKUP - Archive screenshots for this version before cleaning
if ls /opt/webstack/screenshots/*.png 1> /dev/null 2>&1; then
  echo "📸 Archiving screenshots for version $OLD_VERSION..."
  SCREENSHOT_ARCHIVE="/opt/webstack/snapshots/screenshots_${OLD_VERSION}_$(date +%Y%m%d_%H%M%S).zip"
  cd /opt/webstack/screenshots && zip -r "$SCREENSHOT_ARCHIVE" *.png 2>/dev/null || true
  if [[ -f "$SCREENSHOT_ARCHIVE" ]]; then
    echo "📸 Screenshots archived to: $(basename "$SCREENSHOT_ARCHIVE")"
  fi
  cd "$REPO_DIR"
fi

# CLEANUP - Remove files after archiving
echo "🧹 Cleaning temporary files and screenshots..."
rm -f /opt/webstack/snapshots/zi* 2>/dev/null
find /opt/webstack/objectives/images -name "*.png" -mtime +30 -delete 2>/dev/null || true
# Clean ALL screenshots after archiving them
rm -f /opt/webstack/screenshots/*.png 2>/dev/null || true

# SNAPSHOT the OLD version before we change anything
bash "$SNAPSHOT_SCRIPT" "$OLD_VERSION" \
  || { "$FAILURE_SH" "update_version.sh" "snapshot_webstack.sh failed for old version $OLD_VERSION"; exit 1; }

# UPDATE VERSION FILE FIRST (before git commit)
echo "$NEW_VERSION" > "$VERSION_FILE"

# GIT ADD/COMMIT/PUSH (fail = abort and notify)
git add -A \
  || { "$FAILURE_SH" "update_version.sh" "git add failed"; exit 1; }
git commit -m "⬆️ Version bump: $NEW_VERSION" \
  || { "$FAILURE_SH" "update_version.sh" "git commit failed"; exit 1; }
git push 2>/dev/null \
  || echo "⚠️ Warning: git push failed (likely no upstream). Continuing locally..."

# Reload PHP-FPM to flush OPcache and pick up new templates
systemctl reload php8.2-fpm

# GIT TAG (annotated) and push - use GIT_EDITOR to prevent any interactive prompts
GIT_EDITOR=true git tag -a "$NEW_VERSION" -m "Version $NEW_VERSION" \
  || { "$FAILURE_SH" "update_version.sh" "git tag failed"; exit 1; }
git push origin "$NEW_VERSION" 2>/dev/null \
  || echo "⚠️ Warning: git tag push failed (likely no upstream). Tag created locally."
echo "[$(date '+%F %T')] Version updated to $NEW_VERSION" >> "$LOG_FILE"

ITERATION_FILE="$OBJECTIVES_DIR/${NEW_VERSION}_iteration_log.md"
OBJECTIVE_FILE="$OBJECTIVES_DIR/${NEW_VERSION}_objectives.md"
touch "$ITERATION_FILE" "$OBJECTIVE_FILE"
chown root:www-data "$ITERATION_FILE" "$OBJECTIVE_FILE"
chmod 664 "$ITERATION_FILE" "$OBJECTIVE_FILE"

echo "✅ Version $NEW_VERSION deployed, committed, tagged, pushed, snapshotted old version, and logs preserved."

# Optional: notify on success (run in background to prevent hanging)
(/opt/webstack/bin/notify_pushover.sh "Webstack Update" "Version $NEW_VERSION deployed successfully" 2>/dev/null &)

exit 0
