#!/bin/bash

# Configuration de la base de données
echo "Configuration de la connexion à Supabase..."
php artisan config:clear

# Exécution des migrations
echo "Exécution des migrations..."
php artisan migrate:fresh --force --no-interaction

# Vérification du statut des migrations
echo "Vérification du statut des migrations..."
php artisan migrate:status