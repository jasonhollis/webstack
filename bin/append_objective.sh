#!/bin/bash

OBJECTIVES_DIR="/opt/webstack/objectives"
CANONICAL_LOG="$OBJECTIVES_DIR/objectives.md"
VERSION_FILE="/opt/webstack/html/VERSION"

if [[ -z "$1" ]]; then
  echo "Usage: $0 \"Objective text here\""
  exit 1
fi

NEW_OBJECTIVE="$1"
VERSION=$(cat "$VERSION_FILE")
TIMESTAMP=$(TZ="Australia/Sydney" date +"%Y-%m-%d %H:%M:%S %Z")
PER_VERSION_FILE="$OBJECTIVES_DIR/${VERSION}_objectives.md"

ENTRY="---
#### [$TIMESTAMP][$VERSION]
$NEW_OBJECTIVE
"

echo "$ENTRY" >> "$CANONICAL_LOG"
echo "$ENTRY" >> "$PER_VERSION_FILE"

echo "✅ Objective appended to: $CANONICAL_LOG and $PER_VERSION_FILE"
