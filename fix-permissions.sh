#!/bin/bash

# SnapMusic Permission Fixer Script
# Run this on your production server to fix permission issues.

APP_PATH="/data/snapmusic"
WEB_USER="www-data"
DEPLOY_USER="rohan"

echo "Fixing permissions for $APP_PATH..."

# 1. Reset ownership for the entire project
# Everything belongs to 'rohan' (deployer) but group is 'www-data'
sudo chown -R $DEPLOY_USER:$WEB_USER $APP_PATH

# 2. Grant write access to the group (www-data) for the whole app
# This allows the web server to read everything, and we'll restrict/open specific folders next.
# Default files: 644 (rw-r--r--) -> 664 (rw-rw-r--)
# Default dirs:  755 (rwxr-xr-x) -> 775 (rwxrwxr-x)
sudo find $APP_PATH -type f -exec chmod 664 {} \;
sudo find $APP_PATH -type d -exec chmod 775 {} \;

# 3. Give www-data FULL ownership of storage and cache
# These are the only places the app needs to write at runtime.
sudo chown -R $WEB_USER:$WEB_USER $APP_PATH/storage
sudo chown -R $WEB_USER:$WEB_USER $APP_PATH/bootstrap/cache

# 4. Ensure these specific directories are writable
sudo chmod -R 775 $APP_PATH/storage
sudo chmod -R 775 $APP_PATH/bootstrap/cache

# 5. Clear caches to rebuild them with correct permissions
echo "Clearing application caches..."
cd $APP_PATH
sudo -u $WEB_USER php artisan optimize:clear
sudo -u $WEB_USER php artisan config:cache
sudo -u $WEB_USER php artisan view:cache

echo "Permissions fixed! Restarting queue worker..."
sudo supervisorctl restart snapmusic-worker:*

echo "Done."
