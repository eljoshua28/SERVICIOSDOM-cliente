<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PagoController extends Controller
{
    public function checkout($id)
    {
        $usuario = session('usuario');
        $response = Http::get("http://127.0.0.1:8000/api/solicitudes/{$id}");
        $pedido = $response->json();

        return view('pago', compact('pedido'));
    }

    public function procesar(Request $request, $id)
    {
        $usuario = session('usuario');
        $response = Http::get("http://127.0.0.1:8000/api/solicitudes/{$id}");
        $pedido = $response->json();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $total = $pedido['costo_final'] ?? collect(session('carrito', []))->sum('costo_base');
            $totalCentavos = intval(floatval($total) * 100);

            $paymentIntent = PaymentIntent::create([
                'amount' => $totalCentavos,
                'currency' => 'mxn',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
            ]);

            // Guardar número de transacción en la API
            Http::put("http://127.0.0.1:8000/api/solicitudes/{$id}", [
                'numero_transaccion' => $paymentIntent->id,
                'estado' => 'en_proceso'
            ]);

            return redirect()->route('pago.exito', $id);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function exito($id)
    {
        $response = Http::get("http://127.0.0.1:8000/api/solicitudes/{$id}");
        $pedido = $response->json();
        return view('pago-exito', compact('pedido'));
    }
}
