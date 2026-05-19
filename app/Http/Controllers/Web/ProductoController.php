<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function categoria($categoria)
    {
        // Usando Query Builder para evitar problemas de pluralización automática
        $productos = \DB::table('productos')
            ->join('modelos', 'productos.modelo_id', '=', 'modelos.id')
            ->join('categorias', 'modelos.categoria_id', '=', 'categorias.id')
            ->join('producto_variacions', 'productos.id', '=', 'producto_variacions.producto_id')
            ->leftJoin('producto_imagens', 'productos.id', '=', 'producto_imagens.producto_id')
            ->whereRaw('LOWER(categorias.nombre) = ?', [strtolower($categoria)])
            ->where('producto_variacions.stock', '>', 0)
            ->select(
                'productos.id',
                'modelos.nombre as modelo_nombre',
                'producto_imagens.url as imagen',
                \DB::raw('MIN(producto_variacions.precio) as precio_min')
            )
            ->groupBy('productos.id', 'modelos.nombre', 'producto_imagens.url')
            ->get();

        return view('pages.categoria', [
            'productos' => $productos,
            'categoria' => ucfirst($categoria),
            'banner' => 'img/banner.jpg'
        ]);
    }

    // 🔥 ESTE ES EL QUE TE FALTA
    public function destroy($id)
    {
        try {
            return \DB::transaction(function() use ($id) {
                // 1. Limpiar Carrito y Detalles
                \DB::table('cart_items')->where('producto_id', $id)->delete();
                \DB::table('carrito_detalle')->where('producto_id', $id)->delete();
                
                // 2. Limpiar Variaciones e Imágenes
                \DB::table('producto_variacions')->where('producto_id', $id)->delete();
                
                $imagenes = \DB::table('producto_imagens')->where('producto_id', $id)->get();
                foreach ($imagenes as $img) {
                    $filePath = public_path($img->url);
                    if (file_exists($filePath)) { @unlink($filePath); }
                }
                \DB::table('producto_imagens')->where('producto_id', $id)->delete();
                
                // 3. Eliminar Producto
                \DB::table('productos')->where('id', $id)->delete();
                
                return response()->json(['success' => true]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 