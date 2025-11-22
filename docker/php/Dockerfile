FROM php:8.4-fpm-alpine AS base

# Install permanent packages
RUN apk add --no-cache \
    git \
    mysql-client

RUN docker-php-ext-install -j "$(nproc)" \
    pdo \
    pdo_mysql

ENV PATH=${PATH}:/var/www/html/vendor/bin

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

FROM base AS dev

RUN apk add --no-cache \
    bash

RUN apk add --update --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    linux-headers

RUN pecl install xdebug

RUN docker-php-ext-enable xdebug

RUN apk del .build-deps \
    && rm -rf /var/cache/apk/*
