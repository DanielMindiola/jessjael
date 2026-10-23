<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with('product.images')->findOrFail($request->variant_id);

        if ($variant->stock <= 0) {
            return back()->with('error', 'El producto seleccionado se encuentra agotado.');
        }

        $cart = session()->get('cart', []);
        $currentQuantityInCart = isset($cart[$variant->id]) ? $cart[$variant->id]['quantity'] : 0;
        $requestedQuantity = $request->quantity;

        // Validar que la cantidad total deseada no supere el stock disponible
        if (($currentQuantityInCart + $requestedQuantity) > $variant->stock) {
            return back()->with('error', "Solo quedan {$variant->stock} unidades disponibles de esta talla/color.");
        }

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity'] += $requestedQuantity;
        } else {
            $primaryImage = $variant->product->images->where('is_primary', true)->first();
            $imagePath = $primaryImage ? $primaryImage->image_path : ($variant->product->images->first()->image_path ?? null);

            $cart[$variant->id] = [
                'variant_id' => $variant->id,
                'product_id' => $variant->product->id,
                'name' => $variant->product->name,
                'price' => $variant->product->base_price,
                'size' => $variant->size,
                'color' => $variant->color,
                'quantity' => $requestedQuantity,
                'image' => $imagePath,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', '¡Prenda agregada a la bolsa!');
    }

    public function remove($variantId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Prenda eliminada de la bolsa.');
    }
}
