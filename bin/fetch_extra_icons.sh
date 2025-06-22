#!/usr/bin/env bash
set -euo pipefail

ICON_DIR="/opt/webstack/html/images/icons"
PAGE_URL="https://www.ktp.digital/landing.php"

for slug in sony_bravia_tv zigbee2mqtt; do
  local_name="${slug//_/-}"
  echo "=== EXTRA icon for $slug ==="

  # skip if already there
  if [[ -f "$ICON_DIR/$local_name.png" || -f "$ICON_DIR/$local_name.svg" ]]; then
    echo "  skip, have $local_name"
    continue
  fi

  if [[ "$slug" == "sony_bravia_tv" ]]; then
    fetched=false
    for dir in braviatv sony_bravia_tv sony-bravia-tv; do
      for ext in png svg; do
        url="https://raw.githubusercontent.com/home-assistant/brands/master/custom_integrations/$dir/logo.$ext"
        echo -n "  Trying $url ... "
        if curl -sSfL "$url" -o "$ICON_DIR/$local_name.$ext"; then
          echo "OK"
          fetched=true
          break 2
        else
          echo "not found"
          rm -f "$ICON_DIR/$local_name.$ext"
        fi
      done
    done
    if ! $fetched; then
      /opt/webstack/bin/failure.sh "fetch_extra_icons.sh" "sony_bravia_tv fetch failed"
    fi

  else
    fetched=false
    for ext in png svg; do
      url="https://www.zigbee2mqtt.io/logo.$ext"
      echo -n "  Fetching $url ... "
      if curl -sSfL "$url" -o "$ICON_DIR/$local_name.$ext"; then
        echo "OK"
        fetched=true
        break
      else
        echo "FAIL"
        rm -f "$ICON_DIR/$local_name.$ext"
      fi
    done
    if ! $fetched; then
      /opt/webstack/bin/failure.sh "fetch_extra_icons.sh" "zigbee2mqtt fetch failed"
    fi
  fi
done

ls -l "$ICON_DIR"/sony-bravia-tv.* "$ICON_DIR"/zigbee2mqtt.* 2>/dev/null
curl -sSL "$PAGE_URL" | grep -E 'images/icons/(sony-bravia-tv|zigbee2mqtt)'
