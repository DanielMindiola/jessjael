FROM php:8.2-fpm

# Instalar dependencias del sistema y librerías necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Instalar extensiones de PHP para Laravel (sin errores de nombre)
RUN docker-php-ext-install pdo pdo_mysql mbstring gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos para storage
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Ejecutar migraciones automáticamente e iniciar el servidor
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=80
