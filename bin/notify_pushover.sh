#!/bin/bash
TITLE="${1:-DNS Check}"
MESSAGE="${2:-No details provided.}"
URL="${3:-}"
curl -s \
  --form-string "token=aqfyb8hsfb6txs6pd4qwchjwd3iccb" \
  --form-string "user=uh1ozrrcj8y5jktg5euc6yz6zpdcqh" \
  --form-string "title=$TITLE" \
  --form-string "message=$MESSAGE" \
  --form-string "url=$URL" \
  --form-string "url_title=View DNS Changelog" \
  https://api.pushover.net/1/messages.json >/dev/null
