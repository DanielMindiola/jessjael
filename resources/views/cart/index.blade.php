@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-black uppercase tracking-wider mb-8">Bolsa de Compras</h1>

    @if(count($cart) > 0)
        <div class="space-y-6">
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <div class="flex items-center justify-between border-b border-gray-200 pb-6">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wide">{{ $item['name'] }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Talla: {{ $item['size'] }} | Color: {{ $item['color'] }}</p>
                        <p class="text-xs text-gray-500">Cantidad: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <p class="text-sm font-bold">${{ number_format($subtotal, 2) }}</p>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline font-semibold uppercase">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="pt-6 flex justify-between items-center border-t border-gray-300">
                <span class="text-base font-extrabold uppercase">Total:</span>
                <span class="text-xl font-black">${{ number_format($total, 2) }}</span>
            </div>

            <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
    Proceder al Pago (Checkout)
</a>
        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 mb-6 uppercase text-sm">Tu bolsa de compras está vacía.</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-black text-white px-8 py-3 text-xs font-bold uppercase tracking-widest">
                Descubrir Colección
            </a>
        </div>
    @endif
</div>
@endsection
