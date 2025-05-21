#!/bin/bash
# Usage: add_image_to_objectives.sh <image_filename>
OBJECTIVES="/opt/webstack/objectives/v1.4.5-dev_objectives.md"
IMG="$1"
VERSION=$(cat /opt/webstack/html/VERSION)
TS=$(date "+%Y-%m-%d %H:%M:%S %Z")

if [[ -z "$IMG" ]]; then
  echo "Usage: $0 <image_filename>"
  exit 1
fi

echo -e "\n---\n#### [$TS][$VERSION]\n![](/admin/objectives/images/$IMG)\n" >> "$OBJECTIVES"
