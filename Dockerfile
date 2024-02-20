FROM composer:2.7 AS vendor

WORKDIR /bot

COPY src ./src
COPY composer.json .
COPY composer.lock .

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

FROM php:8.2-apache

WORKDIR /var/www/html/
COPY .htaccess .
COPY --from=vendor /bot/vendor/ ./vendor/
COPY --from=vendor /bot/src ./src

RUN mkdir -p /var/lib/echo-bot/
RUN chown -R www-data:www-data /var/lib/echo-bot/
RUN chmod -R u+w /var/lib/echo-bot/