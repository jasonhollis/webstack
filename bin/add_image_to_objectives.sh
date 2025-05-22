#!/bin/bash
# add_image_to_objectives.sh: Append an image entry to objectives log with universal error handling and Pushover notification.
# Usage: echo "<image_filename>" | add_image_to_objectives.sh

OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="/opt/webstack/html/VERSION"
FAILURE="/opt/webstack/bin/failure.sh"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"
TS=$(date "+%Y-%m-%d %H:%M:%S %Z")
VERSION=$(cat "$VERSION_FILE" 2>/dev/null)
IFS= read -r IMG

if [[ -z "$IMG" ]]; then
  $FAILURE "No image filename provided to add_image_to_objectives.sh"
  exit 1
fi

IMG=$(basename -- "$IMG")
LOGFILE="$OBJECTIVES_DIR/${VERSION}_objectives.md"

if ! echo -e "\n---\n#### [$TS][$VERSION]\n![](/admin/objectives/images/$IMG)\n" >> "$LOGFILE"; then
  $FAILURE "Failed to write image entry" "$LOGFILE"
  exit 2
fi

if ! chown root:www-data "$LOGFILE" 2>/dev/null; then
  $FAILURE "Failed chown on $LOGFILE"
fi
if ! chmod 664 "$LOGFILE" 2>/dev/null; then
  $FAILURE "Failed chmod on $LOGFILE"
fi

if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="🖼️ Image added to Objectives [$VERSION]: $IMG"
  if ! curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Objective (Image)" \
    -F "message=$MSG" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null; then
    $FAILURE "Pushover notification failed for $IMG"
  fi
fi

echo "$(date '+%Y-%m-%d %H:%M:%S')" >> /opt/webstack/logs/quickactions.log
echo "IMAGE-OBJECTIVE [$VERSION] $(whoami)@$(hostname): $IMG" >> /opt/webstack/logs/quickactions.log
