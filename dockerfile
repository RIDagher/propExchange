# # Use official PHP image with Apache
# FROM php:8.2-apache

# # Install required PHP extensions
# RUN apt-get update && apt-get install -y \
#     libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip git curl && \
#     docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# # Enable Apache rewrite module
# RUN a2enmod rewrite

# # Change Apache DocumentRoot to Laravel's public directory
# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# # Update Apache config to use new DocumentRoot
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# # Copy Laravel project into the container
# COPY . /var/www/html

# # Set working directory
# WORKDIR /var/www/html

# # Set correct permissions
# # Set correct permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Install PHP dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Expose port 80
# EXPOSE 80


## With vite

# Stage 1: Node - Build Vite assets
FROM node:18 as node

WORKDIR /app

# Install frontend dependencies
COPY package*.json ./
RUN npm ci

# Copy full project and build frontend
COPY . .
RUN npm run build


# Stage 2: PHP with Apache - Laravel app
FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip git curl && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache config to use new DocumentRoot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Copy project files (except node_modules) into final image
COPY . /var/www/html

# Copy built Vite assets from Node build stage
COPY --from=node /app/public/build /var/www/html/public/build

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js and build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build

# Expose port
EXPOSE 80
