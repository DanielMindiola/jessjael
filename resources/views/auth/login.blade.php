@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-6 py-24">
    <div class="bg-white border border-gray-200 p-8 shadow-sm">
        <h1 class="text-xl font-black uppercase tracking-widest text-center mb-6">Acceso Administrador</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 text-xs font-bold uppercase">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
    <label class="block text-xs font-bold uppercase tracking-wider mb-2">Usuario / Credencial</label>
    <input type="text" name="email" value="landisgordita.com" required class="w-full border border-gray-300 p-3 text-xs focus:outline-none focus:border-black">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-2">Contraseña</label>
                <input type="password" name="password" required class="w-full border border-gray-300 p-3 text-xs focus:outline-none focus:border-black">
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition">
                Ingresar al Panel
            </button>
        </form>
    </div>
</div>
@endsection
