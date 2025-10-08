#!/bin/bash

# Ensure PORT is set and is an integer
export PORT=${PORT:-8000}
PORT=$(($PORT + 0))  # Force integer conversion

# Initialize Laravel
php artisan key:generate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Start Laravel server
exec php artisan serve --host=0.0.0.0 --port=$PORT