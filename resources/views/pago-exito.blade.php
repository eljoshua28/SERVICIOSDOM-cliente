@extends('layouts.cliente')

@section('content')
<div class="max-w-lg mx-auto text-center">

    <div class="bg-white rounded-lg shadow p-8">

        <div class="text-6xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-green-600 mb-2">¡Pago exitoso!</h1>
        <p class="text-gray-500 mb-6">Tu pedido ha sido pagado correctamente.</p>

        <div class="bg-gray-50 rounded-lg p-4 text-left mb-6">
            <h2 class="text-lg font-bold text-gray-700 mb-3">Detalles de la transacción</h2>
            <p class="text-sm text-gray-600 mb-1">
                <strong>Pedido #:</strong> {{ $pedido['id_solicitud'] }}
            </p>
            <p class="text-sm text-gray-600 mb-1">
                <strong>Código de transacción:</strong>
                <span class="font-mono text-xs">{{ $pedido['numero_transaccion'] ?? 'N/A' }}</span>
            </p>
            <p class="text-sm text-gray-600 mb-1">
                <strong>Estado:</strong>
                <span class="text-green-600 font-semibold">{{ $pedido['estado'] }}</span>
            </p>
            <p class="text-sm text-gray-600 mb-1">
                <strong>Fecha:</strong> {{ $pedido['fecha_solicitud'] }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Total pagado:</strong> ${{ $pedido['costo_final'] ?? '-' }} MXN
            </p>
        </div>

        <a href="{{ route('mis.pedidos') }}"
            class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 font-semibold inline-block">
            Ver mis pedidos
        </a>

    </div>

</div>
@endsection
