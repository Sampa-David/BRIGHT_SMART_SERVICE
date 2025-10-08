#!/bin/bash

# Wait for the environment to be ready
sleep 2

# Start PHP-FPM
php-fpm -D

# Generate application key if not set
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate key if not already set
php artisan key:generate --force

# Start nginx
nginx -g "daemon off;"