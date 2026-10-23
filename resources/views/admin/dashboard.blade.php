@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Encabezado con Botones Organizados y Adaptables -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b pb-4 gap-4">
        <h1 class="text-2xl font-black uppercase tracking-wider">Panel de Control | Admin JessJael</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">
                + Agregar Producto
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-black px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-gray-300 transition">
                Gestionar Prendas
            </a>
            <a href="{{ route('admin.orders') }}" class="border border-black px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-black hover:text-white transition">
                Ver Pedidos
            </a>
            <a href="{{ route('admin.sales') }}" class="bg-black text-white px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-gray-800 transition">
                Reporte de Ventas
            </a>
        </div>
    </div>

    <!-- Alerta de Éxito al Crear Producto -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-black text-white text-xs uppercase font-bold tracking-wider">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tarjetas de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-xs uppercase text-gray-500 font-bold mb-1">Total de Ventas</p>
            <p class="text-3xl font-black text-gray-900">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-xs uppercase text-gray-500 font-bold mb-1">Pedidos Realizados</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalOrders }}</p>
        </div>
        <div class="p-6 bg-gray-50 border border-gray-200">
            <p class="text-xs uppercase text-gray-500 font-bold mb-1">Prendas Registradas</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalProducts }}</p>
        </div>
    </div>

    <!-- Pedidos Recientes -->
    <h2 class="text-lg font-extrabold uppercase tracking-wide mb-4">Últimos Pedidos Recibidos</h2>
    <div class="overflow-x-auto border border-gray-200">
        <table class="w-full text-left text-xs uppercase">
            <thead class="bg-gray-100 border-b border-gray-200 font-bold">
                <tr>
                    <th class="p-4">Nº Orden</th>
                    <th class="p-4">Cliente</th>
                    <th class="p-4">Ciudad</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                    <tr>
                        <td class="p-4 font-bold">{{ $order->order_number }}</td>
                        <td class="p-4">{{ $order->customer_name }}</td>
                        <td class="p-4">{{ $order->city }}</td>
                        <td class="p-4 font-extrabold">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-black text-white text-[10px] font-bold">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">No se han registrado pedidos aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
