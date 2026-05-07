@extends('layouts.cliente')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Catálogo de Servicios</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

@if(!empty($servicios))
@foreach($servicios as $s)
<div class="bg-white rounded-lg shadow overflow-hidden flex flex-col justify-between">

    {{-- IMAGEN PREVIEW --}}
    @if(!empty($s['imagen1']))
    <img src="http://127.0.0.1:8000/storage/{{ $s['imagen1'] }}"
        alt="{{ $s['nombre'] }}"
        class="w-full h-56 object-cover">
    @else
    <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-400 text-sm">
        Sin imagen
    </div>
    @endif

    <div class="p-5 flex flex-col flex-grow justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $s['nombre'] }}</h2>
            <p class="text-gray-500 text-sm mb-3">{{ $s['descripcion'] ?? 'Sin descripción' }}</p>
            <p class="text-blue-700 font-semibold text-lg">${{ $s['costo_base'] }}</p>
        </div>

        <div class="mt-4 flex flex-col gap-2">
            <a href="{{ route('servicio.detalle', $s['id_servicio']) }}"
                class="w-full text-center border border-blue-700 text-blue-700 py-2 rounded hover:bg-blue-50 font-semibold block">
                Ver detalle
            </a>

            <form action="{{ route('carrito.agregar') }}" method="POST">
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $s['id_servicio'] }}">
                <input type="hidden" name="nombre" value="{{ $s['nombre'] }}">
                <input type="hidden" name="costo_base" value="{{ $s['costo_base'] }}">
                <input type="hidden" name="imagen1" value="{{ $s['imagen1'] ?? '' }}">
                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800 font-semibold">
                     Agregar al carrito
                </button>
            </form>
        </div>
    </div>

</div>
@endforeach
@else
<p class="text-gray-500">No hay servicios disponibles.</p>
@endif

</div>
@endsection