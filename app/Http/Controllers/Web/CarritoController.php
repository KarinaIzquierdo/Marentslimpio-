<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    // =========================
    // AGREGAR
    // =========================
    public function agregar(Request $request)
    {
        $producto_id = $request->producto_id;
        $talla = $request->talla;
        $cantidad = (int) $request->cantidad;

        if (!$producto_id || !$talla || $cantidad <= 0) {
            return back()->with('error', 'Datos inválidos');
        }

        $producto = Producto::with('variaciones.talla', 'modelo.categoria', 'imagen')
            ->findOrFail($producto_id);

        $variacion = $producto->variaciones
            ->where('talla.numero', $talla)
            ->first();

        if (!$variacion) {
            return back()->with('error', 'Talla no disponible');
        }

        if ($cantidad > $variacion->stock) {
            return back()->with('error', 'Stock insuficiente');
        }

        $carrito = session()->get('carrito', []);

        $key = $producto_id . '-' . $talla;

        if (isset($carrito[$key])) {

            $nuevaCantidad = $carrito[$key]['cantidad'] + $cantidad;

            if ($nuevaCantidad > $variacion->stock) {
                return back()->with('error', 'No puedes agregar más de lo disponible');
            }

            $carrito[$key]['cantidad'] = $nuevaCantidad;

        } else {

            $carrito[$key] = [
                'producto_id' => $producto_id,
                'nombre' => $producto->modelo->nombre,
                'talla' => $talla,
                'precio' => $variacion->precio,
                'cantidad' => $cantidad,
                'imagen' => $producto->imagen?->url,
                'categoria' => strtolower($producto->modelo->categoria->nombre)
            ];
        }

        session()->put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito');
    }

    // =========================
    // VER CARRITO
    // =========================
    public function index()
    {
        $carrito = session()->get('carrito', []);

        return view('pages.carrito', compact('carrito'));
    }

    // =========================
    // ELIMINAR PRODUCTO
    // =========================
    public function eliminar($key)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado');
    }

    // =========================
    // ACTUALIZAR CANTIDAD
    // =========================
    public function actualizar(Request $request, $key)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {

            $cantidad = max(1, (int)$request->cantidad);

            $carrito[$key]['cantidad'] = $cantidad;

            session()->put('carrito', $carrito);
        }

        return back();
    }
}