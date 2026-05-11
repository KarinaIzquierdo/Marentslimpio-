<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\ProductoController;
use App\Http\Controllers\Web\CarritoController;

/*
|--------------------------------------------------------------------------
| WEB
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
});

// PRODUCTOS
Route::get('/categoria/{categoria}', [ProductoController::class, 'categoria']);
Route::get('/producto/{id}', [ProductoController::class, 'show']);

// CARRITO
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/eliminar/{key}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/actualizar/{key}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');

// OTROS
Route::view('/favoritos', 'pages.favoritos');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
require __DIR__.'/navegacion.php';
require __DIR__.'/admin.php';