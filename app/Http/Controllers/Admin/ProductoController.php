<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Modelo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function storeApi(Request $request)
    {
        Log::info('--- PETICIÓN DE CREACIÓN ---', $request->all());
        try {
            return DB::transaction(function() use ($request) {
                $catNom = $request->input('categoria_nombre', 'General');
                $categoria = Categoria::firstOrCreate(['nombre' => $catNom]);
                $modNom = $request->input('modelo_nombre', 'Sin nombre');
                $modelo = Modelo::firstOrCreate(['nombre' => $modNom, 'categoria_id' => $categoria->id]);
                $producto = Producto::create(['modelo_id' => $modelo->id, 'estado' => 'activo']);

                if ($request->hasFile('imagen')) {
                    $file = $request->file('imagen');
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    
                    // Guardar directamente en public/storage/productos
                    $file->move(public_path('storage/productos'), $filename);
                    
                    DB::table('producto_imagens')->insert([
                        'producto_id' => $producto->id,
                        'url' => 'storage/productos/' . $filename
                    ]);
                }

                $tallaNum = $request->input('talla_numero', '38');
                $tallaId = DB::table('tallas')->where('numero', $tallaNum)->value('id') 
                           ?: DB::table('tallas')->insertGetId(['numero' => $tallaNum]);

                $colorNom = $request->input('color_primario', 'Negro');
                $colorId = DB::table('colors')->where('nombre', $colorNom)->value('id') 
                           ?: DB::table('colors')->insertGetId(['nombre' => $colorNom]);

                DB::table('producto_variacions')->insert([
                    'producto_id' => $producto->id,
                    'talla_id' => $tallaId,
                    'color_id' => $colorId,
                    'costo' => (double)$request->input('costo', 0),
                    'precio' => (double)$request->input('precio', 0),
                    'stock' => (int)$request->input('stock', 0)
                ]);

                return response()->json(['success' => true, 'id' => $producto->id], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function indexApi()
    {
        try {
            $productos = DB::table('productos')
                ->join('modelos', 'productos.modelo_id', '=', 'modelos.id')
                ->join('categorias', 'modelos.categoria_id', '=', 'categorias.id')
                ->leftJoin('producto_imagens', 'productos.id', '=', 'producto_imagens.producto_id')
                ->select('productos.id', 'modelos.nombre as modelo_nombre', 'categorias.nombre as categoria_nombre', 'producto_imagens.url as imagen_url', 'productos.estado')
                ->get();

            return response()->json($productos->map(function($p) {
                $variaciones = DB::table('producto_variacions')->where('producto_id', $p->id)->get()->map(function($v) {
                    $v->precio = (int)$v->precio; // Forzamos a entero
                    return $v;
                });

                return [
                    'id' => $p->id,
                    'modelo' => [
                        'nombre' => $p->modelo_nombre,
                        'categoria' => ['nombre' => $p->categoria_nombre]
                    ],
                    'imagen' => $p->imagen_url ? "http://10.0.2.2:8000/" . str_replace('storage/storage/', 'storage/', $p->imagen_url) : null,
                    'estado' => $p->estado,
                    'variaciones' => $variaciones
                ];
            }));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function indexApiPorCategoria($categoriaNombre)
    {
        try {
            // Normalizar el nombre para que Niño y Niños funcionen igual
            $busqueda = str_replace('s', '', strtolower($categoriaNombre));
            
            $productos = DB::table('productos')
                ->join('modelos', 'productos.modelo_id', '=', 'modelos.id')
                ->join('categorias', 'modelos.categoria_id', '=', 'categorias.id')
                ->leftJoin('producto_imagens', 'productos.id', '=', 'producto_imagens.producto_id')
                ->where('categorias.nombre', 'LIKE', '%' . $busqueda . '%')
                ->select('productos.id', 'modelos.nombre as modelo_nombre', 'categorias.nombre as categoria_nombre', 'producto_imagens.url as imagen_url', 'productos.estado')
                ->get();

            return response()->json($productos->map(function($p) {
                $variaciones = DB::table('producto_variacions')->where('producto_id', $p->id)->get()->map(function($v) {
                    $v->precio = (int)$v->precio; // Forzamos a entero
                    return $v;
                });

                return [
                    'id' => $p->id,
                    'modelo' => [
                        'nombre' => $p->modelo_nombre,
                        'categoria' => ['nombre' => $p->categoria_nombre]
                    ],
                    'imagen' => $p->imagen_url ? "http://10.0.2.2:8000/" . str_replace('storage/storage/', 'storage/', $p->imagen_url) : null,
                    'estado' => $p->estado,
                    'variaciones' => $variaciones
                ];
            }));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        Log::info("🗑️ ELIMINACIÓN REQUERIDA PARA PRODUCTO ID: $id");
        try {
            return DB::transaction(function() use ($id) {
                // 💥 DESACTIVAR RESTRICCIONES
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                
                // 1. Obtener IDs de las variaciones del producto
                $variacionIds = DB::table('producto_variacions')->where('producto_id', $id)->pluck('id');

                // 2. Limpiar Carrito Detalle usando las variaciones
                if ($variacionIds->isNotEmpty()) {
                    DB::table('carrito_detalle')->whereIn('producto_variacion_id', $variacionIds)->delete();
                }

                // 3. Limpiar otras tablas relacionadas al producto
                DB::table('cart_items')->where('producto_id', $id)->delete();
                DB::table('producto_variacions')->where('producto_id', $id)->delete();
                DB::table('producto_imagens')->where('producto_id', $id)->delete();
                
                // 4. BORRAR PRODUCTO
                $deleted = DB::table('productos')->where('id', $id)->delete();
                
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                
                return response()->json(['success' => true]);
            });
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Log::error("❌ ERROR AL ELIMINAR $id: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
