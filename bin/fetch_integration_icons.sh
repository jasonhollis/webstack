#!/bin/bash
INPUT="/opt/webstack/html/data/integrations.json"
OUTPUT_DIR="/opt/webstack/html/images/icons/homeassistant"
LOG="/opt/webstack/logs/icon_fetch_$(date +%Y%m%d-%H%M%S).log"

mkdir -p "$OUTPUT_DIR"
mkdir -p "./logs"

jq -r '.[].domain' "$INPUT" | while read -r domain; do
    outfile="$OUTPUT_DIR/$domain.svg"
    url="https://brands.home-assistant.io/$domain/icon.svg"

    if [[ -f "$outfile" ]]; then
        echo "✔ Exists: $domain.svg" >> "$LOG"
        continue
    fi

    echo -n "⏳ Fetching: $domain.svg ... "
    curl -s --fail "$url" -o "$outfile"
    if [[ $? -eq 0 ]]; then
        echo "✅ OK" | tee -a "$LOG"
    else
        echo "❌ MISSING ($url)" | tee -a "$LOG"
        rm -f "$outfile"
    fi
done

echo "🎯 Done. Log written to $LOG"
