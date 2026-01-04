# Expert Laravel Deployment Guide (Ubuntu 24.04/22.04 LTS)

This guide outlines the industry-standard "best practices" for deploying a Laravel application to production.

## 1. Files to Ignore (Git Strategy)

Your `.gitignore` is crucial. **Never** commit these to your repository:

-   `.env`: Contains sensitive keys (DB passwords, API keys).
-   `/vendor`: PHP dependencies (installed via Composer on the server).
-   `/node_modules`: JS dependencies (installed via NPM on the server).
-   `/public/build`: Compiled assets (generated during deployment).
-   `/public/storage`: Symlink to `storage/app/public` (recreated on server).
-   `/storage/*.key`: OAuth keys (if using Passport).

**Your current `.gitignore` looks mostly correct**, but ensure you check:
```gitignore
/vendor
/node_modules
/public/hot
/public/storage
/storage/*.key
.env
.phpunit.result.cache
npm-debug.log
yarn-error.log
/public/build
```

---

## 2. Server Provisioning (Initial Setup)

**Logged in as `root`:**

```bash
# 1. Update & Upgrade
apt update && apt upgrade -y

# 2. Create a deployment user (NEVER run your app as root)
adduser deployer
usermod -aG sudo deployer

# 3. Setup Firewall (UFW)
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw enable
```

**Log out and log back in as `deployer` for the rest of the steps.**

---

## 3. Install The Stack (LEMP)

```bash
# Install Nginx, MySQL, PHP 8.3 (or 8.2), and extensions
sudo apt install nginx mysql-server php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-curl php8.3-intl php8.3-zip unzip -y

# Secure MySQL
sudo mysql_secure_installation
```

---

## 4. Install Dependencies

```bash
# Install Composer (Global)
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM (Using NVM or NodeSource)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

---

## 5. Application Deployment

We will deploy to `/var/www/snapmusic`.

```bash
# 1. Clone Repository
sudo mkdir -p /var/www/snapmusic
sudo chown -R deployer:deployer /var/www/snapmusic
git clone https://github.com/yourusername/snapmusic.git /var/www/snapmusic

# 2. Install PHP Dependencies
cd /var/www/snapmusic
composer install --optimize-autoloader --no-dev

# 3. Setup Environment
cp .env.example .env
nano .env
# -> Set APP_ENV=production
# -> Set APP_DEBUG=false
# -> Set DB credentials
# -> Set URL to your domain

# 4. Generate Application Key
php artisan key:generate

# 5. Database Migration
php artisan migrate --force

# 6. Storage Linking
php artisan storage:link
```

---

## 6. Building Vite (The "Expert" Way)

In production, we do **not** run `npm run dev`. We compile assets once.

```bash
# 1. Install JS Dependencies
npm ci  # 'ci' is safer than 'install' for production (locks versions)

# 2. Compile Assets
npm run build
```

This command will:
1.  Read your `vite.config.js`.
2.  Compile CSS/JS into `/public/build/assets`.
3.  Generate a `manifest.json`.
4.  Laravel's `@vite` directive will automatically read this manifest to serve the correct versioned files.

---

## 7. Permissions (Critical)

Nginx runs as `www-data`. It needs write access to storage and cache.

```bash
# 1. Set ownership of the specific writable directories
sudo chown -R www-data:www-data /var/www/snapmusic/storage
sudo chown -R www-data:www-data /var/www/snapmusic/bootstrap/cache

# 2. Set directory permissions
sudo chmod -R 775 /var/www/snapmusic/storage
sudo chmod -R 775 /var/www/snapmusic/bootstrap/cache
```

---

## 8. Nginx Configuration

Create `/etc/nginx/sites-available/snapmusic`:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/snapmusic/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable it:
```bash
sudo ln -s /etc/nginx/sites-available/snapmusic /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## 9. Queue Workers (Supervisor)

For your video processing jobs, you **must** keep the queue worker running. Use Supervisor.

```bash
sudo apt install supervisor -y
```

Create `/etc/supervisor/conf.d/snapmusic-worker.conf`:

```ini
[program:snapmusic-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/snapmusic/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=deployer
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/snapmusic/storage/logs/worker.log
stopwaitsecs=3600
```

Start it:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start snapmusic-worker:*
```

---

## 10. SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

---

## 11. Final Optimization

Run these commands every time you deploy new code:

```bash
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
```
