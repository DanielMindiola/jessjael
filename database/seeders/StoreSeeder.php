<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Mujer', 'Hombre', 'Niños', 'Accesorios', 'Colección 2026'];

        foreach ($categories as $cat) {
            Category::firstOrCreate([
                'slug' => \Illuminate\Support\Str::slug($cat)
            ], [
                'name' => $cat
            ]);
        }

        // 2. Crear Producto de ejemplo
        $producto = Product::create([
            'category_id' => Category::where('slug', 'mujer')->first()->id,
            'name' => 'Chaqueta Oversize Blazer JessJael',
            'slug' => 'chaqueta-oversize-blazer-jessjael',
            'description' => 'Blazer de corte holgado con diseño exclusivo estilo urbano sofisticado.',
            'base_price' => 59.99,
            'is_active' => true
        ]);

        // 3. Crear Variantes (Tallas y Colores con Stock)
        ProductVariant::create([
            'product_id' => $producto->id,
            'sku' => 'JJ-BLZ-NEGRO-S',
            'size' => 'S',
            'color' => 'Negro',
            'color_code' => '#000000',
            'stock' => 10
        ]);

        ProductVariant::create([
            'product_id' => $producto->id,
            'sku' => 'JJ-BLZ-NEGRO-M',
            'size' => 'M',
            'color' => 'Negro',
            'color_code' => '#000000',
            'stock' => 15
        ]);

        ProductVariant::create([
            'product_id' => $producto->id,
            'sku' => 'JJ-BLZ-BEIGE-M',
            'size' => 'M',
            'color' => 'Beige',
            'color_code' => '#F5F5DC',
            'stock' => 8
        ]);
    }
}
