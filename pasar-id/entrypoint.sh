#!/bin/sh
set -e

echo "Laravel entrypoint: memastikan dependencies terpasang..."

# Jalankan composer install jika vendor belum ada di mounted volume
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "vendor/autoload.php tidak ditemukan. Menjalankan composer install..."
    cd /var/www/html
    composer install --no-interaction --optimize-autoloader --no-dev
    echo "composer install selesai."
else
    echo "vendor/autoload.php sudah ada. Melewati composer install."
fi

# Pastikan storage directories ada
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/app/public

# Optimalkan konfigurasi dan view untuk production
php artisan config:cache
php artisan route:cache

# Jalankan php-fpm
exec php-fpm
