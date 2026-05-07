@extends('layouts.cliente')

@section('content')
<div class="max-w-4xl mx-auto">

    <a href="{{ route('catalogo') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
        ← Volver al catálogo
    </a>

    <div class="bg-white rounded-lg shadow p-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $servicio['nombre'] }}</h1>
        <p class="text-blue-700 font-semibold text-2xl mb-4">${{ $servicio['costo_base'] }}</p>
        <p class="text-gray-600 mb-6">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>

        {{-- IMÁGENES --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            @foreach(['imagen1', 'imagen2', 'imagen3'] as $img)
                @if(!empty($servicio[$img]))
                <img src="https://serviciosdom-api-production.up.railway.app/storage/{{ $servicio[$img] }}"
                    alt="Imagen del servicio"
                    class="w-full h-48 object-cover rounded-lg border">
                @endif
            @endforeach
        </div>

        {{-- AGREGAR AL CARRITO --}}
        <form action="{{ route('carrito.agregar') }}" method="POST">
            @csrf
            <input type="hidden" name="id_servicio" value="{{ $servicio['id_servicio'] }}">
            <input type="hidden" name="nombre" value="{{ $servicio['nombre'] }}">
            <input type="hidden" name="costo_base" value="{{ $servicio['costo_base'] }}">
            <input type="hidden" name="imagen1" value="{{ $servicio['imagen1'] ?? '' }}">
            <button type="submit"
                class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 font-semibold text-lg">
                🛒 Agregar al carrito
            </button>
        </form>

    </div>
</div>
@endsection
