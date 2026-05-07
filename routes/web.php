<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PagoController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);


Route::middleware('auth.cliente')->group(function () {
    Route::get('/catalogo', [CarritoController::class, 'catalogo'])->name('catalogo');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito', [CarritoController::class, 'verCarrito'])->name('carrito');
    Route::post('/carrito/quitar/{index}', [CarritoController::class, 'quitar'])->name('carrito.quitar');
    Route::post('/pedido/confirmar', [PedidoController::class, 'confirmar'])->name('pedido.confirmar');
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('mis.pedidos');
    Route::post('/pedido/{id}/cancelar', [PedidoController::class, 'cancelar'])->name('pedido.cancelar');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');
    Route::get('/catalogo/{id}', [CarritoController::class, 'detalle'])->name('servicio.detalle');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::get('/pago/{id}', [PagoController::class, 'checkout'])->name('pago.checkout');
    Route::post('/pago/{id}', [PagoController::class, 'procesar'])->name('pago.procesar');
    Route::get('/pago/{id}/exito', [PagoController::class, 'exito'])->name('pago.exito');
});
