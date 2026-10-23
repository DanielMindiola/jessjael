<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'description', 'base_price', 'is_active'];

    // Relación: Un producto pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: Un producto tiene muchas variantes (tallas, colores, stock)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Relación: Un producto tiene muchas imágenes
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
