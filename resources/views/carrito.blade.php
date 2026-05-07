@extends('layouts.cliente')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">🛒 Mi Carrito</h1>

@if(empty($carrito))
<p class="text-gray-500">Tu carrito está vacío.</p>
<a href="{{ route('catalogo') }}" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
    Ver catálogo
</a>
@else

<div class="flex flex-col lg:flex-row gap-6 items-start">

    {{-- IZQUIERDA: TABLA GRANDE --}}
    <div class="w-full lg:w-2/3 bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-gray-700">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-3 text-left">Servicio</th>
            <th class="px-4 py-3 text-center">Precio</th>
            <th class="px-4 py-3 text-center">Quitar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carrito as $index => $item)
        <tr class="border-b">
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    @if(!empty($item['imagen1']))
                    <img src="https://serviciosdom-api-production.up.railway.app/storage/{{ $item['imagen1'] }}"
                        class="w-10 h-10 object-cover rounded flex-shrink-0">
                    @else
                    <div class="w-10 h-10 bg-gray-200 rounded flex-shrink-0"></div>
                    @endif
                    <span>{{ $item['nombre'] }}</span>
                </div>
            </td>
            <td class="px-4 py-3 text-center">${{ $item['costo_base'] }}</td>
            <td class="px-4 py-3 text-center">
                <form action="{{ route('carrito.quitar', $index) }}" method="POST">
                    @csrf
                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">🗑️</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>

    {{-- DERECHA: PAGO PEQUEÑO --}}
    <div class="w-full lg:w-1/3 bg-white rounded-lg shadow p-5">
        <div class="w-full lg:w-64 bg-white rounded-lg shadow p-5">

        <div class="mb-4 text-sm text-gray-600">
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span id="subtotal">${{ collect($carrito)->sum('costo_base') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Recargo zona:</span>
                <span id="recargo">$0.00</span>
            </div>
            <div class="flex justify-between font-bold text-gray-800 text-lg mt-2 border-t pt-2">
                <span>Total:</span>
                <span id="total">${{ collect($carrito)->sum('costo_base') }}</span>
            </div>
        </div>

        <form action="{{ route('carrito.vaciar') }}" method="POST" onsubmit="return confirm('¿Vaciar carrito?')">
            @csrf
            <button class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 font-semibold mb-4">
                Vaciar carrito
            </button>
        </form>

        <form action="{{ route('pedido.confirmar') }}" method="POST">
            @csrf
            <input type="hidden" name="costo_total" id="costo_total" value="{{ collect($carrito)->sum('costo_base') }}">

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Domicilio</label>
                <input type="text" name="domicilio"
                    class="w-full border rounded px-3 py-2 text-sm"
                    placeholder="Tu dirección completa" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Zona</label>
                <select name="id_zona" id="selectZona" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="" data-recargo="0">Selecciona una zona</option>
                    @foreach($zonas as $z)
                    <option value="{{ $z['id_zona'] }}" data-recargo="{{ $z['recargo'] }}">
                        {{ $z['nombre'] }} (Recargo: ${{ $z['recargo'] }})
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 font-semibold">
                Confirmar Pedido
            </button>
        </form>
    </div>

</div>

@endif

<script>
const subtotal = {{ collect($carrito)->sum('costo_base') }};

document.getElementById('selectZona').addEventListener('change', function() {
    const recargo = parseFloat(this.options[this.selectedIndex].dataset.recargo) || 0;
    const total = subtotal + recargo;

    document.getElementById('recargo').textContent = '$' + recargo.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
    document.getElementById('costo_total').value = total.toFixed(2);
});
</script>

@endsection
