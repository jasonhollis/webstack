#!/bin/bash
OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="/opt/webstack/html/VERSION"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"

if [[ -z "$1" ]]; then
  echo "Usage: $0 \"Objective entry text\""
  exit 1
fi

OBJECTIVE="$1"
VERSION=$(cat "$VERSION_FILE")
TIMESTAMP=$(TZ="Australia/Sydney" date +"%Y-%m-%d %H:%M:%S %Z")
OBJECTIVE_FILE="$OBJECTIVES_DIR/${VERSION}_objectives.md"

ENTRY="---
#### [$TIMESTAMP][$VERSION]
$OBJECTIVE
"

echo "$ENTRY" >> "$OBJECTIVE_FILE"
echo "✅ Objective appended to: $OBJECTIVE_FILE"

# Pushover notification
if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="🎯 Objective Added [$VERSION]: $OBJECTIVE"
  curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Objective" \
    -F "message=$MSG" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null
fi
echo "$(date '+%Y-%m-%d %H:%M:%S')" >> /opt/webstack/logs/quickactions.log
echo "OBJECTIVE [$VERSION] $(whoami)@$(hostname): $OBJECTIVE" >> /opt/webstack/logs/quickactions.log
