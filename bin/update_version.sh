#!/bin/bash

# update_version.sh — KTP Webstack (SAFE, FAILURE-AWARE, LOG-PRESERVING)
# All errors routed via /opt/webstack/bin/failure.sh

REPO_DIR="/opt/webstack/html"
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="$REPO_DIR/VERSION"
SNAPSHOT_SCRIPT="/opt/webstack/bin/snapshot_webstack.sh"
LOG_FILE="/opt/webstack/logs/deploy_webhook.log"
FAILURE_SH="/opt/webstack/bin/failure.sh"

cd "$REPO_DIR" || { "$FAILURE_SH" "update_version.sh" "Could not cd to $REPO_DIR"; exit 1; }

# Accept version from argument or prompt
if [[ -n "$1" ]]; then
  NEW_VERSION="$1"
else
  read -p "🔢 Enter new version (e.g. v1.4.9-dev): " NEW_VERSION
fi

if [[ -z "$NEW_VERSION" ]]; then
  "$FAILURE_SH" "update_version.sh" "No version entered. Aborting."
  exit 1
fi

# GIT ADD/COMMIT/PUSH (Fail = abort and notify)
git add -A || { "$FAILURE_SH" "update_version.sh" "git add failed"; exit 1; }
git commit -m "⬆️ Version bump: $NEW_VERSION" || { "$FAILURE_SH" "update_version.sh" "git commit failed"; exit 1; }
git push || { "$FAILURE_SH" "update_version.sh" "git push failed"; exit 1; }

# SNAPSHOT backup (Fail = abort and notify)
bash "$SNAPSHOT_SCRIPT" "$NEW_VERSION"
if [[ $? -ne 0 ]]; then
  "$FAILURE_SH" "update_version.sh" "snapshot_webstack.sh failed for $NEW_VERSION"
  exit 1
fi

# ONLY if both git+snapshot succeed, update VERSION & create new log files
echo "$NEW_VERSION" > "$VERSION_FILE"
echo "[$(date '+%F %T')] Version updated to $NEW_VERSION" >> "$LOG_FILE"

ITERATION_FILE="$OBJECTIVES_DIR/${NEW_VERSION}_iteration_log.md"
OBJECTIVE_FILE="$OBJECTIVES_DIR/${NEW_VERSION}_objectives.md"
touch "$ITERATION_FILE" "$OBJECTIVE_FILE"
chown root:www-data "$ITERATION_FILE" "$OBJECTIVE_FILE"
chmod 664 "$ITERATION_FILE" "$OBJECTIVE_FILE"

echo "✅ Version $NEW_VERSION deployed, committed, pushed, snapshotted, and logs preserved."

# Optionally, add a Pushover deploy success notification here if desired
# /opt/webstack/bin/notify_pushover.sh "Webstack updated to $NEW_VERSION"

exit 0
