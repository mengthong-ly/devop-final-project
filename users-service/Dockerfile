# -----------------------------
# 1) Build frontend assets
# -----------------------------
    FROM node:20 AS assets

    WORKDIR /var/www
    COPY package.json package-lock.json ./
    RUN npm install
    COPY . .
    RUN npm run build
    
    
    # -----------------------------
    # 2) PHP 8.4 FPM Container
    # -----------------------------
    FROM php:8.4-fpm
    
    # Install PHP extensions for Laravel + PostgreSQL
    RUN apt-get update && apt-get install -y \
        zip unzip git libpq-dev libzip-dev \
        && docker-php-ext-install pdo pdo_pgsql
    
    WORKDIR /var/www
    
    # Copy Laravel backend source code
    COPY . .
    
    # Copy Vite build assets into public/build
    COPY --from=assets /var/www/public/build ./public/build
    
    # Install PHP dependencies (no dev, optimized)
    RUN curl -sS https://getcomposer.org/installer | php \
        && php composer.phar install --no-dev --optimize-autoloader
    
    # Remove Laravel cached configs (important)
    RUN rm -f bootstrap/cache/*.php
    
    # PHP-FPM is the PRODUCTION runtime
    CMD ["php-fpm"]
    