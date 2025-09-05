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

# Remove existing storage link if it exists
rm -rf public/storage

# Create storage link for production (Render)
php artisan storage:link --force

# Verify storage link was created
if [ ! -L "public/storage" ]; then
    echo "Warning: Storage link not created properly"
    # Fallback: create manual symlink
    ln -sf ../storage/app/public public/storage
fi

# Ensure proper permissions for storage
chmod -R 775 storage/app/public || true
chmod -R 755 public/storage || true

# Clear and cache configs for production
php artisan config:cache
php artisan route:cache
php artisan view:cache