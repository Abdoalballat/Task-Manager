FROM php:8.2-fpm-alpine

# تثبيت متطلبات النظام وامتدادات PHP اللازمة لـ Laravel و MySQL
RUN apk add --no-cache \
    nginx \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath gd intl opcache

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ ملفات المشروع بالكامل
COPY . .

# تثبيت حزم Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ضبط الصلاحيات لمجلدات التخزين
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# نسخ إعدادات Nginx وسكريبت التشغيل
COPY nginx.conf /etc/nginx/http.d/default.conf
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]