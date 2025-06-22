#!/usr/bin/env bash
set -euo pipefail

# Paths
JSON_PATH="/opt/webstack/html/data/ha_integrations.json"
OUTPUT_DIR="/opt/webstack/html/images/icons"
LOG_DIR="/opt/webstack/logs"
LOG_FILE="$LOG_DIR/ha_icon_fetch_$(date +%Y%m%d-%H%M%S).log"
ICON_BASE="https://brands.home-assistant.io"

# Domain → brand-slug overrides
declare -A brand_map=(
  [amazon_alexa]=alexa
  [homekit_bridge]=homekit
  [homekit_controller]=homekit
  [porsche_connect]=porscheconnect
  [sony_bravia_tv]=braviatv        # << changed from sony-bravia-tv
)

mkdir -p "$OUTPUT_DIR" "$LOG_DIR"
echo "Starting HA icon fetch at $(date)" | tee "$LOG_FILE"

echo "DEBUG: JSON_PATH=\"$JSON_PATH\"" | tee -a "$LOG_FILE"
if [[ ! -f "$JSON_PATH" ]]; then
  echo "ERROR: JSON file NOT found at $JSON_PATH" | tee -a "$LOG_FILE"
  /opt/webstack/bin/failure.sh "fetch_ha_icons.sh" "JSON not found"
  exit 1
fi
echo "DEBUG: JSON file exists." | tee -a "$LOG_FILE"

jq -r '.[].domain' "$JSON_PATH" | sort -u | while read -r domain; do
  echo "=== $domain ===" | tee -a "$LOG_FILE"

  if [[ "$domain" == "zigbee2mqtt" ]]; then
    echo -n "  Fetching zigbee2mqtt from its site... " | tee -a "$LOG_FILE"
    if curl -sSfL "https://www.zigbee2mqtt.io/logo.png" -o "$OUTPUT_DIR/$domain.png"; then
      echo "OK" | tee -a "$LOG_FILE"
    else
      echo "FAIL" | tee -a "$LOG_FILE"
      /opt/webstack/bin/failure.sh "fetch_ha_icons.sh" "zigbee2mqtt fetch failed"
    fi
    continue
  fi

  slug="${brand_map[$domain]:-$domain}"
  echo "  Using slug '$slug'" | tee -a "$LOG_FILE"
  fetched=false
  for ext in svg png; do
    url="$ICON_BASE/$slug/logo.$ext"
    echo -n "    Trying $url ... " | tee -a "$LOG_FILE"
    if curl -sSfL "$url" -o "$OUTPUT_DIR/$domain.$ext"; then
      echo "OK" | tee -a "$LOG_FILE"
      fetched=true
      break
    else
      echo "not found" | tee -a "$LOG_FILE"
      rm -f "$OUTPUT_DIR/$domain.$ext"
    fi
  done
  if ! $fetched; then
    /opt/webstack/bin/failure.sh "fetch_ha_icons.sh" "Failed icon for $domain"
  fi
done

echo "Fetch complete at $(date). Log written to $LOG_FILE" | tee -a "$LOG_FILE"
