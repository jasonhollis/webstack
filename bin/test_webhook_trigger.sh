#!/bin/bash

WEBHOOK_URL="http://localhost:9000/hooks/webstack"

echo "🧪 Sending simulated webhook push payload to $WEBHOOK_URL..."

curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "hook": {
      "type": "Repository",
      "event": "push"
    },
    "repository": {
      "name": "webstack",
      "full_name": "jasonhollis/webstack"
    },
    "head_commit": {
      "message": "🧪 Simulated push from test script"
    }
  }'

echo -e "\n✅ Test POST sent. Check logs at /opt/webstack/logs/deploy_webhook.log"
