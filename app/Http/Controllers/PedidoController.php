<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidoController extends Controller
{
   public function confirmar(Request $request)
{
    $carrito = session('carrito', []);
    $usuario = session('usuario');

    if (empty($carrito)) {
        return redirect()->route('carrito');
    }

    $primerServicio = $carrito[0];
    $total = $request->costo_total ?? collect($carrito)->sum('costo_base');

    $response = Http::post('https://serviciosdom-api-production.up.railway.app/api/solicitudes', [
        'id_usuario' => $usuario->id_usuario,
        'id_servicio' => $primerServicio['id_servicio'],
        'id_zona' => $request->id_zona,
        'domicilio' => $request->domicilio,
        'estado' => 'pendiente',
        'costo_final' => $total
    ]);

    if ($response->successful()) {
        $solicitud = $response->json();

        foreach ($carrito as $item) {
            Http::post('https://serviciosdom-api-production.up.railway.app/api/detalles_pedidos', [
                'id_solicitud' => $solicitud['id_solicitud'],
                'id_servicio' => $item['id_servicio'],
                'cantidad' => 1,
                'precio_unitario' => $item['costo_base'],
                'subtotal' => $item['costo_base']
            ]);
        }

        session()->forget('carrito');
        return redirect()->route('mis.pedidos')->with('success', '¡Pedido confirmado!');
    }

    return back()->withErrors(['error' => 'Error al confirmar el pedido.']);
}

    public function misPedidos()
    {
        $usuario = session('usuario');
        $response = Http::get("https://serviciosdom-api-production.up.railway.app/api/usuarios/{$usuario->id_usuario}/solicitudes");
        $pedidos = $response->json() ?? [];

        return view('mis-pedidos', compact('pedidos'));
    }

    public function cancelar($id)
{
    Http::put("https://serviciosdom-api-production.up.railway.app/api/solicitudes/{$id}/cancelar");
    return redirect()->route('mis.pedidos')->with('success', 'Pedido cancelado.');
}

}
