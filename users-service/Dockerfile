# FROM php:8.4-fpm

# RUN apt-get update && apt-get install -y \
#     zip unzip curl git libpq-dev libzip-dev

# RUN docker-php-ext-install pdo pdo_pgsql

# COPY . /var/www
# WORKDIR /var/www

# RUN curl -sS https://getcomposer.org/installer | php \
#     && php composer.phar install

# CMD php artisan serve --host=0.0.0.0 --port=8000

FROM node:20 AS assets

WORKDIR /var/www
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build


FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www

COPY . .
COPY --from=assets /var/www/public/build ./public/build

COPY . .
RUN rm -f .env
RUN rm -f bootstrap/cache/config.php bootstrap/cache/packages.php
RUN curl -sS https://getcomposer.org/installer | php && php composer.phar install --no-dev


CMD php artisan serve --host=0.0.0.0 --port=8000
