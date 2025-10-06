#!/bin/bash

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Optimiser Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compiler les vues
php artisan view:clear
mkdir -p public/views
cp -r resources/views/* public/views/

# Compiler les assets
npm install
npm run build