#!/usr/bin/env bash
set -euo pipefail

ICON_DIR="/opt/webstack/html/images/icons"
PAGE_URL="https://www.ktp.digital/landing.php"
FAILURE_SH="/opt/webstack/bin/failure.sh"

for slug in sony_bravia_tv zigbee2mqtt; do
  local_name="${slug//_/-}"
  fetched=false

  for dir in "$slug" "$local_name"; do
    for ext in png svg; do
      url="https://raw.githubusercontent.com/home-assistant/brands/master/custom_integrations/${dir}/logo.${ext}"
      echo "Trying $url"
      if curl -sSfL "$url" -o "$ICON_DIR/${local_name}.${ext}"; then
        echo "✅ Fetched ${local_name}.${ext}"
        fetched=true
        break 2
      else
        echo "not found (exit $?)"
      fi
    done
  done

  if ! $fetched; then
    echo "❌ logo not found for $slug"
    "$FAILURE_SH" fetch_extra_icons.sh "Could not fetch any logo for $slug"
  fi
done

# verification
ls -l "$ICON_DIR"/{sony-bravia-tv,zigbee2mqtt}.* || true

# confirm landing page picks them up
curl -sSL "$PAGE_URL" \
  | grep -E 'images/icons/(sony-bravia-tv|zigbee2mqtt)' \
  || "$FAILURE_SH" fetch_extra_icons.sh "Landing page did not reference new icons"
