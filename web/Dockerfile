FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

# En développement, on commente le COPY car on utilise un volume
# En production, on décommente cette ligne pour inclure les fichiers dans l'image
# COPY --chown=www-data:www-data . /var/www/html/

EXPOSE 80