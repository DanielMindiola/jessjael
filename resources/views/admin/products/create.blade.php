@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h1 class="text-2xl font-black uppercase tracking-wider">Agregar Nueva Prenda | JessJael</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase hover:underline">← Volver al Dashboard</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Información General -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase mb-2">Nombre de la Prenda</label>
                <input type="text" name="name" required class="w-full border p-3 text-sm focus:outline-none" placeholder="Ej: Vestido Saten Gala">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2">Categoría</label>
                <select name="category_id" required class="w-full border p-3 text-sm focus:outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase mb-2">Precio Base ($)</label>
                <input type="number" step="0.01" name="base_price" required class="w-full border p-3 text-sm focus:outline-none" placeholder="0.00">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-2">Imagen de la Prenda (JPG, PNG, WEBP)</label>
                <input type="file" name="image" accept="image/*" class="w-full border p-2 text-xs focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase mb-2">Descripción</label>
            <textarea name="description" rows="3" class="w-full border p-3 text-sm focus:outline-none" placeholder="Detalles de diseño, tela y estilo..."></textarea>
        </div>

        <!-- Sección de Variantes -->
        <div class="border-t pt-6">
            <h2 class="text-sm font-bold uppercase mb-4">Variantes de Inventario (Tallas y Stock)</h2>

            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-4 bg-gray-50 p-4 border border-gray-200">
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Talla</label>
                        <input type="text" name="sizes[]" required value="S" class="w-full border p-2 text-xs uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Color</label>
                        <input type="text" name="colors[]" required value="Negro" class="w-full border p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Stock Disponible</label>
                        <input type="number" name="stocks[]" required value="10" class="w-full border p-2 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 bg-gray-50 p-4 border border-gray-200">
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Talla</label>
                        <input type="text" name="sizes[]" required value="M" class="w-full border p-2 text-xs uppercase">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Color</label>
                        <input type="text" name="colors[]" required value="Negro" class="w-full border p-2 text-xs">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-1">Stock Disponible</label>
                        <input type="number" name="stocks[]" required value="15" class="w-full border p-2 text-xs">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
            Guardar Prenda en Catálogo
        </button>
    </form>
</div>
@endsection
