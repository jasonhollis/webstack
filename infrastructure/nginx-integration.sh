#!/bin/bash
# Helper script to integrate automation endpoints with existing nginx config

echo "=== NGINX INTEGRATION HELPER ==="
echo "This script will help you integrate automation endpoints with your existing nginx configuration"
echo ""

# Find existing nginx configurations
existing_configs=$(find /etc/nginx/sites-enabled -name "*.conf" -o -name "*default*" | head -5)

if [ -z "$existing_configs" ]; then
    echo "No existing nginx configurations found in sites-enabled"
    echo "You may need to manually add the automation endpoints to your nginx configuration"
    exit 1
fi

echo "Found existing nginx configurations:"
for config in $existing_configs; do
    echo "  - $config"
done

echo ""
echo "To integrate automation endpoints, add these location blocks to your main server block:"
echo ""
cat /etc/nginx/sites-available/ktp-automation | grep -A 20 "location /automation"
echo ""
echo "Would you like to automatically add these to your main site configuration? (y/N)"
read -r response

if [[ "$response" =~ ^[Yy]$ ]]; then
    main_config=$(echo "$existing_configs" | head -1)
    echo "Adding automation endpoints to: $main_config"
    
    # Backup the configuration
    cp "$main_config" "${main_config}.backup"
    
    # Add automation endpoints before the last closing brace
    sed -i '$i\\n    # KTP Digital Automation Endpoints\n    include /etc/nginx/sites-available/ktp-automation;' "$main_config"
    
    # Test nginx configuration
    if nginx -t; then
        echo "✅ nginx configuration updated successfully"
        echo "Reloading nginx..."
        systemctl reload nginx
    else
        echo "❌ nginx configuration test failed"
        echo "Restoring backup..."
        mv "${main_config}.backup" "$main_config"
        echo "Please manually integrate the automation endpoints"
    fi
else
    echo "Manual integration required. See /etc/nginx/sites-available/ktp-automation for reference"
fi
