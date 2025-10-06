# Documentation des Politiques RLS Supabase

## Vue d'ensemble
Ce document décrit les politiques Row Level Security (RLS) mises en place dans notre base de données Supabase.

## Tables et Politiques

### 1. Users
- SELECT : Admins peuvent tout voir, utilisateurs voient leur profil uniquement
- INSERT : Inscription publique avec rôle 'client' par défaut
- UPDATE : Utilisateurs peuvent modifier leur profil, admins peuvent tout modifier
- DELETE : Admins uniquement

### 2. Services
- SELECT : Public
- INSERT : Admins uniquement
- UPDATE : Admins uniquement
- DELETE : Admins uniquement

### 3. Service Requests
- SELECT : Utilisateurs voient leurs demandes, admins voient tout
- INSERT : Utilisateurs authentifiés uniquement
- UPDATE : 
  - Utilisateurs peuvent modifier leurs demandes (sauf status)
  - Admins peuvent tout modifier
- DELETE : Admins uniquement

### 4. Testimonials
- SELECT : Public
- INSERT : Utilisateurs authentifiés uniquement
- UPDATE : 
  - Utilisateurs peuvent modifier leurs témoignages non approuvés
  - Admins peuvent tout modifier
- DELETE : Admins uniquement

### 5. Team Members
- SELECT : Public
- INSERT : Admins uniquement
- UPDATE : Admins uniquement
- DELETE : Admins uniquement

### 6. Departments
- SELECT : Public
- INSERT : Admins uniquement
- UPDATE : Admins uniquement
- DELETE : Admins uniquement

### 7. Contacts
- SELECT : Utilisateurs voient leurs messages, admins voient tout
- INSERT : Public
- UPDATE : Admins uniquement
- DELETE : Admins uniquement

### 8. Roles
- SELECT : Admins uniquement
- INSERT : Superadmins uniquement
- UPDATE : Superadmins uniquement (sauf rôles système)
- DELETE : Superadmins uniquement (sauf rôles système)

## Tables Système (RLS Désactivé)
- migrations
- jobs
- failed_jobs
- job_batches
- cache
- cache_locks
- sessions
- password_reset_tokens

## Gestion des Rôles
- client : Utilisateur standard
- admin : Gestionnaire avec accès étendu
- superadmin : Accès complet à toutes les fonctionnalités

## Maintenance
Pour modifier les politiques :
1. Se connecter à Supabase
2. Aller dans Database > Policies
3. Sélectionner la table concernée
4. Modifier ou ajouter des politiques selon les besoins

## Tests
Les tests automatisés sont disponibles dans `tests/Feature/SupabaseRlsPoliciesTest.php`
Pour exécuter les tests : `php artisan test`