@extends('layouts.cliente')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">📋 Mis Pedidos</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(empty($pedidos))
<p class="text-gray-500">No tienes pedidos aún.</p>
<a href="{{ route('catalogo') }}" class="mt-4 inline-block bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
    Ver catálogo
</a>
@else

<div class="bg-white rounded-lg shadow overflow-x-auto">
<table class="w-full text-sm text-gray-700 text-center">
<thead class="bg-gray-100">
<tr>
    <th class="px-4 py-3">ID</th>
    <th class="px-4 py-3">Domicilio</th>
    <th class="px-4 py-3">Estado</th>
    <th class="px-4 py-3">Técnico</th>
    <th class="px-4 py-3">Fecha</th>
    <th class="px-4 py-3">Costo Final</th>
    <th class="px-4 py-3">Transacción</th>
    <th class="px-4 py-3">Acciones</th>
</tr>
</thead>
<tbody>
@foreach($pedidos as $p)
<tr class="border-b hover:bg-gray-50">
    <td class="px-4 py-3">{{ $p['id_solicitud'] }}</td>
    <td class="px-4 py-3">{{ $p['domicilio'] }}</td>
    <td class="px-4 py-3">
        <span class="px-2 py-1 rounded bg-gray-200">{{ $p['estado'] }}</span>
    </td>
    <td class="px-4 py-3">
        @if(!empty($p['tecnico']))
        <span class="text-gray-700">{{ $p['tecnico']['nombre'] }}</span>
        @else
        <span class="text-gray-400 text-xs">Sin asignar</span>
        @endif
    </td>
    <td class="px-4 py-3">{{ $p['fecha_solicitud'] }}</td>
    <td class="px-4 py-3">${{ $p['costo_final'] ?? 'Por definir' }}</td>
    <td class="px-4 py-3">
        @if(!empty($p['numero_transaccion']))
        <span class="font-mono text-xs text-green-600">{{ $p['numero_transaccion'] }}</span>
        @else
        <span class="text-gray-400 text-xs">Sin pago</span>
        @endif
    </td>
    <td class="px-4 py-3">
        <div class="flex justify-center items-center gap-2 flex-wrap">

            <button onclick="verDetalles({{ $p['id_solicitud'] }})"
                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                Detalles
            </button>

            @if($p['estado'] === 'pendiente' && empty($p['numero_transaccion']))
            <a href="{{ route('pago.checkout', $p['id_solicitud']) }}"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                Pagar
            </a>
            @endif

            @if($p['estado'] === 'pendiente' && empty($p['numero_transaccion']))
            <form action="{{ route('pedido.cancelar', $p['id_solicitud']) }}" method="POST"
                onsubmit="return confirm('¿Cancelar este pedido?')">
                @csrf
                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Cancelar
                </button>
            </form>
            @elseif(!empty($p['numero_transaccion']))
            <a href="{{ route('pago.exito', $p['id_solicitud']) }}"
                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                Ver pago
            </a>
            @else
            <span class="text-gray-400 text-xs">No cancelable</span>
            @endif
        </div>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

@endif

{{-- MODAL --}}
<div id="modalDetalles" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-8">
<div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Detalles del Pedido <span id="modalIdSolicitud"></span></h2>
        <button onclick="cerrarModal()" class="text-gray-500 hover:text-red-600 text-2xl">&times;</button>
    </div>
    <div id="contenidoDetalles">
        <p class="text-gray-500 text-center">Cargando...</p>
    </div>
</div>
</div>

<script>
function verDetalles(idSolicitud) {
    document.getElementById('modalIdSolicitud').textContent = `#${idSolicitud}`;
    document.getElementById('modalDetalles').classList.remove('hidden');
    document.getElementById('contenidoDetalles').innerHTML = '<p class="text-gray-500 text-center">Cargando...</p>';

    fetch(`https://serviciosdom-api-production.up.railway.app/api/solicitudes/${idSolicitud}/detalles`)
        .then(res => res.json())
        .then(data => {
            let html = '';

            if (data.zona) {
                html += `<div class="mb-4 p-3 bg-blue-50 rounded">
                    <p class="text-sm text-gray-700"><strong>Zona:</strong> ${data.zona.nombre}</p>
                    <p class="text-sm text-gray-700"><strong>Recargo:</strong> $${data.zona.recargo}</p>
                </div>`;
            }

            if (!data.detalles || data.detalles.length === 0) {
                html += '<p class="text-gray-500 text-center">No hay servicios registrados.</p>';
                document.getElementById('contenidoDetalles').innerHTML = html;
                return;
            }

            html += `<table class="w-full text-sm text-center border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Servicio</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Precio Unitario</th>
                        <th class="px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>`;

            data.detalles.forEach(d => {
                html += `<tr class="border-b">
                    <td class="px-4 py-2">${d.servicio ? d.servicio.nombre : '-'}</td>
                    <td class="px-4 py-2">${d.cantidad}</td>
                    <td class="px-4 py-2">$${d.precio_unitario}</td>
                    <td class="px-4 py-2">$${d.subtotal}</td>
                </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById('contenidoDetalles').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('contenidoDetalles').innerHTML =
                '<p class="text-red-500 text-center">Error al cargar los servicios.</p>';
        });
}

function cerrarModal() {
    document.getElementById('modalDetalles').classList.add('hidden');
}
</script>

@endsection
