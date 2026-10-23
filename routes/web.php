<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// Rutas de la Tienda Pública
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/producto/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Rutas del Carrito y Checkout
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::delete('/carrito/eliminar/{variantId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

// Rutas de Autenticación Admin (FUERA DEL GRUPO ADMIN)
Route::get('/ingresar', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/ingresar', [AdminController::class, 'login'])->name('login.submit');
Route::post('/salir', [AdminController::class, 'logout'])->name('logout');

// Rutas Administrativas
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pedidos', [AdminController::class, 'orders'])->name('orders');
    Route::post('/pedidos/{id}/estado', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // Nueva Ruta de Reporte de Ventas
        Route::get('/ventas', [AdminController::class, 'salesReport'])->name('sales');

    // Rutas de Gestión de Productos Admin
    Route::get('/productos', [AdminController::class, 'products'])->name('products.index');
    Route::get('/productos/crear', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/productos', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/productos/{id}/editar', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/productos/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/productos/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
});
