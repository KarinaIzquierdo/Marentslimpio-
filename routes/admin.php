<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductoController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // =====================
        // DASHBOARD
        // =====================
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // =====================
        // USUARIOS
        // =====================
    // Usuarios
    Route::get('/usuarios', [App\Http\Controllers\Admin\UsuarioController::class, 'index'])->name('admin.usuarios');
    Route::get('/usuarios/{id}/edit', [App\Http\Controllers\Admin\UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [App\Http\Controllers\Admin\UsuarioController::class, 'update'])->name('admin.usuarios.update');

        // =====================
        // PRODUCTOS
        // =====================
        Route::get('/productos', [ProductoController::class, 'index'])
            ->name('productos');

        // =====================
        // AJAX / SELECTS
        // =====================
        Route::get('/modelos/{categoria}', [ProductoController::class, 'getModelos'])
            ->name('modelos');

        Route::get('/tallas/{modelo}', [ProductoController::class, 'getTallas'])
            ->name('tallas');

        Route::get('/colores/{modelo}', [ProductoController::class, 'getColores'])
            ->name('colores');

        Route::get('/producto-info/{modelo}', [ProductoController::class, 'getProductoInfo'])
            ->name('producto.info');

        // =====================
        // STOCK
        // =====================
        Route::post('/stock-global', [ProductoController::class, 'agregarStockGlobal'])
            ->name('stock.global');

        Route::post('/stock-producto', [ProductoController::class, 'agregarStockProducto'])
            ->name('stock.producto');

    });