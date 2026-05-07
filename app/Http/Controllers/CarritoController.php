<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarritoController extends Controller
{
    public function catalogo()
    {
        $response = Http::get('https://serviciosdom-api-production.up.railway.app/api/servicios');
        $servicios = $response->json();

        return view('catalogo', compact('servicios'));
    }

    public function agregar(Request $request)
{
    $carrito = session('carrito', []);

    $carrito[] = [
        'id_servicio' => $request->id_servicio,
        'nombre' => $request->nombre,
        'costo_base' => $request->costo_base,
        'cantidad' => 1,
        'imagen1' => $request->imagen1,
    ];

    session(['carrito' => $carrito]);
    return redirect()->route('carrito');
}


    public function verCarrito()
{
    $carrito = session('carrito', []);
    $response = Http::get('https://serviciosdom-api-production.up.railway.app/api/zonas');
    $zonas = $response->json() ?? [];
    return view('carrito', compact('carrito', 'zonas'));
}
    public function quitar($index)
    {
        $carrito = session('carrito', []);
        unset($carrito[$index]);
        session(['carrito' => array_values($carrito)]);
        return redirect()->route('carrito');
    }

    public function detalle($id)
{
    $response = Http::get("https://serviciosdom-api-production.up.railway.app/api/servicios/{$id}");
    $servicio = $response->json();
    return view('detalle-servicio', compact('servicio'));
}

public function vaciar()
{
    session()->forget('carrito');
    return redirect()->route('carrito');
}

}
