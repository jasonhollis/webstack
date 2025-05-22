#!/bin/bash
# Usage: failure.sh "Context/Script" "Message or details"
CONTEXT="$1"
DETAILS="$2"
LOG="/opt/webstack/logs/failures.log"
TS="$(date '+%Y-%m-%d %H:%M:%S %Z')"

PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="siren"

# Log to failures.log
echo "[$TS][$CONTEXT] $DETAILS" >> "$LOG"

# Send Pushover alert (subject to available creds)
if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack FAILURE: $CONTEXT" \
    -F "message=$DETAILS" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null
fi
