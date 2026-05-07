@extends('layouts.cliente')

@section('content')
<div class="flex justify-center items-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Crear Cuenta</h2>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <form action="/registro" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Tu nombre completo" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="tucorreo@ejemplo.com" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="33 1234 5678">
        </div>

        <div class="mb-6">
            <label class="block text-sm text-gray-600 mb-1">Contraseña</label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Mínimo 6 caracteres" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
            Registrarse
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia sesión</a>
        </p>

    </form>
</div>
</div>
@endsection
