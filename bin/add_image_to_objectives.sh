#!/bin/bash
# Usage: add_image_to_objectives.sh <image_filename>
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="/opt/webstack/html/VERSION"
IMG="$1"
VERSION=$(cat "$VERSION_FILE")
TS=$(date "+%Y-%m-%d %H:%M:%S %Z")

if [[ -z "$IMG" ]]; then
  echo "Usage: $0 <image_filename>"
  exit 1
fi

OBJECTIVES="$OBJECTIVES_DIR/${VERSION}_objectives.md"

echo -e "\n---\n#### [$TS][$VERSION]\n![](/admin/objectives/images/$IMG)\n" >> "$OBJECTIVES"
chown root:www-data "$OBJECTIVES" 2>/dev/null
chmod 664 "$OBJECTIVES" 2>/dev/null

# Optional pushover notification
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"
if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="🖼️ Image added to Objectives [$VERSION]: $IMG"
  curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Objective (Image)" \
    -F "message=$MSG" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null
fi
echo "$(date '+%Y-%m-%d %H:%M:%S')" >> /opt/webstack/logs/quickactions.log
echo "IMAGE-OBJECTIVE [$VERSION] $(whoami)@$(hostname): $IMG" >> /opt/webstack/logs/quickactions.log
