<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(count($cart) == 0) {
            return redirect()->route('shop.index');
        }
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if(count($cart) == 0) {
            return redirect()->route('shop.index');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
        ]);

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Crear Orden
        $order = Order::create([
            'order_number' => 'JJ-' . strtoupper(Str::random(6)),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'total_amount' => $total,
            'status' => 'pendiente'
        ]);

        // 2. Guardar Items y Descontar Stock de forma estricta (Evita negativos)
        foreach($cart as $variantId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $variantId,
                'product_name' => $item['name'],
                'size' => $item['size'],
                'color' => $item['color'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Descontar inventario de forma segura
            $variant = ProductVariant::find($variantId);
            if($variant) {
                $newStock = max(0, $variant->stock - $item['quantity']);
                $variant->update(['stock' => $newStock]);
            }
        }

        // Vaciar carrito
        session()->forget('cart');

        return view('checkout.success', compact('order'));
    }
}
