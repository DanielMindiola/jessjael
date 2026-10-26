#!/bin/sh

echo "Optimizando la aplicación para producción..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Correr migraciones
php artisan migrate --force || true

# Crear usuario admin y categorías de forma segura con slug
php artisan tinker --execute="
App\Models\User::updateOrCreate(['email' => 'landisgordita.com'], ['name' => 'Admin JessJael', 'password' => Illuminate\Support\Facades\Hash::make('Danielñañobello')]);
App\Models\Category::firstOrCreate(['name' => 'Mujer'], ['slug' => 'mujer']);
App\Models\Category::firstOrCreate(['name' => 'Hombre'], ['slug' => 'hombre']);
App\Models\Category::firstOrCreate(['name' => 'Colección 2026'], ['slug' => 'coleccion-2026']);
" || true

# Iniciar servidor web
exec php artisan serve --host=0.0.0.0 --port=80
