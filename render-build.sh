#!/usr/bin/env bash

# Exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build frontend
npm install
npm run build

# Create storage directories if they don't exist
mkdir -p storage/app/public/property_images
mkdir -p public/storage

# Create storage link for production (Render)
php artisan storage:link --force

# Ensure proper permissions for storage
chmod -R 775 storage/app/public || true

# Clear and cache configs for production
php artisan config:cache
php artisan route:cache
php artisan view:cache