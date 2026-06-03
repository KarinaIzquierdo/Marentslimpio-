<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoApiController extends Controller
{
    public function index()
    {
        try {
            $productos = DB::table('producto')->orderBy('id', 'desc')->get();
            $data = $productos->map(function ($p) {
                // Datos de Modelo y Categoría
                $modelo = DB::table('modelo')->where('id', $p->modelo_id)->first();
                $cat = $modelo ? DB::table('categoria')->where('id', $modelo->categoria_id)->first() : null;
                
                // Variaciones para Precio y Stock
                $vars = DB::table('producto_variacion')->where('producto_id', $p->id)->get();
                $primera = $vars->first();

                return [
                    'id' => (int)$p->id,
                    'modelo' => [
                        'nombre' => (string)($modelo->nombre ?? 'Sin Modelo'), 
                        'categoria' => ['nombre' => (string)($cat->nombre ?? 'General')]
                    ],
                    'imagen' => null, // Puedes activar esto después si tienes las URLs de imágenes
                    'estado' => (string)($p->estado ?? 'activo'),
                    'precio' => (double)($primera->precio ?? 0.0),
                    'costo' => (double)($primera->costo ?? 0.0),
                    'stock' => (int)($vars->sum('stock') ?? 0),
                    'variaciones' => $vars->map(function($v) {
                        return ['id' => (int)$v->id, 'precio' => (double)($v->precio ?? 0.0), 'stock' => (int)($v->stock ?? 0)];
                    })->values()->all()
                ];
            });
            return response()->json($data->values()->all(), 200);
        } catch (\Exception $e) {
            Log::error("Error en productos: " . $e->getMessage());
            return response()->json([], 200);
        }
    }

    public function getCategorias() { return response()->json(DB::table('categoria')->get(), 200); }
    public function getModelos() { return response()->json(DB::table('modelo')->get(), 200); }

    public function storeGlobal(Request $request)
    {
        try {
            Log::info("📥 PETICIÓN DE GUARDADO RECIBIDA: " . json_encode($request->all()));

            $result = DB::transaction(function () use ($request) {
                // Sincronizar nombres de variables con los campos de la App y BD
                $modelo_nombre = $request->input('modelo_nombre') ?: $request->input('modelo') ?: 'Sin nombre';
                $categoria_nombre = $request->input('categoria_nombre') ?: $request->input('categoria') ?: 'General';
                $color_nombre = $request->input('color_primario') ?: $request->input('color') ?: 'Estándar';
                $tallas_data = $request->input('tallas');
                $precio = (double)$request->input('precio', 0);
                $costo = (double)$request->input('costo', 0);

                // 1. Obtener o crear Categoría
                $categoria_id = DB::table('categoria')->where('nombre', $categoria_nombre)->value('id');
                if (!$categoria_id) {
                    $categoria_id = DB::table('categoria')->insertGetId(['nombre' => $categoria_nombre]);
                }

                // 2. Obtener o crear Modelo
                $modelo_id = DB::table('modelo')->where('nombre', $modelo_nombre)->where('categoria_id', $categoria_id)->value('id');
                if (!$modelo_id) {
                    $modelo_id = DB::table('modelo')->insertGetId([
                        'nombre' => $modelo_nombre,
                        'categoria_id' => $categoria_id
                    ]);
                }

                // 3. Obtener o crear Color
                $color_id = DB::table('color')->where('nombre', $color_nombre)->value('id');
                if (!$color_id) {
                    $color_id = DB::table('color')->insertGetId(['nombre' => $color_nombre]);
                }

                // 4. Crear Producto
                $producto_id = DB::table('producto')->insertGetId([
                    'modelo_id' => $modelo_id,
                    'estado' => 'activo'
                ]);

                // 5. Crear Variaciones
                if ($tallas_data && is_array($tallas_data)) {
                    // Si viene como lista de tallas (proceso masivo)
                    foreach ($tallas_data as $item) {
                        $numero = str_replace(['T', 't'], '', $item['numero']);
                        $talla_id = DB::table('talla')->where('numero', $numero)->value('id');
                        if (!$talla_id) {
                            $talla_id = DB::table('talla')->insertGetId(['numero' => $numero]);
                        }

                        DB::table('producto_variacion')->insert([
                            'producto_id' => $producto_id,
                            'talla_id' => $talla_id,
                            'color_id' => $color_id,
                            'stock' => (int)($item['stock'] ?? 0),
                            'precio' => $precio,
                            'costo' => $costo
                        ]);
                    }
                } else {
                    // Si viene una sola talla (proceso simple desde el diálogo)
                    $talla_numero = $request->input('talla_numero') ?: '35';
                    $stock = (int)$request->input('stock', 0);
                    
                    $talla_numero_limpio = str_replace(['T', 't'], '', (string)$talla_numero);
                    $talla_id = DB::table('talla')->where('numero', $talla_numero_limpio)->value('id');
                    if (!$talla_id) {
                        $talla_id = DB::table('talla')->insertGetId(['numero' => $talla_numero_limpio]);
                    }

                    DB::table('producto_variacion')->insert([
                        'producto_id' => $producto_id,
                        'talla_id' => $talla_id,
                        'color_id' => $color_id,
                        'stock' => $stock,
                        'precio' => $precio,
                        'costo' => $costo
                    ]);
                }
                
                return $producto_id;
            });

            Log::info("✅ PRODUCTO CREADO CON ID: " . $result);
            return response()->json(['success' => true, 'id' => $result], 200);

        } catch (\Exception $e) {
            Log::error("❌ ERROR AL GUARDAR: " . $e->getMessage());
            // Si hay un error, intentamos responder algo para que la app no se bloquee
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function crearProductoSimple(Request $request)
    {
        try {
            Log::info("📥 CREAR PRODUCTO SIMPLE: " . json_encode($request->all()));
            
            $result = DB::transaction(function () use ($request) {
                // Soportar tanto nombres de campos de la app como los estándar
                $modNom = $request->input('modelo_nombre') ?: $request->input('modelo') ?: 'Sin nombre';
                $catInput = $request->input('categoria_id') ?: $request->input('categoria');
                $colorNom = $request->input('color_primario') ?: $request->input('color') ?: 'Estándar';
                $tallaNum = $request->input('talla_numero') ?: $request->input('talla') ?: '35';
                $precio = (double)$request->input('precio', 0);
                $costo = (double)$request->input('costo', 0);
                $stock = (int)$request->input('stock', 0);

                // 1. Resolver Categoría
                $catId = null;
                if (is_numeric($catInput)) {
                    $catId = (int)$catInput;
                } else if ($catInput) {
                    // Mapeo flexible de nombres comunes a lo que hay en BD
                    $catMapeo = [
                        'mujer' => 'Mujer',
                        'dama' => 'Mujer',
                        'hombre' => 'Hombre',
                        'caballero' => 'Hombre',
                        'niños' => 'Niños',
                        'ninos' => 'Niños',
                        'niño' => 'Niños',
                        'niña' => 'Niños',
                        'pisa huevos' => 'Pisa huevos',
                        'pisahuevos' => 'Pisa huevos',
                        'outlet' => 'Outlet'
                    ];
                    
                    $nombreNormalizado = strtolower(trim($catInput));
                    $nombreBuscar = $catMapeo[$nombreNormalizado] ?? $catInput;

                    $catId = DB::table('categoria')->where('nombre', $nombreBuscar)->value('id');
                    
                    // Si aún no existe, la creamos
                    if (!$catId) {
                        $catId = DB::table('categoria')->insertGetId(['nombre' => $nombreBuscar]);
                    }
                }

                // Fallback si no hay categoría
                if (!$catId) {
                    $catId = DB::table('categoria')->where('nombre', 'General')->value('id');
                    if (!$catId) $catId = DB::table('categoria')->insertGetId(['nombre' => 'General']);
                }

                // 2. Crear Modelo
                $modId = DB::table('modelo')->insertGetId([
                    'nombre' => $modNom,
                    'categoria_id' => $catId
                ]);

                // 3. Resolver Color
                $colorId = DB::table('color')->where('nombre', $colorNom)->value('id');
                if (!$colorId) {
                    $colorId = DB::table('color')->insertGetId(['nombre' => $colorNom]);
                }

                // 4. Crear Producto
                $productoId = DB::table('producto')->insertGetId([
                    'modelo_id' => $modId,
                    'estado' => 'activo'
                ]);

                // 5. Resolver Talla
                $tallaNormalizada = str_replace(['T', 't'], '', (string)$tallaNum);
                $tallaId = DB::table('talla')->where('numero', $tallaNormalizada)->value('id');
                if (!$tallaId) {
                    $tallaId = DB::table('talla')->insertGetId(['numero' => $tallaNormalizada]);
                }

                // 6. Crear Variación inicial
                DB::table('producto_variacion')->insert([
                    'producto_id' => $productoId,
                    'talla_id' => $tallaId,
                    'color_id' => $colorId,
                    'stock' => $stock,
                    'precio' => $precio,
                    'costo' => $costo
                ]);

                return $productoId;
            });

            return response()->json(['success' => true, 'id' => $result], 200);

        } catch (\Exception $e) {
            Log::error("❌ ERROR CREAR SIMPLE: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info("📥 ACTUALIZACIÓN DE PRODUCTO: ID $id, DATOS: " . json_encode($request->all()));

            DB::transaction(function () use ($request, $id) {
                $modNom = $request->input('modelo_nombre');
                $catId = $request->input('categoria_id');
                $colorNom = $request->input('color_primario');
                $precio = (double)$request->input('precio');
                $costo = (double)$request->input('costo');
                $stock = (int)$request->input('stock');

                // 1. Obtener producto y modelo
                $producto = DB::table('producto')->where('id', $id)->first();
                if (!$producto) throw new \Exception("Producto no encontrado");

                // 2. Actualizar Modelo si se envió nombre o categoría
                if ($modNom || $catId) {
                    $updateModelo = [];
                    if ($modNom) $updateModelo['nombre'] = $modNom;
                    if ($catId) $updateModelo['categoria_id'] = $catId;
                    
                    DB::table('modelo')->where('id', $producto->modelo_id)->update($updateModelo);
                }

                // 3. Actualizar o Crear Color
                if ($colorNom) {
                    $colorId = DB::table('color')->where('nombre', $colorNom)->value('id');
                    if (!$colorId) {
                        $colorId = DB::table('color')->insertGetId(['nombre' => $colorNom]);
                    }
                    
                    // Actualizar todas las variaciones de este producto con el nuevo color
                    DB::table('producto_variacion')->where('producto_id', $id)->update(['color_id' => $colorId]);
                }

                // 4. Actualizar Precio, Costo y Stock en todas las variaciones de este producto
                $updateVariacion = [];
                if ($request->has('precio')) $updateVariacion['precio'] = $precio;
                if ($request->has('costo')) $updateVariacion['costo'] = $costo;
                if ($request->has('stock')) $updateVariacion['stock'] = $stock;

                if (!empty($updateVariacion)) {
                    DB::table('producto_variacion')->where('producto_id', $id)->update($updateVariacion);
                }
            });

            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            Log::error("❌ ERROR AL ACTUALIZAR: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function getProductosByCategoria($nombre)
    {
        try {
            Log::info("📥 Filtrando productos por categoría: $nombre");
            
            $categoria = DB::table('categoria')
                ->where('nombre', 'LIKE', '%' . $nombre . '%')
                ->first();

            if (!$categoria) {
                Log::warning("⚠️ Categoría no encontrada: $nombre");
                return response()->json([], 200);
            }

            $productos = DB::table('producto')
                ->join('modelo', 'producto.modelo_id', '=', 'modelo.id')
                ->where('modelo.categoria_id', $categoria->id)
                ->select('producto.*')
                ->get();

            $data = $productos->map(function ($p) use ($categoria) {
                $modelo = DB::table('modelo')->where('id', $p->modelo_id)->first();
                $vars = DB::table('producto_variacion')->where('producto_id', $p->id)->get();
                $primera = $vars->first();

                return [
                    'id' => (int)$p->id,
                    'modelo' => [
                        'nombre' => (string)($modelo->nombre ?? 'Sin Modelo'), 
                        'categoria' => ['nombre' => (string)$categoria->nombre]
                    ],
                    'imagen' => null,
                    'estado' => (string)($p->estado ?? 'activo'),
                    'precio' => (double)($primera->precio ?? 0.0),
                    'costo' => (double)($primera->costo ?? 0.0),
                    'stock' => (int)($vars->sum('stock') ?? 0),
                    'variaciones' => $vars->map(function($v) {
                        return ['id' => (int)$v->id, 'precio' => (double)($v->precio ?? 0.0), 'stock' => (int)($v->stock ?? 0)];
                    })->values()->all()
                ];
            });

            return response()->json($data->values()->all(), 200);
        } catch (\Exception $e) {
            Log::error("❌ Error en filtro: " . $e->getMessage());
            return response()->json([], 200);
        }
    }
}

