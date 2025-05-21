#!/bin/bash

DOMAIN="www.ktp.digital"
EMAIL="jason@ktp.digital"

echo "📦 Installing Certbot and Nginx plugin..."
apt update && apt install -y certbot python3-certbot-nginx

echo "🔐 Requesting SSL certificate for $DOMAIN..."
certbot --nginx -d "$DOMAIN" --non-interactive --agree-tos --email "$EMAIL"

echo "🔁 Enabling automatic renewal..."
systemctl enable certbot.timer
systemctl start certbot.timer

echo "🔄 Reloading Nginx to apply HTTPS config..."
systemctl reload nginx

echo "✅ SSL setup complete! Visit: https://$DOMAIN"
