@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-16 text-center">
    <div class="inline-block p-4 bg-black text-white mb-6 uppercase text-xs tracking-widest font-bold">
        ¡Pedido Realizado con Éxito!
    </div>
    <h1 class="text-3xl font-black uppercase mb-2">Gracias por tu compra</h1>
    <p class="text-sm text-gray-600 mb-6">Número de orden: <strong class="text-black">{{ $order->order_number }}</strong></p>

    <div class="bg-gray-50 border p-6 text-left text-xs space-y-2 mb-8">
        <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
        <p><strong>Dirección:</strong> {{ $order->shipping_address }}, {{ $order->city }}</p>
        <p><strong>Total pagado:</strong> ${{ number_format($order->total_amount, 2) }}</p>
    </div>

    <a href="{{ route('shop.index') }}" class="inline-block bg-black text-white px-8 py-3 text-xs font-bold uppercase tracking-widest">
        Volver a la Tienda
    </a>
</div>
@endsection
