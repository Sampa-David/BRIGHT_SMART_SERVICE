#!/bin/bash

# Initialize Laravel
php artisan key:generate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm -D

# Start Nginx (and keep it in foreground)
nginx -g 'daemon off;'

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate key if not already set
php artisan key:generate --force

# Start nginx
nginx -g "daemon off;"