@extends('layouts.cliente')

@section('content')
<div class="flex justify-center items-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h2>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm text-gray-600 mb-1">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="tucorreo@ejemplo.com">
        </div>

        <div class="mb-6">
            <label class="block text-sm text-gray-600 mb-1">Contraseña</label>
            <input type="password" name="password"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="••••••••">
        </div>

        <button type="submit"
            class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
            Entrar
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿No tienes cuenta? <a href="{{ route('registro') }}" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>

    </form>
</div>
</div>
@endsection
