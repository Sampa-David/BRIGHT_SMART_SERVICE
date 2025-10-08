#!/bin/bash
set -e
# Ensure PORT is set and is an integer
export PORT=${PORT:-8000}
if ! [[ "$PORT" =~ ^[0-9]+$ ]]; then
  echo "Error: PORT must be an integer."
  exit 1
fi

echo "✅ Starting Laravel on port $PORT...."

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