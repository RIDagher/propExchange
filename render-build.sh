#!/usr/bin/env bash

# Exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build frontend
npm install
npm run build