<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Api\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- PRODUCTOS ---
Route::get('/productos', [ProductoController::class, 'indexApi']);
Route::get('/productos/categoria/{categoriaNombre}', [ProductoController::class, 'indexApiPorCategoria']);
Route::post('/productos', [ProductoController::class, 'storeApi']);
Route::put('/productos/{id}', [ProductoController::class, 'updateApi']);
// RUTA UNIFICADA DE ELIMINACIÓN (Ambos nombres para asegurar compatibilidad)
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);
Route::delete('/productos/destroy/{id}', [ProductoController::class, 'destroy']); // RUTA ÚNICA Y FINAL

// --- AUTH ---
Route::post('/login', [AuthenticatedSessionController::class, 'loginApi']);
Route::post('/register', [RegisteredUserController::class, 'registerApi']);

// --- USUARIOS ---
Route::get('/users', [UsuarioController::class, 'indexApi']);
Route::put('/users/{id}', [UsuarioController::class, 'updateApi']);
Route::delete('/users/{id}', [UsuarioController::class, 'destroyApi']);

// --- CARRITO Y DASHBOARD ---
Route::get('/cart', [CartController::class, 'index']);
Route::get('/admin/stats', [CartController::class, 'getStats']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem']);
