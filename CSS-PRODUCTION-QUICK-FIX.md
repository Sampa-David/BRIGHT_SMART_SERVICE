# 🎯 Résumé rapide : CSS en production

## Le problème
Vos styles CSS et scripts JavaScript **ne s'affichent pas correctement en production** alors qu'ils fonctionnent parfaitement en développement.

## La cause racine
En production, **les assets doivent être compilés et minifiés** avec Vite, mais le dossier `public/build/` (où sont stockés les assets compilés) n'existe pas sur votre serveur de production.

## La solution en 3 étapes

### 1️⃣ Compiler les assets localement
```bash
npm run build
```
→ Crée le dossier `public/build/` avec les CSS/JS compilés

### 2️⃣ Ou compiler automatiquement en production
Assurez-vous que votre commande de déploiement inclut:
```bash
npm run build
```

### 3️⃣ Vérifier que les assets sont chargés
Dans votre navigateur (F12 → Network), vous devriez voir:
```
✅ GET public/build/manifest.json
✅ GET public/build/assets/app-xxxxx.css
✅ GET public/build/assets/app-xxxxx.js
```

## Commandes essentielles

```bash
# Développement
npm run dev      # Lance le serveur Vite en hot-reload

# Production
npm run build    # Compile et minifie tous les assets
```

## Files de configuration modifiés

| Fichier | Changement |
|---------|-----------|
| ✅ `app/Providers/AppServiceProvider.php` | Meilleure gestion des assets |
| ✅ `vite.config.js` | Configuration optimisée pour production |
| ✅ `resources/views/layouts/app.blade.php` | Utilise `@vite()` correctement |
| ✅ `resources/views/layouts/guest.blade.php` | Utilise `@vite()` correctement |

## Checklist avant déploiement

- [ ] `npm run build` exécuté ✅
- [ ] Dossier `public/build/` créé ✅
- [ ] Fichier `public/build/manifest.json` existe ✅
- [ ] `APP_ENV=production` dans `.env.production` ✅
- [ ] `APP_DEBUG=false` en production ✅
- [ ] Fichier `.gitignore` n'ignore pas `public/build/` en prod ✅

## Selon votre plateforme

### 🚂 Railway
Ajouter dans `railway.toml`:
```toml
[build]
buildCommand = "npm install && npm run build && composer install --no-dev"
```

### 🌍 Vercel
Votre `vercel.json` doit contenir:
```json
"buildCommand": "npm ci && npm run build && composer install --no-dev"
```

### 🎨 Render.com
```yaml
preDeployCommand: "npm install && npm run build && composer install --no-dev"
```

## Vérification rapide

### Local
```bash
npm run build
ls public/build/       # Doit afficher des dossiers et fichiers
cat public/build/manifest.json  # Doit être un JSON valide
```

### En production
```bash
php artisan tinker
> dd(array_keys(json_decode(file_get_contents('public/build/manifest.json'), true)));
```

## Besoin d'aide ?

Consultez:
- [PRODUCTION-CSS-JS-GUIDE.md](./PRODUCTION-CSS-JS-GUIDE.md) - Guide complet avec troubleshooting
- [DEPLOYMENT-INSTRUCTIONS.md](./DEPLOYMENT-INSTRUCTIONS.md) - Instructions par plateforme
