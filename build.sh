#!/bin/bash

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Optimiser Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Créer le dossier de sortie
mkdir -p public/project

# Copier tous les fichiers du projet
cp -r app public/project/
cp -r bootstrap public/project/
cp -r config public/project/
cp -r database public/project/
cp -r resources public/project/
cp -r routes public/project/
cp -r storage public/project/
cp -r tests public/project/
cp -r vendor public/project/
cp -r public/css public/project/
cp -r public/js public/project/
cp -r public/img public/project/
cp -r public/fonts public/project/
cp -r public/scss public/project/
cp -r public/uploads public/project/
cp composer.json public/project/
cp composer.lock public/project/
cp package.json public/project/
cp package-lock.json public/project/
cp phpunit.xml public/project/
cp postcss.config.js public/project/
cp tailwind.config.js public/project/
cp vite.config.js public/project/
cp README.md public/project/
cp artisan public/project/
cp vercel.json public/project/
cp .env.example public/project/
cp .gitignore public/project/ 2>/dev/null || :
cp .env.production public/project/ 2>/dev/null || :

# Compiler les assets
npm install
npm run build