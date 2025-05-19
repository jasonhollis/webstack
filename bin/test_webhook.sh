#!/bin/bash

URL="http://localhost:9000"
LOG="/opt/webstack/logs/webhook_test.log"

echo "[`date`] 🔁 Sending test POST to \$URL" | tee -a "\$LOG"

curl -s -X POST "\$URL" -d '{}' -w "\n[HTTP %{http_code}]\n" | tee -a "\$LOG"

echo "[`date`] ✅ Test complete" | tee -a "\$LOG"
