#!/bin/bash
LOG_DIR="/opt/webstack/objectives"
VERSION_FILE="/opt/webstack/html/VERSION"
FAILURE="/opt/webstack/bin/failure.sh"
VERSION=$(cat "$VERSION_FILE" 2>/dev/null)
TS=$(date "+%Y-%m-%d %H:%M:%S %Z")

IFS= read -r IMG

if [[ -z "$IMG" ]]; then
  $FAILURE "No image filename provided to add_image_to_iteration_log.sh"
  exit 1
fi

IMG=$(basename -- "$IMG")
LOGFILE="$LOG_DIR/${VERSION}_iteration_log.md"

if ! echo -e "\n---\n#### [$TS][$VERSION]\n![](/admin/objectives/images/$IMG)\n" >> "$LOGFILE"; then
  $FAILURE "Failed to write log entry" "$LOGFILE"
  exit 2
fi

if ! chown root:www-data "$LOGFILE" 2>/dev/null; then
  $FAILURE "Failed chown on $LOGFILE"
fi
if ! chmod 664 "$LOGFILE" 2>/dev/null; then
  $FAILURE "Failed chmod on $LOGFILE"
fi

PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"
if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="🖼️ Image added to Iteration Log [$VERSION]: $IMG"
  if ! curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Activity (Image)" \
    -F "message=$MSG" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null; then
    $FAILURE "Pushover notification failed for $IMG"
  fi
fi

echo "$(date '+%Y-%m-%d %H:%M:%S')" >> /opt/webstack/logs/quickactions.log
echo "IMAGE-LOG [$VERSION] $(whoami)@$(hostname): $IMG" >> /opt/webstack/logs/quickactions.log
