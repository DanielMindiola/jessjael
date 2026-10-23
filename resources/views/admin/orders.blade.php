@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h1 class="text-2xl font-black uppercase tracking-wider">Gestión de Pedidos</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase hover:underline">← Volver al Dashboard</a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-black text-white text-xs uppercase font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @foreach($orders as $order)
            <div class="border border-gray-200 p-6 bg-white">
                <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-4 gap-4">
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold">Orden:</span>
                        <h2 class="text-lg font-black">{{ $order->order_number }}</h2>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold">Cliente:</span>
                        <p class="text-sm font-bold uppercase">{{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                        <p class="text-xs text-gray-500">{{ $order->customer_email }} | {{ $order->shipping_address }}, {{ $order->city }}</p>
                    </div>
                    <div>
                        <!-- Formulario Cambio de Estado -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            <select name="status" class="border p-2 text-xs font-bold uppercase focus:outline-none">
                                <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ $order->status == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="enviado" {{ $order->status == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="completado" {{ $order->status == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <button type="submit" class="bg-black text-white px-4 py-2 text-xs font-bold uppercase hover:bg-gray-800">Actualizar</button>
                        </form>
                    </div>
                </div>

                <!-- Detalle de Productos Comprados -->
                <div class="space-y-2">
                    <p class="text-xs font-bold uppercase text-gray-500">Prendas Solicitadas:</p>
                    <ul class="text-xs divide-y">
                        @foreach($order->items as $item)
                            <li class="py-2 flex justify-between">
                                <span>{{ $item->product_name }} (Talla: {{ $item->size }} | Color: {{ $item->color }}) x{{ $item->quantity }}</span>
                                <span class="font-bold">${{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
