#!/usr/bin/env bash
set -euo pipefail

# Paths
JSON_PATH="/opt/webstack/html/data/ha_integrations.json"
OUTPUT_DIR="/opt/webstack/html/images/icons"
LOG_DIR="/opt/webstack/logs"
LOG_FILE="$LOG_DIR/ha_icon_fetch_$(date +%Y%m%d-%H%M%S).log"
ICON_BASE="https://brands.home-assistant.io"

# Prepare directories
mkdir -p "$OUTPUT_DIR" "$LOG_DIR"

echo "Starting HA icon fetch at $(date)" | tee "$LOG_FILE"

# Fetch icons
jq -r '.[].domain' "$JSON_PATH" | sort -u | while read -r domain; do
  url="$ICON_BASE/$domain/icon.png"
  out="$OUTPUT_DIR/$domain.png"

  echo -n "Fetching $domain... " | tee -a "$LOG_FILE"
  if curl -sSfL "$url" -o "$out"; then
    echo "OK" | tee -a "$LOG_FILE"
  else
    echo "MISSING ($url)" | tee -a "$LOG_FILE"
    rm -f "$out"
  fi

done

echo "Fetch complete at $(date). Log written to $LOG_FILE" | tee -a "$LOG_FILE"
