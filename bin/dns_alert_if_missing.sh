#!/bin/bash

DOMAIN="www.ktp.digital"
NOTIFY_SCRIPT="/opt/webstack/bin/notify_pushover.sh"

IP=$(dig +short $DOMAIN | grep -Eo '([0-9]{1,3}\.){3}[0-9]{1,3}' | head -1)

if [[ -z "$IP" ]]; then
  $NOTIFY_SCRIPT "❌ ALERT: DNS for $DOMAIN is NOT resolving! Check immediately."
fi
