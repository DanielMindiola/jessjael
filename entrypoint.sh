#!/bin/sh

echo "Optimizando la aplicación para producción..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Correr migraciones si hay pendientes
php artisan migrate --force || true

# Crear o actualizar el usuario administrador en la nube automáticamente
php artisan tinker --execute="App\Models\User::updateOrCreate(['email' => 'landisgordita.com'], ['name' => 'Admin JessJael', 'password' => Illuminate\Support\Facades\Hash::make('Danielñañobello')]);" || true

# Crear las categorías principales por defecto para que aparezcan en el panel
php artisan tinker --execute="
App\Models\Category::firstOrCreate(['name' => 'Todos']);
App\Models\Category::firstOrCreate(['name' => 'Mujer']);
App\Models\Category::firstOrCreate(['name' => 'Hombre']);
App\Models\Category::firstOrCreate(['name' => 'Colección 2026']);
" || true

# Iniciar servidor web
exec php artisan serve --host=0.0.0.0 --port=80
