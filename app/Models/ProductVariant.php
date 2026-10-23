<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'size', 'color', 'color_code', 'stock', 'additional_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
