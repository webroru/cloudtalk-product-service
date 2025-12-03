FROM php:8.4-fpm-alpine AS base

# Install permanent packages
RUN apk add --no-cache \
    git \
    mysql-client \
    rabbitmq-c

# Build deps
RUN apk add --update --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    linux-headers \
    rabbitmq-c-dev \
    autoconf \
    make \
    g++

RUN pecl install amqp redis \
    && docker-php-ext-enable amqp redis

RUN docker-php-ext-install -j "$(nproc)" \
    pdo \
    pdo_mysql

RUN apk del .build-deps \
    && rm -rf /var/cache/apk/*

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

FROM base AS prod

ENV APP_ENV=prod

COPY . .

RUN composer install --no-dev --no-interaction --optimize-autoloader
