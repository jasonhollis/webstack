#!/usr/bin/env bash
set -euo pipefail

# Paths
JSON_PATH="/opt/webstack/html/data/ha_integrations.json"
OUTPUT_DIR="/opt/webstack/html/images/icons"
LOG_DIR="/opt/webstack/logs"
LOG_FILE="$LOG_DIR/ha_icon_fetch_$(date +%Y%m%d-%H%M%S).log"
ICON_BASE="https://brands.home-assistant.io"
FAILURE_SH="/opt/webstack/bin/failure.sh"

# Domain → brand-slug overrides
declare -A brand_map=(
  [amazon_alexa]=alexa
  [homekit_bridge]=homekit
  [homekit_controller]=homekit
  [porsche_connect]=porscheconnect
  [sony_bravia_tv]=sony-bravia-tv
)

# Prepare dirs & log start
mkdir -p "$OUTPUT_DIR" "$LOG_DIR"
echo "Starting HA icon fetch at $(date)" | tee "$LOG_FILE"

# Verify JSON
echo "DEBUG: JSON_PATH=\"$JSON_PATH\"" | tee -a "$LOG_FILE"
if [[ ! -f "$JSON_PATH" ]]; then
  echo "ERROR: JSON file NOT found at $JSON_PATH" | tee -a "$LOG_FILE"
  "$FAILURE_SH" fetch_ha_icons.sh "JSON file missing at $JSON_PATH"
  exit 1
fi
echo "DEBUG: JSON file exists." | tee -a "$LOG_FILE"

# Iterate domains
jq -r '.[].domain' "$JSON_PATH" | sort -u | while IFS= read -r domain; do
  echo "=== Domain: $domain ===" | tee -a "$LOG_FILE"

  # Special-case zigbee2mqtt
  if [[ "$domain" == "zigbee2mqtt" ]]; then
    url="https://raw.githubusercontent.com/Koenkk/zigbee2mqtt/master/docs/images/logo.png"
    out="$OUTPUT_DIR/$domain.png"
    echo -n "  Fetching zigbee2mqtt icon... " | tee -a "$LOG_FILE"
    if curl -sSfL "$url" -o "$out"; then
      echo "OK" | tee -a "$LOG_FILE"
    else
      echo "FAIL (curl exit $?)" | tee -a "$LOG_FILE"
      "$FAILURE_SH" fetch_ha_icons.sh "Failed to fetch zigbee2mqtt icon from $url"
      rm -f "$out"
    fi
    continue
  fi

  # Determine slug
  slug="${brand_map[$domain]:-$domain}"
  echo "  Using slug '$slug'" | tee -a "$LOG_FILE"

  # Try SVG then PNG
  for ext in svg png; do
    url="$ICON_BASE/$slug/icon.$ext"
    out="$OUTPUT_DIR/$domain.$ext"
    echo -n "    Trying $ext at $url... " | tee -a "$LOG_FILE"
    if curl -sSfL "$url" -o "$out"; then
      echo "OK" | tee -a "$LOG_FILE"
      break
    else
      echo "not found (exit $?)" | tee -a "$LOG_FILE"
      rm -f "$out"
      # on final failure (i.e. png), notify
      [[ "$ext" == "png" ]] && \
        "$FAILURE_SH" fetch_ha_icons.sh "No icon for $domain (tried svg+png at $ICON_BASE/$slug)" 
    fi
  done
done

echo "Fetch complete at $(date). Log written to $LOG_FILE" | tee -a "$LOG_FILE"
