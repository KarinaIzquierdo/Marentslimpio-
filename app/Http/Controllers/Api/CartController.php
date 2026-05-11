<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = $request->query('user_id');
        
        if (!$usuarioId) {
            return response()->json(['error' => 'Usuario no proporcionado'], 400);
        }

        $items = DB::table('carrito')
            ->join('carrito_detalle', 'carrito.id', '=', 'carrito_detalle.carrito_id')
            ->join('producto_variacion', 'carrito_detalle.producto_variacion_id', '=', 'producto_variacion.id')
            ->join('producto', 'producto_variacion.producto_id', '=', 'producto.id')
            ->join('modelo', 'producto.modelo_id', '=', 'modelo.id')
            ->join('talla', 'producto_variacion.talla_id', '=', 'talla.id')
            ->where('carrito.usuario_id', $usuarioId)
            ->select(
                'carrito_detalle.id as item_id',
                'producto.id as producto_id',
                'modelo.nombre',
                DB::raw('COALESCE(producto_variacion.precio, 0) as precio'),
                'talla.numero as talla',
                'carrito_detalle.cantidad'
            )
            ->get();

        return response()->json($items);
    }

    public function add(Request $request)
    {
        // Aceptar tanto JSON como form data
        $data = $request->getContent() ? json_decode($request->getContent(), true) : $request->all();
        
        $usuarioId = $data['user_id'] ?? null;
        $productoId = $data['producto_id'] ?? null;
        $tallaNombre = $data['talla'] ?? null;
        $cantidad = $data['cantidad'] ?? 1;

        if (!$usuarioId || !$productoId || !$tallaNombre) {
            return response()->json(['error' => 'Datos incompletos'], 400);
        }

        try {
            DB::beginTransaction();

            // 1. Obtener variacion_id para ese producto y talla
            $variacion = DB::table('producto_variacion')
                ->join('talla', 'producto_variacion.talla_id', '=', 'talla.id')
                ->where('producto_variacion.producto_id', $productoId)
                ->where('talla.numero', $tallaNombre)
                ->select('producto_variacion.id')
                ->first();

            if (!$variacion) {
                // Si la variación no existe, intentamos buscar la talla por número
                $talla = DB::table('talla')->where('numero', $tallaNombre)->first();
                if (!$talla) {
                    return response()->json(['error' => 'La talla ' . $tallaNombre . ' no existe en el sistema'], 404);
                }

                // Creamos la variación automáticamente para que no de error 404
                $variacionId = DB::table('producto_variacion')->insertGetId([
                    'producto_id' => $productoId,
                    'talla_id' => $talla->id,
                    'color_id' => 1, // Color por defecto
                    'precio' => null,
                    'stock' => 10,
                    'costo' => 0,
                    'tiene_descuento' => 0
                ]);
            } else {
                $variacionId = $variacion->id;
            }

            // 2. Obtener o crear carrito para el usuario
            // Validamos que el usuario_id sea válido (existe en users o en la tabla que manejes)
            $usuarioExiste = DB::table('users')->where('id', $usuarioId)->exists();
            if (!$usuarioExiste) {
                // Si no existe en 'users', probamos en 'usuario' por si acaso
                $usuarioExiste = DB::table('usuario')->where('id', $usuarioId)->exists();
            }

            if (!$usuarioExiste) {
                 return response()->json(['error' => 'Usuario no encontrado (ID: ' . $usuarioId . ')'], 404);
            }

            $carrito = DB::table('carrito')->where('usuario_id', $usuarioId)->first();
            if (!$carrito) {
                $carritoId = DB::table('carrito')->insertGetId([
                    'usuario_id' => $usuarioId,
                    'fecha' => now()
                ]);
            } else {
                $carritoId = $carrito->id;
            }

            // 3. Verificar si el item ya existe en el carrito
            $itemExistente = DB::table('carrito_detalle')
                ->where('carrito_id', $carritoId)
                ->where('producto_variacion_id', $variacionId)
                ->first();

            if ($itemExistente) {
                DB::table('carrito_detalle')
                    ->where('id', $itemExistente->id)
                    ->update(['cantidad' => $itemExistente->cantidad + $cantidad]);
            } else {
                DB::table('carrito_detalle')->insert([
                    'carrito_id' => $carritoId,
                    'producto_variacion_id' => $variacionId,
                    'cantidad' => $cantidad
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Producto agregado al carrito']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar al carrito: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function removeItem($itemId)
    {
        try {
            DB::beginTransaction();

            // Verificar que el item existe
            $item = DB::table('carrito_detalle')->where('id', $itemId)->first();
            
            if (!$item) {
                return response()->json(['error' => 'Item no encontrado'], 404);
            }

            // Eliminar el item del carrito
            DB::table('carrito_detalle')->where('id', $itemId)->delete();

            // Verificar si el carrito quedó vacío para eliminarlo también
            $carritoId = $item->carrito_id;
            $itemsRestantes = DB::table('carrito_detalle')->where('carrito_id', $carritoId)->count();
            
            if ($itemsRestantes == 0) {
                DB::table('carrito')->where('id', $carritoId)->delete();
            }

            DB::commit();
            return response()->json(['message' => 'Item eliminado del carrito']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar item del carrito: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }
}
