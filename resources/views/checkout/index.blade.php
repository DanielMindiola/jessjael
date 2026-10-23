@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-black uppercase tracking-wider mb-8">Finalizar Pedido</h1>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        <div class="space-y-4">
            <h2 class="text-sm font-bold uppercase border-b pb-2">Datos de Envío</h2>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Nombre Completo</label>
                <input type="text" name="customer_name" required class="w-full border p-3 text-sm focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Correo Electrónico</label>
                <input type="email" name="customer_email" required class="w-full border p-3 text-sm focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Teléfono</label>
                <input type="text" name="customer_phone" required class="w-full border p-3 text-sm focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Ciudad</label>
                <input type="text" name="city" required class="w-full border p-3 text-sm focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Dirección de Entrega</label>
                <textarea name="shipping_address" required rows="3" class="w-full border p-3 text-sm focus:outline-none"></textarea>
            </div>
        </div>

        <div class="bg-gray-50 p-6 space-y-4 h-fit border border-gray-200">
            <h2 class="text-sm font-bold uppercase border-b pb-2">Resumen de Compra</h2>
            @php $total = 0; @endphp
            @foreach($cart as $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <div class="flex justify-between text-xs">
                    <span>{{ $item['name'] }} ({{ $item['size'] }}/{{ $item['color'] }}) x{{ $item['quantity'] }}</span>
                    <span class="font-bold">${{ number_format($subtotal, 2) }}</span>
                </div>
            @endforeach
            <div class="pt-4 border-t flex justify-between font-black text-lg">
                <span>Total:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            <button type="submit" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition mt-4">
                Confirmar y Realizar Pedido
            </button>
        </div>
    </form>
</div>
@endsection
