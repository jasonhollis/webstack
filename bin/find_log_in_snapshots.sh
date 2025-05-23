#!/bin/bash

SNAPDIR="/opt/webstack/snapshots"
KEYLOGS=("access.log" "error.log")

# List ZIPs from newest to oldest
for ZIP in $(ls -1t "$SNAPDIR"/*.zip); do
    echo "Inspecting: $ZIP"
    # Get the list of files inside the ZIP that are logs/
    LOGFILES=$(unzip -Z1 "$ZIP" | grep "^logs/")
    for KEY in "${KEYLOGS[@]}"; do
        if echo "$LOGFILES" | grep -q "logs/$KEY"; then
            echo "FOUND: logs/$KEY in $ZIP"
            echo "-----"
            unzip -l "$ZIP" | grep "logs/$KEY"
            echo "-----"
            echo "First snapshot containing $KEY: $ZIP"
            exit 0
        fi
    done
done

echo "No snapshots found with any key logs."
exit 1
