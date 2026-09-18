#
# Production image for deploying this Apigility app to Render.
# Unlike ./Dockerfile (used by docker-compose for local dev via volume
# mount), this image copies the source in and installs dependencies at
# build time, so it is self-contained.
#
FROM composer:2 AS get-composer
FROM php:8.2-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends git libzip-dev libicu-dev libpq-dev unzip \
 && docker-php-ext-install zip pdo_pgsql pgsql \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

COPY --from=get-composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

COPY . .

RUN sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf \
 && printf '<Directory /var/www/public>\n    AllowOverride All\n</Directory>\n' > /etc/apache2/conf-available/allow-override.conf \
 && a2enconf allow-override

RUN composer install --no-dev --no-interaction --optimize-autoloader \
 && mkdir -p data/cache \
 && chown -R www-data:www-data /var/www/data

COPY docker/render-entrypoint.sh /usr/local/bin/render-entrypoint.sh
RUN chmod +x /usr/local/bin/render-entrypoint.sh

EXPOSE 10000
ENTRYPOINT ["render-entrypoint.sh"]
