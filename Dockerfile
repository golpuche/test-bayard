ARG PHP_VERSION=8.1
ARG NGINX_VERSION=1.24

FROM php:${PHP_VERSION}-fpm-alpine AS php_alpine

RUN apk add --no-cache autoconf build-base curl-dev openssl-dev
RUN pecl install mongodb
COPY docker/php/conf.d/docker-fpm.ini /usr/local/etc/php/conf.d
COPY docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/
COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock symfony.lock phpunit.xml .env ./
COPY bin ./bin
COPY config ./config
COPY src ./src
COPY public ./public
COPY data ./data
COPY tests ./tests

RUN composer install

RUN chmod 777 -R ./var/cache/*

USER www-data

CMD ["php-fpm"]

FROM nginx:${NGINX_VERSION} AS nginx

WORKDIR /app

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d

COPY --from=php_alpine /app ./
