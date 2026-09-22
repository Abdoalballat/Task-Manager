#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

# تنظيف وتخزين الإعدادات كاش
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل الـ Migrations إجبارياً على البرودكشن
php artisan migrate --force