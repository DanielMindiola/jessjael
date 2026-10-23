<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JessJael | Fashion Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    <!-- Header estilo Zara -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logotipo -->
            <a href="{{ route('shop.index') }}" class="text-2xl font-black tracking-widest uppercase">
                JESSJAEL
            </a>

            <!-- Navegación por Categorías -->
            <nav class="hidden md:flex space-x-8 text-xs font-bold tracking-widest uppercase">
                <a href="{{ route('shop.index') }}" class="hover:text-gray-500 transition">Todos</a>
                <a href="{{ route('shop.index', ['categoria' => 'mujer']) }}" class="hover:text-gray-500 transition">Mujer</a>
                <a href="{{ route('shop.index', ['categoria' => 'hombre']) }}" class="hover:text-gray-500 transition">Hombre</a>
                <a href="{{ route('shop.index', ['categoria' => 'coleccion-2026']) }}" class="hover:text-gray-500 transition">Colección 2026</a>
            </nav>

            <!-- Buscador y Bolsa de Compras -->
            <div class="flex items-center space-x-6 text-sm font-medium">
                <!-- Formulario de Búsqueda -->
                <form action="{{ route('shop.index') }}" method="GET" class="relative flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar prendas..." class="border-b border-gray-400 bg-transparent py-1 text-xs focus:outline-none focus:border-black pr-6">
                    <button type="submit" class="absolute right-0 text-gray-500 hover:text-black">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>

                <!-- Bolsa de Compras -->
                <a href="{{ route('cart.index') }}" class="hover:opacity-75 font-bold text-xs uppercase tracking-wider">
                    Bolsa ({{ count(session('cart', [])) }})
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer de la Tienda -->
    <footer class="bg-gray-50 border-t border-gray-200 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; 2026 JESSJAEL HIGH FASHION. Todos los derechos reservados.</p>

            <!-- Enlace exclusivo y discreto para el Admin -->
            <div class="mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="hover:text-black tracking-widest uppercase font-bold text-[10px] text-gray-400">
                    Panel Admin
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
