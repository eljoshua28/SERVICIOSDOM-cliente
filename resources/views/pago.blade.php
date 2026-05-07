@extends('layouts.cliente')

@section('content')
<div class="max-w-lg mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6"> Pagar Pedido #{{ $pedido['id_solicitud'] }}</h1>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-700 mb-3">Resumen del pedido</h2>
        <p class="text-sm text-gray-600"><strong>Domicilio:</strong> {{ $pedido['domicilio'] }}</p>
        <p class="text-sm text-gray-600"><strong>Estado:</strong> {{ $pedido['estado'] }}</p>
        <p class="text-lg font-bold text-blue-700 mt-3">
            Total: ${{ $pedido['costo_final'] ?? 'Por definir' }} MXN
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Datos de pago</h2>

        <form id="formPago" action="{{ route('pago.procesar', $pedido['id_solicitud']) }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method_id" id="payment_method_id">

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Número de tarjeta</label>
                <div id="card-element" class="border rounded px-3 py-3 bg-white"></div>
            </div>

            <div id="card-errors" class="text-red-500 text-sm mb-4"></div>

            <button type="submit" id="btnPagar"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 font-semibold">
                 Pagar ahora
            </button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{ env("STRIPE_KEY") }}');
const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount('#card-element');

const form = document.getElementById('formPago');
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    document.getElementById('btnPagar').disabled = true;
    document.getElementById('btnPagar').textContent = 'Procesando...';

    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
    });

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        document.getElementById('btnPagar').disabled = false;
        document.getElementById('btnPagar').textContent = ' Pagar ahora';
    } else {
        document.getElementById('payment_method_id').value = paymentMethod.id;
        form.submit();
    }
});
</script>
@endsection
