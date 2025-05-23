#!/bin/bash
# append_activity.sh: Append activity log entry, handle all errors via failure.sh, and push notification.
LOGFILE="/opt/webstack/logs/quickactions.log"
VERSION_FILE="/opt/webstack/html/VERSION"
OBJECTIVES_DIR="/opt/webstack/objectives"
FAILURE="/opt/webstack/bin/failure.sh"
PUSHOVER_USER="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
PUSHOVER_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
TITLE="Webstack Activity Log"
DATE="$(date '+%Y-%m-%d %H:%M:%S %Z')"
WHO="$(whoami)@$(hostname)"

ENTRY="$(cat -)"

# Always log invocation
{
  echo "$DATE [activity] invoked by $WHO"
  echo "  RAW:  $ENTRY"
} >> "$LOGFILE" || $FAILURE "Failed to write activity invocation" "$LOGFILE"

if [[ -z "$ENTRY" ]]; then
  $FAILURE "append_activity.sh called with empty input" "$LOGFILE"
  exit 1
fi

# Detect code-like input and wrap in triple backticks for Markdown
if grep -qE '(^<\?php|^#!/|function |def |class |import |^SELECT |{|};)' <<< "$ENTRY"; then
  ENTRY="```
$ENTRY
```"
fi

# Write to quickactions.log
echo "$DATE [append_activity] $WHO: $ENTRY" >> "$LOGFILE" || $FAILURE "Failed to write to $LOGFILE"

# Write to current iteration log
VERSION=$(cat "$VERSION_FILE" 2>/dev/null)
ITERATION_LOG="${OBJECTIVES_DIR}/${VERSION}_iteration_log.md"
if ! echo -e "\n---\n#### [$DATE][$VERSION]\n$ENTRY\n" >> "$ITERATION_LOG"; then
  $FAILURE "Failed to write to iteration log" "$ITERATION_LOG"
  exit 2
fi

if ! chown root:www-data "$ITERATION_LOG" 2>/dev/null; then
  $FAILURE "Failed chown on $ITERATION_LOG"
fi
if ! chmod 664 "$ITERATION_LOG" 2>/dev/null; then
  $FAILURE "Failed chmod on $ITERATION_LOG"
fi

if [[ -n "$PUSHOVER_USER" && -n "$PUSHOVER_TOKEN" ]]; then
  MSG="[$DATE][$WHO] $ENTRY"
  if ! curl -s \
    -F "token=$PUSHOVER_TOKEN" \
    -F "user=$PUSHOVER_USER" \
    -F "title=$TITLE" \
    -F "message=$MSG" \
    -F "priority=0" \
    https://api.pushover.net/1/messages.json >/dev/null; then
    $FAILURE "Pushover notification failed for activity entry"
  fi
fi
