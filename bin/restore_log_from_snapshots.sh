#!/bin/bash

SNAPDIR="/opt/webstack/snapshots"
LOGDIR="/opt/webstack/logs"

if [ -z "$1" ]; then
    echo "Usage: $0 <logfile>   (e.g. access.log, error.log)"
    exit 1
fi

LOGFILE="$1"
TMP="/tmp/restore_${LOGFILE}_$$"

# Get all snapshot zips, newest first
mapfile -t SNAPSHOTS < <(ls -1t "$SNAPDIR"/*.zip)

if [ ${#SNAPSHOTS[@]} -eq 0 ]; then
    echo "No snapshot zips found."
    exit 1
fi

# 1. Restore from the latest snapshot (overwrite)
LATEST="${SNAPSHOTS[0]}"
echo "Restoring $LOGFILE from: $LATEST"
if ! unzip -p "$LATEST" "logs/$LOGFILE" > "$TMP" ; then
    echo "Log not found in latest snapshot."
    rm -f "$TMP"
    exit 2
fi

# 2. For the next 10 older snapshots, append if the log exists
for ZIP in "${SNAPSHOTS[@]:1:10}"; do
    if unzip -l "$ZIP" "logs/$LOGFILE" | grep -q "logs/$LOGFILE"; then
        echo "Appending $LOGFILE from: $ZIP"
        unzip -p "$ZIP" "logs/$LOGFILE" >> "$TMP"
    fi
done

# 3. Move combined file to logs directory
mv "$TMP" "$LOGDIR/$LOGFILE"
chmod 664 "$LOGDIR/$LOGFILE"
chown root:www-data "$LOGDIR/$LOGFILE"

echo "Restore/append complete: $LOGDIR/$LOGFILE"
exit 0
