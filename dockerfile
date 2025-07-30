# Use official PHP image with Apache
FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip git curl && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache config to use new DocumentRoot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Copy Laravel project into the container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set correct permissions
# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Create the symbolic link for storage
RUN php artisan storage:link


# Expose port 80
EXPOSE 80


## With vite

# # Start from PHP with Apache
# FROM php:8.2-apache

# # Install required PHP and system extensions
# RUN apt-get update && apt-get install -y \
#     libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip git curl \
#     nodejs npm && \
#     docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# # Enable Apache rewrite module
# RUN a2enmod rewrite

# # Set Apache's document root to Laravel's public folder
# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# # Set working directory
# WORKDIR /var/www/html

# # Copy composer from composer image
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy all project files
# COPY . .

# # Install PHP dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Install Node dependencies and build frontend assets with Vite
# RUN npm install && npm run build

# # Set proper permissions for Laravel
# RUN chown -R www-data:www-data storage bootstrap/cache \
#     && chmod -R 775 storage bootstrap/cache

# # Clear & optimize Laravel caches
# RUN php artisan config:clear && \
#     php artisan route:clear && \
#     php artisan view:clear && \
#     php artisan optimize:clear

# # Expose Apache port
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]