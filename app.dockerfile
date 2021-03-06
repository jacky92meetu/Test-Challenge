FROM php:7.4-fpm-alpine

RUN apk --update add --no-cache supervisor bash

RUN docker-php-ext-install mysqli pdo_mysql

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Build process
COPY . .
RUN composer install  --no-dev

COPY supervisord-app.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
