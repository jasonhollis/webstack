#!/bin/bash
LOGFILE="/opt/webstack/logs/quickactions.log"
VERSION_FILE="/opt/webstack/html/VERSION"
OBJECTIVES_DIR="/opt/webstack/objectives"
DATE="$(date '+%Y-%m-%d %H:%M:%S')"
WHO="$(whoami)@$(hostname)"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
TITLE="Webstack Activity Log"

ENTRY="$(cat -)"

{
  echo "$DATE [activity] invoked by $WHO"
  echo "  RAW:  $ENTRY"
} >> "$LOGFILE"

if [[ -z "$ENTRY" ]]; then
  echo "$DATE [activity] EMPTY ENTRY, nothing written." >> "$LOGFILE"
  exit 0
fi

# Write to quickactions.log
echo "$DATE [append_activity] $WHO: $ENTRY" >> "$LOGFILE"

# Also write to current iteration log!
VERSION=$(cat "$VERSION_FILE")
ITERATION_LOG="${OBJECTIVES_DIR}/${VERSION}_iteration_log.md"
echo -e "\n---\n#### [$DATE][$VERSION]\n$ENTRY\n" >> "$ITERATION_LOG"
chown root:www-data "$ITERATION_LOG" 2>/dev/null
chmod 664 "$ITERATION_LOG" 2>/dev/null

# Send pushover as before
curl -s \
  -F "token=$PUSHOVER_TOKEN" \
  -F "user=$PUSHOVER_USER" \
  -F "title=$TITLE" \
  -F "message=[$DATE][$WHO] $ENTRY" \
  -F "priority=0" \
  https://api.pushover.net/1/messages.json >/dev/null 2>&1
