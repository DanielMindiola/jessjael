#!/bin/sh

echo "Esperando a que la base de datos responda..."
sleep 5

# Intentar migraciones de forma segura
php artisan migrate --force || true
php artisan db:seed --force || true

# Arrancar el servidor Laravel
exec php artisan serve --host=0.0.0.0 --port=80
