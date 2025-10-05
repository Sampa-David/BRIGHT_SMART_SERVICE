#!/bin/bash

# Installation des dépendances
composer install --no-dev --optimize-autoloader

# Création de la structure de sortie Vercel
mkdir -p .vercel/output/functions/api
mkdir -p .vercel/output/static

# Copier tous les fichiers nécessaires pour le runtime PHP
cp -r app bootstrap config database lang resources routes storage vendor composer.json composer.lock artisan .env.example .vercel/output/functions/api/

# Copier le point d'entrée
cp api/index.php .vercel/output/functions/api/

# Copier les assets publics
cp -r public/* .vercel/output/static/

# Optimisations pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Construction des assets si nécessaire
if [ -f "package.json" ]; then
    npm ci
    npm run build
fi

# Configuration Vercel
echo '{"version":2}' > .vercel/output/config.json