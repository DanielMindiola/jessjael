@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Galería de Imágenes de la Prenda -->
        <div class="space-y-4">
            <div class="aspect-[3/4] bg-gray-100 flex items-center justify-center overflow-hidden">
                @if($product->images->first())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gray-400 font-bold uppercase text-sm p-4 text-center">{{ $product->name }} (Sin Foto)</span>
                @endif
            </div>
        </div>

        <!-- Detalles y Formulario de Selección -->
        <div>
            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">{{ $product->category->name }}</p>
            <h1 class="text-3xl font-extrabold uppercase tracking-tight text-gray-900 mb-4">{{ $product->name }}</h1>
            <p class="text-2xl font-bold text-gray-900 mb-6">${{ number_format($product->base_price, 2) }}</p>

            <p class="text-sm text-gray-600 mb-8 leading-relaxed">{{ $product->description }}</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-black text-white text-xs uppercase tracking-widest font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulario Agregar al Carrito -->
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <!-- Seleccionar Variante (Talla y Color) -->
                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-3">Talla y Color Disponibles</label>
                    <select name="variant_id" required class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black">
                        <option value="">-- Selecciona una opción --</option>
                        @foreach($product->variants as $variant)
                            <option value="{{ $variant->id }}" {{ $variant->stock == 0 ? 'disabled' : '' }}>
                                Talla: {{ $variant->size }} | Color: {{ $variant->color }} {{ $variant->stock == 0 ? '(Agotado)' : '('.$variant->stock.' disponibles)' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cantidad -->
                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-3">Cantidad</label>
                    <input type="number" name="quantity" value="1" min="1" class="w-24 border border-gray-300 p-3 text-sm focus:outline-none focus:border-black">
                </div>

                <!-- Botón Añadir a la Bolsa -->
                <button type="submit" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
                    Añadir a la Bolsa
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
