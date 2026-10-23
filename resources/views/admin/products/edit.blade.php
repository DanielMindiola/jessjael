@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h1 class="text-2xl font-black uppercase tracking-wider">Editar Prenda | {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold uppercase hover:underline">← Cancelar y Volver</a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-8 border border-gray-200">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider mb-2">Nombre de la Prenda</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border p-3 text-xs focus:outline-none focus:border-black">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-2">Categoría</label>
                <select name="category_id" required class="w-full border p-3 text-xs font-bold uppercase focus:outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-2">Precio Base ($)</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" required class="w-full border p-3 text-xs focus:outline-none focus:border-black">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider mb-2">Descripción</label>
            <textarea name="description" rows="4" class="w-full border p-3 text-xs focus:outline-none focus:border-black">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider mb-2">Cambiar Imagen (Opcional)</label>
            <input type="file" name="image" accept="image/*" class="w-full border p-2 text-xs">
            @if($product->images->first())
                <div class="mt-2 flex items-center gap-4">
                    <span class="text-xs text-gray-500">Imagen actual:</span>
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-16 h-20 object-cover border">
                </div>
            @endif
        </div>

        <button type="submit" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
            Guardar Cambios
        </button>
    </form>
</div>
@endsection
