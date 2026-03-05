#!/bin/bash
# Production Build & Deploy Script
# Usage: ./deploy.sh

set -e  # Exit on error

echo "🚀 Starting production deployment..."

# Step 1: Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci --production

# Step 2: Build assets with Vite
echo "🏗️  Building assets with Vite..."
npm run build

# Step 3: Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Step 4: Generate app key if not exists
echo "🔑 Generating app key..."
php artisan key:generate --force || true

# Step 5: Clear previous caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Step 6: Cache configuration for performance
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 7: Run migrations
echo "📚 Running database migrations..."
php artisan migrate --force

echo "✅ Production deployment completed successfully!"
echo "📍 Your assets are ready in public/build/"
echo "🌍 CSS and JavaScript will now load correctly in production"
