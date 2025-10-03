#!/bin/bash
set -e

echo "🚀 Starting Laravel Deployment on Render..."

# Ensure the working directory is correct
cd /var/www/html

# Copy .env if it does not exist
if [ ! -f .env ]; then
    echo "⚙️ Copying .env.example to .env"
    cp .env.example .env
fi

# Optimize Laravel
echo "⚡ Running Laravel optimizations..."
php artisan key:generate --force
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Fix permissions
echo "🔑 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run migrations (optional)
# php artisan migrate --force

# Start Apache in foreground
echo "✅ Starting Apache..."
exec apache2-foreground
