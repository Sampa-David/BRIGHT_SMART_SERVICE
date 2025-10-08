#!/bin/bash
set -e

# Configurer le port
export PORT=${PORT:-8000}

# Attendre la base PostgreSQL (si utilisée)
if [ -n "$DATABASE_URL" ]; then
  echo "⏳ Waiting for PostgreSQL to be ready..."
  until php -r "try { new PDO(getenv('DATABASE_URL')); echo '✅ DB ready'; } catch(Exception \$e) { echo '.'; sleep(2); }"; do :; done
fi

# Préparer Laravel
echo "⚙️ Running Laravel setup..."
php artisan key:generate --force || true
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan migrate --force || true

# Démarrer le serveur Laravel
echo "🚀 Starting Laravel on port $PORT"
exec php artisan serve --host=0.0.0.0 --port=$PORT
