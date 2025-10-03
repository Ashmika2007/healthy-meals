#!/bin/bash
# start.sh - Start Laravel on Apache

# Exit on error
set -e

# Ensure .env exists
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Set Laravel key
php /var/www/html/artisan key:generate --force

# Set permissions for storage and bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run migrations (optional, only if you want to auto-run)
# php /var/www/html/artisan migrate --force

# Start Apache in foreground
apache2-foreground
