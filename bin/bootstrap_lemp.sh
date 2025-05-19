#!/bin/bash

echo "🌐 Updating system and installing LEMP stack..."

apt update && apt upgrade -y

# --- Core LEMP packages ---
apt install -y nginx mariadb-server php php-fpm php-mysql php-cli php-curl php-xml php-mbstring php-zip unzip curl

# --- Enable and start services ---
systemctl enable nginx mariadb php8.2-fpm
systemctl restart nginx mariadb php8.2-fpm

# --- Secure MariaDB ---
echo "🔒 Run the following manually for MariaDB hardening:"
echo "    mysql_secure_installation"

# --- Create directory structure ---
mkdir -p /opt/webstack/{bin,data,html,logs}

# --- Set permissions ---
chown -R www-data:www-data /opt/webstack/html

# --- Sample PHP page ---
cat << 'EOPHP' > /opt/webstack/html/index.php
<?php
phpinfo();
?>
EOPHP

# --- Nginx site config ---
cat << 'EONGINX' > /etc/nginx/sites-available/webstack
server {
    listen 80;
    server_name ww2.ktp.digital;

    root /opt/webstack/html;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }

    access_log /opt/webstack/logs/nginx_access.log;
    error_log /opt/webstack/logs/nginx_error.log;
}
EONGINX

# --- Enable site ---
ln -sf /etc/nginx/sites-available/webstack /etc/nginx/sites-enabled/webstack
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

echo "✅ LEMP stack installed."
echo "🌐 Visit: http://ww2.ktp.digital"
