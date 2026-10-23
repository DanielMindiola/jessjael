@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h1 class="text-2xl font-black uppercase tracking-wider">Gestión de Prendas | JessJael</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-4 py-2 text-xs font-bold uppercase hover:bg-gray-800 transition">+ Nueva Prenda</a>
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase hover:underline">← Volver al Dashboard</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-black text-white text-xs uppercase font-bold tracking-wider">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-[10px] font-black uppercase tracking-wider text-gray-600 border-b">
                    <th class="p-4">Imagen</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Categoría</th>
                    <th class="p-4">Precio</th>
                    <th class="p-4">Variantes/Stock</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-xs">
                @forelse($products as $product)
                    <tr>
                        <td class="p-4">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-12 h-16 object-cover border">
                            @else
                                <span class="text-gray-400 italic">Sin Foto</span>
                            @endif
                        </td>
                        <td class="p-4 font-bold">{{ $product->name }}</td>
                        <td class="p-4 text-gray-500 uppercase">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="p-4 font-black">${{ number_format($product->base_price, 2) }}</td>
                        <td class="p-4">
                            @foreach($product->variants as $variant)
                                <span class="inline-block bg-gray-100 border text-[10px] px-2 py-0.5 mr-1 mb-1 font-bold">
                                    {{ $variant->size }} ({{ $variant->color }}): {{ $variant->stock }}
                                </span>
                            @endforeach
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-block bg-gray-200 text-black px-3 py-1.5 text-[10px] font-bold uppercase hover:bg-gray-300">Editar</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta prenda por completo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1.5 text-[10px] font-bold uppercase hover:bg-red-800 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 uppercase font-bold">No hay prendas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
