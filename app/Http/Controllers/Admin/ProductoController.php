<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['modelo.categoria', 'variaciones.colorPrimario', 'variaciones.talla', 'imagen'])->get();
        $categorias = Categoria::all();
        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function destroy($id)
    {
        Log::info("ELIMINACION PRODUCTO ID: $id");
        try {
            return DB::transaction(function() use ($id) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                $variacionIds = DB::table('producto_variacion')->where('producto_id', $id)->pluck('id');
                if ($variacionIds->isNotEmpty()) {
                    DB::table('carrito_detalle')->whereIn('producto_variacion_id', $variacionIds)->delete();
                }
                DB::table('producto_variacion')->where('producto_id', $id)->delete();
                DB::table('producto_imagen')->where('producto_id', $id)->delete();
                DB::table('producto_personalizacion')->where('producto_id', $id)->delete();
                DB::table('producto')->where('id', $id)->delete();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                return response()->json(['success' => true]);
            });
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Log::error("ERROR AL ELIMINAR $id: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
