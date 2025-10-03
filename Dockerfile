# Step 1: Use official PHP image with Apache
FROM php:8.2-apache

# Step 2: Set working directory
WORKDIR /var/www/html

# Step 3: Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Step 4: Enable Apache mod_rewrite
RUN a2enmod rewrite

# Step 5: Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Step 6: Copy project files
COPY . .

# Step 7: Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 8: Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Step 9: Expose port
EXPOSE 80

# Step 10: Start Apache
CMD ["apache2-foreground"]
