<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = session('usuario');
        return view('perfil', compact('usuario'));
    }

    public function update(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'nullable'
        ]);

        $response = Http::put("https://serviciosdom-api-production.up.railway.app/api/usuarios/{$usuario->id_usuario}", [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono
        ]);

        if ($response->successful()) {
            $usuarioActualizado = $response->json();
            session(['usuario' => (object) $usuarioActualizado]);
            return redirect()->route('perfil')->with('success', 'Perfil actualizado.');
        }

        return back()->withErrors(['error' => 'Error al actualizar perfil.']);
    }

    public function cambiarPassword(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'password_actual' => 'required',
            'password_nuevo' => 'required|min:6',
            'password_confirmar' => 'required|same:password_nuevo'
        ]);

        if ($request->password_actual !== $usuario->password) {
            return back()->withErrors(['password_actual' => 'Contraseña actual incorrecta.']);
        }

        Http::put("https://serviciosdom-api-production.up.railway.app/api/usuarios/{$usuario->id_usuario}", [
            'nombre' => $usuario->nombre,
            'correo' => $usuario->correo,
            'telefono' => $usuario->telefono,
            'password' => $request->password_nuevo
        ]);

        return redirect()->route('perfil')->with('success', 'Contraseña actualizada.');
    }
}
