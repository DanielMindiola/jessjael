@extends('layouts.app')

@section('content')
<!-- Hero Banner -->
<section class="relative h-[60vh] bg-gray-900 flex items-center justify-center text-white text-center px-4 mb-16">
    <div class="z-10 max-w-3xl">
        <p class="text-xs tracking-widest uppercase mb-3 text-gray-300">NUEVA COLECCIÓN</p>
        <h1 class="text-5xl md:text-7xl font-extrabold uppercase tracking-tight mb-6">JESSJAEL HIGH FASHION</h1>
        <a href="#catalogo" class="inline-block bg-white text-black px-8 py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition">
            Ver Catálogo
        </a>
    </div>
</section>

<!-- Catálogo -->
<section id="catalogo" class="max-w-7xl mx-auto px-6 pb-24">
    <h2 class="text-2xl font-bold uppercase tracking-wider mb-8">Novedades</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
            <div class="group relative">
                <!-- Contenedor Dinámico de Imagen del Producto -->
                <div class="aspect-[3/4] w-full bg-gray-100 overflow-hidden mb-4 relative flex items-center justify-center">
                    @if($product->images->first())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <span class="text-gray-400 font-semibold uppercase text-xs p-4 text-center">{{ $product->name }}</span>
                    @endif
                    <a href="{{ route('shop.show', $product->slug) }}" class="absolute inset-0"></a>
                </div>

                <!-- Información del Producto -->
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wide text-gray-900">
                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $product->category->name }}</p>
                    </div>
                    <p class="text-xs font-extrabold text-gray-900">${{ number_format($product->base_price, 2) }}</p>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-12">No hay prendas disponibles.</p>
        @endforelse
    </div>
</section>
@endsection
