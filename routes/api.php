<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Admin\ProductoController as ProductoAdminController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Api\CartController;

// 1. LISTADO Y FILTROS
Route::get('/productos', [ProductoApiController::class, 'index']);
Route::get('/categorias', [ProductoApiController::class, 'getCategorias']);
Route::get('/modelos', [ProductoApiController::class, 'getModelos']);
Route::get('/productos/categoria/{nombre}', [ProductoApiController::class, 'getProductosByCategoria']);

// 2. CREACIÓN (GLOBAL)
Route::post('/productos', [ProductoApiController::class, 'storeGlobal']);
Route::post('/productos/global', [ProductoApiController::class, 'storeGlobal']);

// 3. ELIMINACIÓN (Rutas específicas para evitar conflictos)
Route::match(['DELETE', 'POST', 'GET'], '/productos/{id}/delete', [ProductoAdminController::class, 'destroy']);
Route::delete('/productos/{id}', [ProductoAdminController::class, 'destroy']);

// 4. ACTUALIZACIÓN (EDICIÓN)
Route::match(['GET', 'POST', 'PUT', 'PATCH'], '/productos/update/{id}', [ProductoApiController::class, 'update']);
Route::match(['PUT', 'PATCH', 'POST'], '/productos/{id}', [ProductoApiController::class, 'update']);

// 5. AUTENTICACIÓN Y USUARIOS
Route::post('/login', [AuthenticatedSessionController::class, 'loginApi']);
Route::post('/logout', [AuthenticatedSessionController::class, 'logoutApi']);
Route::post('/register', [AuthenticatedSessionController::class, 'registerApi']);
Route::get('/users', [UsuarioController::class, 'indexApi']);
Route::post('/users', [UsuarioController::class, 'storeApi']);
Route::put('/users/{id}', [UsuarioController::class, 'updateApi']);
Route::delete('/users/{id}', [UsuarioController::class, 'destroyApi']);

// 6. CARRITO
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem']);

// 7. ADMIN STATS
Route::get('/admin/stats', [CartController::class, 'getStats']);