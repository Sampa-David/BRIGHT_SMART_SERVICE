# Guide Complet : CSS/JS en Production

## ✅ Checklist de déploiement

### Phase 1 : Préparation locale
- [ ] Exécuter `npm run build` pour compiler tous les assets
- [ ] Vérifier que le dossier `public/build/` est créé
- [ ] Vérifier que `public/build/manifest.json` existe
- [ ] Tester localement que les styles CSS/JS fonctionnent

### Phase 2 : Configuration de production
- [ ] S'assurer que `.env.production` contient `APP_ENV=production`
- [ ] Vérifier que `APP_DEBUG=false` en production
- [ ] S'assurer que `APP_URL` est correctement défini (avec https://)

### Phase 3 : Déploiement
- [ ] Inclure le dossier `public/build/` dans votre déploiement
  - ⚠️ **Important**: Ne pas ignorer ce dossier !
- [ ] Inclure `node_modules/` ET `package-lock.json` OU utiliser `npm ci --production` en production
- [ ] Exécuter les commandes de cache Laravel en production

### Phase 4 : Vérification post-déploiement
- [ ] Vérifier dans DevTools (F12) que les CSS/JS sont chargés (onglet Network)
- [ ] Vérifier qu'aucune erreur 404 n'apparaît pour les assets
- [ ] Tester les fonctionnalités JavaScript (formulaires, animations, etc.)

---

## 🔧 Configuration automatique en production

### Commandes à exécuter au déploiement
```bash
# Installer les dépendances Node
npm install

# Compiler les assets pour production
npm run build

# Installer les dépendances PHP
composer install --no-dev

# Générer la clé d'application
php artisan key:generate

# Mettre en cache la configuration
php artisan config:cache

# Mettre en cache les routes 
php artisan route:cache

# Mettre en cache les vues
php artisan view:cache

# Migrer la base de données
php artisan migrate --force
```

---

## 📁 Structure des fichiers attendue

```
public/
├── build/                    ✅ Créé par: npm run build
│   ├── manifest.json         ✅ Obligatoire en production
│   ├── assets/
│   │   ├── *.css
│   │   ├── *.js
│   │   └── ...
│   └── ...
├── css/                      ✅ CSS statique (Bootstrap, etc.)
├── js/                       ✅ JS statique manuel
└── ...
```

---

## 🚀 Distribution des assets par plateforme

### Railway / Render
```yaml
# railway.toml or render.yaml
build:
  command: npm install && npm run build && composer install
start:
  command: php artisan migrate --force && php artisan serve
```

### Vercel
```json
{
  "buildCommand": "npm run build && composer install",
  "outputDirectory": "public"
}
```

### GitHub Pages / Static Hosting
```bash
# Générer les assets
npm run build
# Copier le dossier public/build/
```

---

## 🔍 Dépannage

### Les CSS/JS ne s'affichent pas en production
**Vérifier:**
1. ✅ Le dossier `public/build/` existe
2. ✅ Le fichier `public/build/manifest.json` existe et contient les assets
3. ✅ `APP_ENV=production` dans `.env`
4. ✅ `APP_DEBUG=false` en production

### Erreur 404 sur les assets
**Raison la plus courante:** Les assets n'ont pas été compilés
```bash
npm run build
```

### Styles/Scripts ne se chargent que parfois
**Cause probable:** Cache navigateur ou cache Laravel
```bash
# Vider le cache Laravel
php artisan cache:clear
php artisan view:clear

# Dans le navigateur: Vide le cache et recharge (Ctrl+Shift+Delete ou Cmd+Shift+Delete)
```

### Les styles Tailwind ne s'appliquent pas
**Raison:** Configuration Tailwind n'inclut pas tous les fichiers
```javascript
// tailwind.config.js - Vérifier que content inclut:
content: [
  './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  './storage/framework/views/*.php',
  './resources/views/**/*.blade.php',  // ✅ Tous les fichiers Blade
  './public/index.php',                 // ✅ Entry point
]
```

---

## 📋 .gitignore à vérifier

```bash
# ❌ NE PAS IGNORER CES DOSSIERS EN PRODUCTION:
# Ajouter des exceptions si nécessaire:

# .gitignore
node_modules/
# Mais inclure public/build/ !
!/public/build/
!/public/build/**
```

---

## 🔐 Variables d'environnement importantes

```bash
# .env.production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votresite.com  # ✅ Avec https
ASSET_URL=https://votresite.com  # ✅ Pour CDN si utilisé

# Autres
LOG_CHANNEL=single
CACHE_DRIVER=file
SESSION_DRIVER=cookie
```

---

## 💡 Optimisations

### Compression et minification (automatique avec Vite)
```bash
npm run build
# Vite minifie automatiquement CSS et JS en production
```

### Mise en cache des assets
```php
// Dans vos headers (nginx, Apache, etc.)
Cache-Control: public, max-age=31536000, immutable
```

### Chargement asynchrone des scripts
```blade
<!-- Dans votre layout -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!-- Vite gère automatiquement le chargement optimal -->
```

---

## 📞 Support

Si les styles/scripts ne s'affichent pas :
1. Vérifier la console du navigateur (F12 → Console)
2. Vérifier les erreurs réseau (F12 → Network)
3. Exécuter: `npm run build` et redéployer
4. Vider le cache: `php artisan cache:clear`
