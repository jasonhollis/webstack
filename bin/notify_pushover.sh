#!/bin/bash

APP_TOKEN="aqfyb8hsfb6txs6pd4qwchjwd3iccb"
USER_KEY="uh1ozrrcj8y5jktg5euc6yz6zpdcqh"
MESSAGE="${1:-🚀 Webstack deployed successfully}"
TITLE="${2:-Webstack Auto Deploy}"
PRIORITY="${3:-1}"  # High priority
SOUND="Intro"       # Your Stones Satisfaction sound

curl -s \
  -F "token=$APP_TOKEN" \
  -F "user=$USER_KEY" \
  -F "title=$TITLE" \
  -F "message=$MESSAGE" \
  -F "priority=$PRIORITY" \
  -F "sound=$SOUND" \
  https://api.pushover.net/1/messages.json > /dev/null
