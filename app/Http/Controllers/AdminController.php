<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Panel Principal / Dashboard
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalSales = Order::sum('total_amount');
        $totalProducts = Product::count();
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalSales', 'totalProducts', 'recentOrders'));
    }

    // Listado de Pedidos
    public function orders()
    {
        $orders = Order::with('items')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    // Cambiar Estado del Pedido
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado.');
    }

    // Formulario de creación de productos
    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Guardar Producto, Foto en Storage y Variantes en DB
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'required|array',
            'colors' => 'required|array',
            'stocks' => 'required|array',
        ]);

        // 1. Crear producto
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999),
            'description' => $request->description,
            'base_price' => $request->base_price,
            'is_active' => true,
        ]);

        // 2. Guardar foto si se envió
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        // 3. Crear variantes
        foreach ($request->sizes as $index => $size) {
            $color = $request->colors[$index] ?? 'Único';
            $stock = $request->stocks[$index] ?? 0;

            ProductVariant::create([
                'product_id' => $product->id,
                'sku' => 'JJ-' . strtoupper(Str::slug($product->name)) . '-' . $size . '-' . rand(10, 99),
                'size' => $size,
                'color' => $color,
                'stock' => $stock,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', '¡Prenda guardada con éxito!');
    }

    // Listar todos los productos registrados para administración
    public function products()
    {
        $products = Product::with(['category', 'images', 'variants'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    // Formulario de Edición de Producto
    public function editProduct($id)
    {
        $product = Product::with(['category', 'images', 'variants'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Actualizar Producto
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'base_price' => $request->base_price,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }

            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar Producto, Variantes e Imágenes por completo
    public function destroyProduct($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado por completo.');
    }

    // Mostrar el formulario de Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el ingreso del Admin
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
        ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.index');
    }

    // Reporte detallado de ventas y ganancias
    public function salesReport()
    {
        // Obtener solo las órdenes completadas o enviadas (o todas las pagadas)
        $orders = Order::with('items')->latest()->paginate(15);

        // Calcular estadísticas generales
        $totalSalesCount = Order::count();
        $completedSalesCount = Order::where('status', 'completado')->orWhere('status', 'enviado')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelado')->sum('total_amount');

        // Calcular total de prendas individuales vendidas
        $totalGarmentsSold = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('status', '!=', 'cancelado');
        })->sum('quantity');

        return view('admin.sales', compact('orders', 'totalSalesCount', 'completedSalesCount', 'totalRevenue', 'totalGarmentsSold'));
    }
}
