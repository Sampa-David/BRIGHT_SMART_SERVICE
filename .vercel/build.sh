#!/bin/bash

# Installation des dépendances Composer
composer install --no-dev --optimize-autoloader

# Génération de la clé d'application si nécessaire
php artisan key:generate --force

# Optimisations pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Construction des assets
npm ci
npm run build