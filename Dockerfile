FROM php:8.1-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . /var/www/html/

RUN mkdir -p /var/www/html/uploads/zumar \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && { \
        echo '<Directory /var/www/html>'; \
        echo '    AllowOverride All'; \
        echo '    Require all granted'; \
        echo '</Directory>'; \
        echo 'PassEnv DB_HOST'; \
        echo 'PassEnv DB_PORT'; \
        echo 'PassEnv DB_NAME'; \
        echo 'PassEnv DB_USER'; \
        echo 'PassEnv DB_PASS'; \
    } > /etc/apache2/conf-available/zumar.conf \
    && a2enconf zumar

EXPOSE 80
