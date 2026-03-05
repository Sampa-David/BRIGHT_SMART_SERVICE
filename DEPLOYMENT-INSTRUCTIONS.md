# 🚀 Instructions de déploiement par plateforme

## Railway

### 1. Ajouter des variables d'environnement
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app  # Remplacez par votre URL
ASSET_URL=https://your-app.railway.app
```

### 2. Mettre à jour `railway.toml`
```toml
[build]
builder = "nixpacks"

[build.nixpacks]
providers = ["node", "python", "php"]

[deploy]
startCommand = "php artisan migrate --force && php artisan serve --host=0.0.0.0"

[env]
buildCommand = "npm install && npm run build && composer install --no-dev"
```

### 3. Vérifier les logs
```bash
railway logs
```

---

## Vercel

### 1. Créer `vercel.json`
```json
{
  "buildCommand": "npm ci && npm run build && composer install --no-dev --optimize-autoloader",
  "env": {
    "APP_ENV": "production",
    "APP_DEBUG": "false",
    "APP_KEY": "@APP_KEY"
  },
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.6.1"
    }
  },
  "routes": [
    {
      "src": "/robots.txt",
      "dest": "/public/robots.txt"
    },
    {
      "src": "/build/(.*)",
      "dest": "/public/build/$1"
    },
    {
      "src": "/(.*)",
      "dest": "/api/index.php"
    }
  ]
}
```

### 2. Environnement variable dans Vercel Dashboard
- Allez à Settings → Environment Variables
- Ajouter `APP_KEY` (la même que votre `.env`)
- Ajouter `APP_URL=https://your-domain.vercel.app`

### 3. Déployer
```bash
vercel deploy
```

---

## Render.com

### 1. Créer `render.yaml`
```yaml
services:
  - type: web
    name: bright-smart-service
    env: php
    plan: starter
    preDeployCommand: "npm install && npm run build && composer install --no-dev && php artisan config:cache && php artisan route:cache"
    startCommand: "php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 8080"
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: "false"
      - key: APP_KEY
        sync: false
      - key: APP_URL
        fromService:
          type: web
          property: host
          prefix: "https://"
```

---

## Git & Hosting traditionnel (Cpanel, etc.)

### Votre plateforme utilise Git ?

#### Option A : Compiler localement et pusher
```bash
# Localement
npm run build
git add public/build/
git commit -m "Build assets for production"
git push origin main
```

#### Option B : Compiler sur le serveur
```bash
# Via SSH sur votre serveur
cd /home/yourapp
git pull origin main
npm install
npm run build
composer install --no-dev
php artisan optimize
```

---

## ✅ Vérification post-déploiement

```bash
# SSH vers votre serveur
ssh user@yourserver

# Vérifiez que public/build/ existe
ls -la public/build/

# Vérifiez que manifest.json existe
cat public/build/manifest.json

# Si les assets manquent, compilez-les
npm run build

# Vérifiez les permissions
chmod -R 755 public/build/
chmod -R 755 storage/

# Vérifiez que les migrations sont appliquées
php artisan migrate --force
```

---

## 📊 Les fichiers importants à vérifier

### 1. Dans le terminal, vérifiez que npm/node est installé
```bash
node -v   # v18.0.0+
npm -v    # v8.0.0+
```

### 2. Vérifiez qu'après déploiement:
```bash
# Le manifest.json existe
ls public/build/manifest.json

# Les assets CSS/JS sont compilés
ls public/build/assets/
```

### 3. Si rien ne s'affiche:
```bash
# Supprimez le build actuel
rm -rf public/build/

# Recompilez
npm run build

# Vérifiez le output
ls public/build/
```

---

## 🔐 Sécurité en production

```bash
# Masquer debug mode
APP_DEBUG=false

# Force HTTPS 
APP_URL=https://yoursite.com  # Pas http://

# Cache les routes et config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🆘 Troubleshooting

| Problème | Solution |
|----------|----------|
| "CSS/JS ne charge pas" | `npm run build` + redéployer |
| "404 sur les assets" | Vérifier que `public/build/` existe |
| "Styles en dev mais pas en prod" | Compiler avec `npm run build` |
| "Les scripts jQuery ne marchent pas" | Vérifier `resources/js/app.js` importe jQuery |
| "Trop d'espace disque" | Supprimer `node_modules` après build (composer install --no-dev) |

