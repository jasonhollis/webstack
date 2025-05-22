#!/bin/bash
# append_objective.sh: Accepts objective entry from stdin OR as first argument, logs with universal error handling.

OBJECTIVES_DIR="/opt/webstack/objectives"
VERSION_FILE="/opt/webstack/html/VERSION"
FAILURE="/opt/webstack/bin/failure.sh"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
SOUND="alien"
TS=$(TZ="Australia/Sydney" date +"%Y-%m-%d %H:%M:%S %Z")
VERSION=$(cat "$VERSION_FILE" 2>/dev/null)

# Read from stdin if data exists, else from $1
if [ -t 0 ]; then
  OBJECTIVE="$1"
else
  OBJECTIVE="$(cat -)"
fi

if [[ -z "$OBJECTIVE" ]]; then
  $FAILURE "append_objective.sh called with no input"
  exit 1
fi

OBJECTIVE_FILE="$OBJECTIVES_DIR/${VERSION}_objectives.md"
ENTRY="---
#### [$TS][$VERSION]
$OBJECTIVE
"

if ! echo "$ENTRY" >> "$OBJECTIVE_FILE"; then
  $FAILURE "Failed to append objective" "$OBJECTIVE_FILE"
  exit 2
fi

if ! chown root:www-data "$OBJECTIVE_FILE" 2>/dev/null; then
  $FAILURE "Failed chown on $OBJECTIVE_FILE"
fi
if ! chmod 664 "$OBJECTIVE_FILE" 2>/dev/null; then
  $FAILURE "Failed chmod on $OBJECTIVE_FILE"
fi

if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="🎯 Objective Added [$VERSION]: $OBJECTIVE"
  if ! curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=Webstack Objective" \
    -F "message=$MSG" \
    -F "sound=$SOUND" \
    https://api.pushover.net/1/messages.json > /dev/null; then
    $FAILURE "Pushover notification failed for objective"
  fi
fi

echo "$(date '+%Y-%m-%d %H:%M:%S')" >> /opt/webstack/logs/quickactions.log
echo "OBJECTIVE [$VERSION] $(whoami)@$(hostname): $OBJECTIVE" >> /opt/webstack/logs/quickactions.log
