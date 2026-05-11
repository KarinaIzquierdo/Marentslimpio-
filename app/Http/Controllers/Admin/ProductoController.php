<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Modelo;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Talla;
use App\Models\ProductoVariacion;
use App\Models\ProductoImagen;

class ProductoController extends Controller
{
    //  LISTADO
    public function index()
    {
        $productos = Producto::with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla',
            'variaciones.colorPrimario',
            'variaciones.colorSecundario'
        ])->get();

        $categorias = Categoria::all();
        $tallas = Talla::all();

        return view('admin.productos.index', compact(
            'productos',
            'categorias',
            'tallas'
        ));
    }

    //  CREAR PRODUCTO
    public function store(Request $request)
    {
        $request->validate([
            'modelo_nombre' => 'required|string',
            'categoria_id' => 'required',
            'color_primario' => 'required|string',
            'talla_numero' => 'required|numeric',
            'precio' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0'
        ]);

        $modelo = Modelo::create([
            'nombre' => $request->modelo_nombre,
            'categoria_id' => $request->categoria_id
        ]);

        $producto = Producto::create([
            'modelo_id' => $modelo->id
        ]);

        $colorPrimario = Color::firstOrCreate([
            'nombre' => $request->color_primario
        ]);

        $colorSecundario = null;
        if ($request->color_secundario) {
            $colorSecundario = Color::firstOrCreate([
                'nombre' => $request->color_secundario
            ]);
        }

        $talla = Talla::firstOrCreate([
            'numero' => $request->talla_numero
        ]);

        ProductoVariacion::updateOrCreate(
            [
                'producto_id' => $producto->id,
                'talla_id' => $talla->id
            ],
            [
                'color_id' => $colorPrimario->id,
                'color_secundario_id' => $colorSecundario?->id,
                'precio' => $request->precio,
                'costo' => $request->costo,
                'stock' => $request->stock,
                'tiene_descuento' => $request->valor_descuento ? true : false,
                'valor_descuento' => $request->valor_descuento
            ]
        );

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            ProductoImagen::create([
                'producto_id' => $producto->id,
                'url' => 'storage/' . $path
            ]);
        }

        return back()->with('success', 'Producto creado');
    }

    public function agregarStockProducto(Request $request)
    {
        $request->validate([
            'producto_id' => 'required',
            'talla_id' => 'required',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $variacion = ProductoVariacion::where('producto_id', $request->producto_id)
            ->where('talla_id', $request->talla_id)
            ->first();

        if ($variacion) {
            $variacion->increment('stock', $request->cantidad);
        } else {
            $color = Color::first() ?: Color::create(['nombre' => 'Default']);
            ProductoVariacion::create([
                'producto_id' => $request->producto_id,
                'talla_id' => $request->talla_id,
                'color_id' => $color->id,
                'stock' => $request->cantidad,
                'precio' => 0,
                'costo' => 0,
                'tiene_descuento' => 0
            ]);
        }

        return back()->with('success', 'Stock actualizado');
    }

    public function getModelos($categoriaId)
    {
        return Modelo::where('categoria_id', $categoriaId)->get();
    }

    public function getTallas($modeloId)
    {
        return Talla::select('id', 'numero')->orderBy('numero')->get();
    }

    public function getProductoInfo($modeloId)
    {
        $producto = Producto::where('modelo_id', $modeloId)
            ->with([
                'imagen',
                'variaciones.talla',
                'variaciones.colorPrimario',
                'variaciones.colorSecundario'
            ])
            ->first();

        return response()->json($producto);
    }

    public function getColores($modeloId)
    {
        $variaciones = ProductoVariacion::whereHas('producto', function ($q) use ($modeloId) {
            $q->where('modelo_id', $modeloId);
        })
        ->with(['colorPrimario', 'colorSecundario'])
        ->get();

        $primarios = $variaciones->pluck('colorPrimario')->filter()->unique('id')->values();
        $secundarios = $variaciones->pluck('colorSecundario')->filter()->unique('id')->values();

        return response()->json([
            'primarios' => $primarios,
            'secundarios' => $secundarios
        ]);
    }

    public function agregarStockGlobal(Request $request)
    {
        $request->validate([
            'variacion_id' => 'required',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $variacion = ProductoVariacion::find($request->variacion_id);
        if (!$variacion) {
            return back()->with('error', 'Variación no encontrada');
        }

        $variacion->increment('stock', $request->cantidad);
        return back()->with('success', 'Stock actualizado correctamente');
    }

    public function show($id)
    {
        $producto = Producto::with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla',
            'variaciones.colorPrimario'
        ])->findOrFail($id);

        $variaciones = $producto->variaciones;
        $colores = $variaciones->pluck('colorPrimario')->filter()->unique('id')->values();
        $tallas = $variaciones->pluck('talla.numero')->unique()->sort()->values();
        $precio = $variaciones->avg('precio');

        return view('producto.show', compact('producto', 'colores', 'tallas', 'precio'));
    }

    public function indexApi()
    {
        $productos = Producto::with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla',
            'variaciones.colorPrimario',
            'variaciones.colorSecundario'
        ])->get();

        // Transformamos la colección para que 'imagen' sea un string con la URL
        $productosTransformed = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'modelo' => $producto->modelo,
                'imagen' => $producto->imagen ? str_replace('127.0.0.1', '10.0.2.2', asset($producto->imagen->url)) : null,
                'estado' => $producto->estado,
                'tallas' => $producto->tallas ?? [],
                'variaciones' => $producto->variaciones
            ];
        });

        return response()->json($productosTransformed);
    }

    public function indexApiPorCategoria($categoriaNombre)
    {
        $productos = Producto::whereHas('modelo.categoria', function ($query) use ($categoriaNombre) {
            $query->where('nombre', $categoriaNombre);
        })
        ->with([
            'modelo.categoria',
            'imagen',
            'variaciones.talla',
            'variaciones.colorPrimario',
            'variaciones.colorSecundario'
        ])
        ->get();

        // Transformamos la colección para que 'imagen' sea un string con la URL
        $productosTransformed = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'modelo' => $producto->modelo,
                'imagen' => $producto->imagen ? str_replace('127.0.0.1', '10.0.2.2', asset($producto->imagen->url)) : null,
                'estado' => $producto->estado,
                'tallas' => $producto->tallas ?? [],
                'variaciones' => $producto->variaciones
            ];
        });

        return response()->json($productosTransformed);
    }

    //  CREAR PRODUCTO API (para Android)
    public function storeApi(Request $request)
    {
        try {
            $request->validate([
                'modelo_nombre' => 'required|string',
                'categoria_id' => 'required|numeric',
                'color_primario' => 'required|string',
                'talla_numero' => 'required|numeric',
                'precio' => 'required|numeric|min:0',
                'costo' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0'
            ]);

            $modelo = Modelo::create([
                'nombre' => $request->modelo_nombre,
                'categoria_id' => $request->categoria_id
            ]);

            $producto = Producto::create([
                'modelo_id' => $modelo->id
            ]);

            $colorPrimario = Color::firstOrCreate([
                'nombre' => $request->color_primario
            ]);

            $colorSecundario = null;
            if ($request->color_secundario) {
                $colorSecundario = Color::firstOrCreate([
                    'nombre' => $request->color_secundario
                ]);
            }

            $talla = Talla::firstOrCreate([
                'numero' => $request->talla_numero
            ]);

            ProductoVariacion::updateOrCreate(
                [
                    'producto_id' => $producto->id,
                    'talla_id' => $talla->id
                ],
                [
                    'color_id' => $colorPrimario->id,
                    'color_secundario_id' => $colorSecundario?->id,
                    'precio' => $request->precio,
                    'costo' => $request->costo,
                    'stock' => $request->stock,
                    'tiene_descuento' => $request->valor_descuento ? true : false,
                    'valor_descuento' => $request->valor_descuento
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'producto' => [
                    'id' => $producto->id,
                    'modelo' => $modelo,
                    'variaciones' => $producto->variaciones
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear producto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateApi(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $modelo = Modelo::findOrFail($producto->modelo_id);

            $request->validate([
                'modelo_nombre' => 'required|string',
                'categoria_id' => 'required|numeric',
                'precio' => 'required|numeric|min:0',
                'costo' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0'
            ]);

            // Actualizar modelo
            $modelo->update([
                'nombre' => $request->modelo_nombre,
                'categoria_id' => $request->categoria_id
            ]);

            // Actualizar TODAS las variaciones del producto para que se vea reflejado en todas las tallas/colores
            $variaciones = ProductoVariacion::where('producto_id', $producto->id)->get();
            
            if ($variaciones->isNotEmpty()) {
                foreach ($variaciones as $variacion) {
                    // Forzar actualización directa para evitar problemas con valores nulos
                    $variacion->precio = $request->precio;
                    $variacion->costo = $request->costo;
                    $variacion->stock = $request->stock;
                    $variacion->save();
                }
            } else {
                // Si no existe variación, la creamos (por si el producto estaba incompleto)
                $colorDefault = Color::firstOrCreate(['nombre' => 'Negro']);
                $tallaDefault = Talla::firstOrCreate(['numero' => 38]);
                
                ProductoVariacion::create([
                    'producto_id' => $producto->id,
                    'talla_id' => $tallaDefault->id,
                    'color_id' => $colorDefault->id,
                    'precio' => $request->precio,
                    'costo' => $request->costo,
                    'stock' => $request->stock,
                    'tiene_descuento' => 0
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'producto' => $producto->load('modelo.categoria', 'variaciones')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyApi($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            
            // Opcional: Eliminar modelo si no tiene más productos
            $modeloId = $producto->modelo_id;
            
            $producto->delete();
            
            // Verificar si el modelo quedó huérfano
            if (Producto::where('modelo_id', $modeloId)->count() == 0) {
                Modelo::where('id', $modeloId)->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}
