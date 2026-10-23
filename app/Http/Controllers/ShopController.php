<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Catálogo Principal con Filtro de Categoría y Buscador
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['category', 'images', 'variants'])
            ->where('is_active', true);

        // Filtrar por categoría si viene en la URL
        if ($request->has('categoria') && !empty($request->categoria)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        // Filtrar por buscador
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);

        return view('shop.index', compact('categories', 'products'));
    }

    // Ver detalle de una prenda individual
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.show', compact('product'));
    }
}
