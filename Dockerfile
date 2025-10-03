# Set working dir to Laravel public
WORKDIR /var/www/html

# Copy everything
COPY . .

# Apache serves from public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Enable rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
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

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy existing application
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["/usr/local/bin/00-laravel-deploy.sh"]
