# Quick Start: Deploy to Railway with HTTPS

## Step 1: Prepare Your Application

```bash
# Generate application key (if you haven't already)
php artisan key:generate

# The key is now in your .env file
```

## Step 2: Commit Changes

```bash
git add .
git commit -m "Fix mixed content warnings - add HTTPS configuration"
git push
```

## Step 3: Railway Dashboard Configuration

1. Go to your Railway project dashboard
2. Click on your web service
3. Go to the "Variables" tab
4. **Remove or Comment Out**:
   - `APP_URL` if it was set to `http://...`

5. **Add These Variables**:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_FORCE_HTTPS=true
   APP_URL=https://[YOUR-RAILWAY-DOMAIN].railway.app
   ```

   Replace `[YOUR-RAILWAY-DOMAIN]` with your actual domain.

6. **Click "Add" for each variable**

## Step 4: Verify PostgreSQL Connection

In the "Variables" tab, you should see (Railway provides these automatically):
- `DATABASE_URL` or individual `DB_*` variables

If missing:
1. Click the PostgreSQL service
2. Copy the connection string
3. Set it in your web service variables

## Step 5: Deploy

Push your code again or redeploy from the Railway dashboard:

```bash
git push  # Triggers automatic redeploy
```

Or in Railway dashboard: Click the three dots → "Redeploy"

## Step 6: Verify HTTPS Works

1. Visit `https://your-domain.railway.app`
2. Open browser DevTools (F12)
3. Go to "Console" tab
4. Should see: ✅ No mixed content warnings
5. Check "Network" tab: All resources should show `https://`

## Step 7: Test Forms

1. Navigate to any form on your site
2. Right-click form → Inspect
3. Check `<form action="...">` attribute
4. Should show: `https://your-domain.railway.app/...`
5. **Not**: `http://...`

## Common Issues

### ❌ "Redirects too many times"
- **Cause**: APP_URL mismatch with actual domain
- **Fix**: Ensure APP_URL matches your Railway domain exactly
  ```
  ❌ Wrong: APP_URL=https://your-domain.com (but Railway gives you .railway.app)
  ✅ Right: APP_URL=https://your-app-12345.railway.app
  ```

### ❌ Still see mixed content warnings
- Clear browser cache (Ctrl+Shift+Delete)
- Hard refresh (Ctrl+Shift+R)
- Test in incognito window (Ctrl+Shift+N)

### ❌ Forms not redirecting
- Make sure `APP_ENV=production` is set
- Check that `APP_FORCE_HTTPS=true`
- Redeploy after changing variables

### ❌ Database connection errors
- Verify `DATABASE_URL` or `DB_*` variables are set
- Check PostgreSQL service is running
- Ensure DATABASE_URL includes SSL mode

## Maintenance

### Updating Your Domain

If you change your Railway domain:

1. Update `APP_URL` variable
2. Redeploy
3. Clear browser cache
4. Test in incognito window

### Updating Code

Just push to Git - Railway will auto-redeploy:
```bash
git push
# Automatic deployment starts
```

## Monitoring

1. Go to Railway dashboard → Logs
2. Filter for errors
3. Look for any "Mixed content" entries (should be gone)
4. Check application logs: `tail -f storage/logs/laravel.log`

## Success Indicators ✅

- [ ] No 401/403 errors on HTTPS domain
- [ ] No mixed content warnings in browser console
- [ ] All forms post to HTTPS endpoints
- [ ] All stylesheets load (green checkmark in Network tab)
- [ ] All scripts load
- [ ] Session/authentication works
- [ ] Database queries execute correctly

---

**Need Help?** See `docs/HTTPS-MIXED-CONTENT-FIX.md` for detailed troubleshooting.
