# Mixed Content Error Fixes - Documentation

## Problem Summary

Your HTTPS-deployed application was showing mixed content warnings/errors:
- Browser refused insecure stylesheets and scripts
- Forms were posting to HTTP endpoints instead of HTTPS
- Browser automatically upgraded some requests but blocked others

## Root Cause

When your Laravel application is deployed with HTTPS on Railway, Render, or similar platforms, the application was still generating HTTP URLs for forms, links, and asset references. This happens because:

1. **Default configuration used `http://localhost`** - The `APP_URL` environment variable defaults to `http://localhost`
2. **Middleware wasn't detecting HTTPS proxy headers** - Railway/Render pass HTTPS status through headers like `X-Forwarded-Proto`, but the app wasn't configured to trust these
3. **Database queries weren't force-routing through HTTPS** - URL generation helpers weren't forcing HTTPS in production

## Solutions Implemented

### 1. Updated Default Configuration (config/app.php)
- Changed default `APP_URL` from `http://localhost` to `https://localhost`
- Added `force_https` configuration flag that automatically enables in production

### 2. Created ForceHttpsUrl Middleware
- **File**: `app/Http/Middleware/ForceHttpsUrl.php`
- **Purpose**: Detects when your app is behind a proxy (Railway, Render, Cloudflare, AWS ELB) and properly processes forwarded headers
- **Action**: Sets the HTTPS flag correctly so Laravel knows it's on a secure connection
- **Location**: Global middleware (runs on every request)

### 3. Created RedirectHttpsUrl Middleware
- **File**: `app/Http/Middleware/RedirectHttpsUrl.php`
- **Purpose**: Redirects any HTTP requests to HTTPS in production
- **Location**: Web middleware group

### 4. Created TrustProxies Middleware
- **File**: `app/Http/Middleware/TrustProxies.php`
- **Purpose**: Explicitly trusts proxy headers from forwarding services
- **Headers trusted**: `X-Forwarded-For`, `X-Forwarded-Host`, `X-Forwarded-Proto`, `X-Forwarded-Port`, `X-Forwarded-AWS-ELB`

### 5. Updated AppServiceProvider (app/Providers/AppServiceProvider.php)
- Forces HTTPS URL scheme in production (already configured)
- `\URL::forceScheme('https')` ensures all generated URLs use HTTPS

### 6. Updated Nginx Configuration (nginx.conf)
- Added proper FastCGI parameters to pass HTTPS status from proxy headers
- Configured `fastcgi_param HTTPS $http_x_forwarded_proto`
- Passes all forwarded headers to PHP-FPM

### 7. Updated .env.example
- Changed default `APP_URL=http://localhost` to `APP_URL=https://localhost`
- Added new `APP_FORCE_HTTPS` configuration option

### 8. Created .env.production
- Template for production deployments on Railway/Render
- Includes all necessary HTTPS configuration
- Instructions for setting environment variables

## Deployment Instructions

### For Railway

1. **Set Environment Variables** in Railway Dashboard:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_FORCE_HTTPS=true
   APP_URL=https://your-app-name.railway.app
   APP_KEY=base64:YOUR_GENERATED_KEY
   ```

2. **Generate Application Key** (if not already set):
   ```bash
   php artisan key:generate
   ```

3. **Database Configuration** - Railway automatically provides `DATABASE_URL`, but ensure:
   - `DB_CONNECTION=pgsql`
   - `DB_HOST` points to Railway's PostgreSQL service
   - Use managed database provided by Railway

4. **Deploy** - Push your code with these changes

### For Render, Heroku, or Similar

1. **Set Config Vars**:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_FORCE_HTTPS=true`
   - `APP_URL=https://your-domain.onrender.com` (or your platform's domain)
   - `APP_KEY=base64:YOUR_GENERATED_KEY`

2. **Database**:
   - Use the platform's managed PostgreSQL
   - Ensure connection string includes SSL requirement

3. **Deploy** with the updated code

### For Local Development

No changes needed - app will use `https://localhost` and won't force redirects locally.

## How It Works

1. **Browser Request** → Arrives at your platform (Railway, Render, etc.)
2. **Platform Proxies** → Adds headers like `X-Forwarded-Proto: https`
3. **Nginx** → Passes these headers to PHP via FastCGI parameters
4. **ForceHttpsUrl Middleware** → Detects proxy headers and sets HTTPS flag
5. **Laravel** → Detects `$_SERVER['HTTPS'] = 'on'` and generates HTTPS URLs
6. **All Generated URLs** → Forms, links, routes now use `https://` prefix

## Troubleshooting

### Still seeing HTTP URLs?

1. **Check APP_URL**:
   ```php
   php artisan tinker
   > config('app.url')
   ```
   Should show your HTTPS domain.

2. **Check Environment**:
   ```php
   config('app.env') // Should be 'production'
   config('app.force_https') // Should be true in production
   ```

3. **Check Proxy Headers** in Laravel logs:
   ```php
   \Log::info('Request', [
       'secure' => request()->secure(),
       'x-forwarded-proto' => request()->header('X-Forwarded-Proto'),
   ]);
   ```

### Still getting mixed content warnings for external resources?

External CDNs (Google Fonts, Bootstrap CDN) might not support HTTPS:
- Verify they use `https://` links
- If they don't, either download locally or find HTTPS-compliant alternatives

### Forms still posting to HTTP?

Ensure all form actions use `{{ route('name') }}` helpers instead of hardcoded URLs:

❌ **BAD**:
```blade
<form action="http://example.com/services" method="POST">
```

✅ **GOOD**:
```blade
<form action="{{ route('services.store') }}" method="POST">
```

## Browser Cache

After deployment:
1. **Hard refresh** your browser (Ctrl+Shift+R or Cmd+Shift+R)
2. **Clear cache** (DevTools → Application → Clear Storage)
3. Test in an **incognito/private window**

## Security Benefits

✅ All communication is encrypted  
✅ No password/data transmitted over insecure channels  
✅ Prevents man-in-the-middle attacks  
✅ Improves SEO (Google ranks HTTPS higher)  
✅ Complies with security best practices  
✅ Satisfies PCI-DSS and GDPR requirements

## References

- [Laravel URL Generation](https://laravel.com/docs/11.x/urls#generating-urls)
- [Laravel HTTPS Configuration](https://laravel.com/docs/11.x/urls#forcing-https)
- [Railway Documentation](https://docs.railway.app/)
- [Mixed Content Explained](https://developer.mozilla.org/en-US/docs/Web/Security/Mixed_content)
