FROM php:8.2-fpm

# Instalar dependencias del sistema y Node.js (necesario para compilar Vite)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Instalar Node.js y NPM para compilar los recursos de Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql pgsql pdo_pgsql mbstring gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node y compilar assets de Vite
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chmod +x /var/www/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/var/www/entrypoint.sh"]
