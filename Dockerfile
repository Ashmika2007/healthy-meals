# Step 1: Use official PHP + Apache image
FROM php:8.2-apache

# Step 2: Install system dependencies and PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    && a2enmod rewrite

# Step 3: Set working directory
WORKDIR /var/www/html

# Step 4: Copy composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Step 5: Copy application files
COPY . .

# Step 6: Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Step 7: Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Step 8: Expose Apache port
EXPOSE 80

# Step 9: Start Apache
CMD ["apache2-foreground"]
