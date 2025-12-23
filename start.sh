#!/bin/bash
set -e

# Configurer le port
export PORT=${PORT:-8000}

# Attendre MySQL si présent
if [ -n "$DB_HOST" ]; then
  echo "⏳ Waiting for MySQL to be ready..."
  until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch(Exception \$e) { echo '.'; sleep(2); }"; do :; done
  echo "✅ Database is ready"
fi

# Préparer Laravel
echo "⚙️ Running Laravel setup..."
php artisan key:generate --force || true
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan migrate --force || true

# Démarrer PHP-FPM et Nginx
echo "🚀 Starting PHP-FPM and Nginx on port $PORT"
service php8.2-fpm start
exec nginx -g 'daemon off;'
