#!/bin/bash
# Cache SSL certificate info for web reading

CACHE_FILE="/tmp/ssl_cert_info.txt"

# Get certificate info
certbot certificates 2>/dev/null | grep -A5 'Certificate Name: ww2.ktp.digital' > "$CACHE_FILE"

# Make it readable by everyone
chmod 644 "$CACHE_FILE"

echo "SSL info cached to $CACHE_FILE"