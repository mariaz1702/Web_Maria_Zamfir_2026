# Imagine de bază PHP cu Apache, actualizată
FROM php:8.4-apache

# Instalăm extensiile necesare
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Activăm mod_rewrite (opțional pentru .htaccess)
RUN a2enmod rewrite

# Copiem codul aplicației în container
COPY src/ /var/www/html/

# Permisiuni corecte
RUN chown -R www-data:www-data /var/www/html

# Portul implicit Apache
EXPOSE 80
