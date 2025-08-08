#!/bin/bash
TITLE="${1:-Webstack Notification}"
MESSAGE="${2:-No details provided.}"
URL="${3:-}"

# Add connection timeout and max time to prevent hanging
curl -s \
  --connect-timeout 5 \
  --max-time 10 \
  --form-string "token=aqfyb8hsfb6txs6pd4qwchjwd3iccb" \
  --form-string "user=uh1ozrrcj8y5jktg5euc6yz6zpdcqh" \
  --form-string "title=$TITLE" \
  --form-string "message=$MESSAGE" \
  --form-string "url=$URL" \
  --form-string "url_title=View Details" \
  https://api.pushover.net/1/messages.json >/dev/null 2>&1 || true
