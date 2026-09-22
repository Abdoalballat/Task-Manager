#!/bin/sh

# تشغيل الـ Migrations والكاش
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# تشغيل PHP-FPM في الخلفية
php-fpm -D

# تشغيل Nginx في المقدمة
nginx -g "daemon off;"