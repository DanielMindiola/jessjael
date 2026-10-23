<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'customer_email',
        'customer_phone', 'shipping_address', 'city',
        'total_amount', 'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
