<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

  public function login(Request $request)
{
    $request->validate([
        'correo' => 'required|email',
        'password' => 'required'
    ]);

    $response = Http::post('https://serviciosdom-api-production.up.railway.app/api/login', [
        'correo' => $request->correo,
        'password' => $request->password
    ]);

    if (!$response->successful()) {
        return back()->withErrors(['correo' => 'Credenciales incorrectas.']);
    }

    $usuario = $response->json();

    session(['usuario' => (object)[
        'id_usuario' => $usuario['id_usuario'],
        'nombre' => $usuario['nombre'],
        'correo' => $usuario['correo'],
        'telefono' => $usuario['telefono'] ?? null,
        'password' => $usuario['password'] ?? ''
    ]]);

    return redirect('/catalogo');
}


public function registro(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'correo' => 'required|email',
        'password' => 'required|min:6',
        'telefono' => 'nullable'
    ]);

    $response = Http::post('https://serviciosdom-api-production.up.railway.app/api/usuarios', [
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'password' => bcrypt($request->password),
        'telefono' => $request->telefono
    ]);

    if ($response->successful()) {
        $usuario = $response->json();
        session(['usuario' => (object)[
            'id_usuario' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'correo' => $usuario['correo'],
            'telefono' => $usuario['telefono'] ?? null,
            'password' => $usuario['password'] ?? ''
        ]]);
        return redirect('/catalogo');
    }

    return back()->withErrors(['correo' => 'Error al registrarse. El correo puede estar en uso.']);
}

}
