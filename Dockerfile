FROM php:8.2-fpm

# Instalar dependencias del sistema y librerías para PostgreSQL y MySQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Instalar extensiones de PHP (incluyendo pgsql y pdo_pgsql)
RUN docker-php-ext-install pdo pdo_mysql pgsql pdo_pgsql mbstring gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chmod +x /var/www/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/var/www/entrypoint.sh"]
