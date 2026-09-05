FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Pass DB env vars from container into PHP (Apache mod_php)
RUN { \
    echo 'PassEnv DB_HOST'; \
    echo 'PassEnv DB_PORT'; \
    echo 'PassEnv DB_NAME'; \
    echo 'PassEnv DB_USER'; \
    echo 'PassEnv DB_PASS'; \
    } >> /etc/apache2/conf-available/db-env.conf \
    && a2enconf db-env

EXPOSE 80
