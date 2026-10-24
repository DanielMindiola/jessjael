#!/bin/sh

echo "Optimizando la aplicación para producción..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Correr migraciones si hay pendientes
php artisan migrate --force || true

# Iniciar servidor web
exec php artisan serve --host=0.0.0.0 --port=80
