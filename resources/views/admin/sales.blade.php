@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <div>
            <h1 class="text-2xl font-black uppercase tracking-wider">Reporte de Ventas y Ganancias</h1>
            <p class="text-xs text-gray-500 uppercase font-bold mt-1">Estadísticas financieras y control de ingresos | JessJael</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase hover:underline">← Volver al Dashboard</a>
    </div>

    <!-- Tarjetas de Resumen Financiero -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="p-6 bg-black text-white">
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Ingresos Totales</p>
            <p class="text-3xl font-black">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1">Prendas Vendidas</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalGarmentsSold }} <span class="text-xs font-normal">unidades</span></p>
        </div>
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1">Órdenes Totales</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalSalesCount }}</p>
        </div>
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1">Enviadas / Completadas</p>
            <p class="text-3xl font-black text-gray-900">{{ $completedSalesCount }}</p>
        </div>
    </div>

    <!-- Detalle de Órdenes y Prendas Vendidas -->
    <h2 class="text-lg font-extrabold uppercase tracking-wide mb-4">Desglose de Órdenes y Ganancias</h2>
    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="border border-gray-200 p-6 bg-white shadow-sm">
                <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-4 gap-4">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase">Orden:</span>
                        <span class="text-sm font-black text-gray-900 ml-1">{{ $order->order_number }}</span>
                        <span class="text-xs text-gray-400 ml-4">Fecha: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold uppercase px-3 py-1 bg-gray-100 border">
                            Estado: {{ $order->status }}
                        </span>
                        <span class="text-base font-black text-gray-900">Total: ${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-4 text-gray-600">
                    <div>
                        <p><strong class="text-gray-900 uppercase">Cliente:</strong> {{ $order->customer_name }} ({{ $order->customer_email }})</p>
                    </div>
                    <div>
                        <p><strong class="text-gray-900 uppercase">Ciudad / Dirección:</strong> {{ $order->city }} - {{ $order->shipping_address }}</p>
                    </div>
                </div>

                <!-- Prendas de esta orden -->
                <div class="bg-gray-50 p-4 border border-gray-100">
                    <p class="text-[10px] font-bold uppercase text-gray-500 mb-2">Prendas incluidas en esta venta:</p>
                    <ul class="divide-y divide-gray-200 text-xs">
                        @foreach($order->items as $item)
                            <li class="py-2 flex justify-between items-center">
                                <span>
                                    <strong>{{ $item->product_name }}</strong>
                                    <span class="text-gray-500">(Talla: {{ $item->size }} | Color: {{ $item->color }})</span> x{{ $item->quantity }}
                                </span>
                                <span class="font-bold">${{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <div class="p-8 text-center border border-gray-200 text-gray-500 uppercase font-bold">
                No hay registros de ventas todavía.
            </div>
        @endforelse

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
