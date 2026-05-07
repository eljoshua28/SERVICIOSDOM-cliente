@extends('layouts.cliente')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">👤 Mi Perfil</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
    {{ $errors->first() }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- EDITAR PERFIL --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Editar Perfil</h2>

        <form action="{{ route('perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ $usuario->nombre }}"
                    class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Correo</label>
                <input type="email" name="correo" value="{{ $usuario->correo }}"
                    class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ $usuario->telefono }}"
                    class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <button type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
                 Guardar Cambios
            </button>
        </form>
    </div>

    {{-- CAMBIAR CONTRASEÑA --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Cambiar Contraseña</h2>

        <form action="{{ route('perfil.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Contraseña Actual</label>
                <input type="password" name="password_actual"
                    class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nueva Contraseña</label>
                <input type="password" name="password_nuevo"
                    class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmar"
                    class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <button type="submit"
                class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600 font-semibold">
                 Cambiar Contraseña
            </button>
        </form>
    </div>

</div>
@endsection
