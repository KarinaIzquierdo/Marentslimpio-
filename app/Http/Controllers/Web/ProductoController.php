<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function categoria($categoria)
    {
        $productos = Producto::with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla'
        ])
        ->whereHas('modelo.categoria', function ($q) use ($categoria) {
            $q->whereRaw('LOWER(nombre) = ?', [strtolower($categoria)]);
        })
        ->whereHas('variaciones', function ($q) {
            $q->where('stock', '>', 0);
        })
        ->get();

        return view('pages.categoria', [
            'productos' => $productos,
            'categoria' => ucfirst($categoria),
            'banner' => 'img/banner.jpg'
        ]);
    }

    // 🔥 ESTE ES EL QUE TE FALTA
    public function show($id)
    {
        $producto = Producto::with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla',
            'variaciones.colorPrimario'
        ])->findOrFail($id);

        $variaciones = $producto->variaciones;

        $colores = $variaciones
            ->pluck('colorPrimario')
            ->filter()
            ->unique('id')
            ->values();

        $tallas = $variaciones
            ->pluck('talla.numero')
            ->unique()
            ->sort()
            ->values();

        $precio = $variaciones->avg('precio');

        return view('producto.show', compact(
            'producto',
            'colores',
            'tallas',
            'precio'
        ));
    }
} 