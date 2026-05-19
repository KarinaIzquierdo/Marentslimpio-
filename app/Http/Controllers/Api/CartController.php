<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function getStats()
    {
        try {
            // 1. Pendientes: Contar usuarios únicos que tienen items en su carrito
            $pendientes = DB::table('carrito')
                ->join('carrito_detalle', 'carrito.id', '=', 'carrito_detalle.carrito_id')
                ->distinct('carrito.usuario_id')
                ->count('carrito.usuario_id');

            // 2. Ventas: Suma total considerando precios de variaciones o precios base
            $totalVentas = DB::table('carrito_detalle')
                ->join('producto_variacions', 'carrito_detalle.producto_variacion_id', '=', 'producto_variacions.id')
                ->join('productos', 'producto_variacions.producto_id', '=', 'productos.id')
                ->select(DB::raw('SUM(COALESCE(producto_variacions.precio, 0) * carrito_detalle.cantidad) as total'))
                ->first()->total ?? 0;

            // 3. Stock Bajo: Variaciones con stock < 5
            $stockBajo = DB::table('producto_variacions')
                ->where('stock', '<', 5)
                ->count();

            // 4. Pedidos Recientes: Obtener los últimos 5 carritos con actividad
            $pedidosRecientes = DB::table('carrito')
                ->join('users', 'carrito.usuario_id', '=', 'users.id')
                ->join('carrito_detalle', 'carrito.id', '=', 'carrito_detalle.carrito_id')
                ->join('producto_variacions', 'carrito_detalle.producto_variacion_id', '=', 'producto_variacions.id')
                ->select(
                    'carrito.id',
                    DB::raw('CONCAT(users.nombres, " ", users.apellidos) as cliente'),
                    DB::raw('SUM(COALESCE(producto_variacions.precio, 0) * carrito_detalle.cantidad) as total'),
                    DB::raw('"Pendiente" as estado')
                )
                ->groupBy('carrito.id', 'users.nombres', 'users.apellidos')
                ->orderBy('carrito.id', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'pendientes' => $pendientes,
                'ventas' => (int)$totalVentas,
                'stock_bajo' => $stockBajo,
                'completados' => 0,
                'pedidos_recientes' => $pedidosRecientes
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getStats: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAdminStats()
    {
        try {
            // Contar desde las tablas reales en plural
            $totalProductos = \DB::table('productos')->count();
            $stockBajo = \DB::table('producto_variacions')->where('stock', '<', 10)->count();
            $pedidosPendientes = \DB::table('pedidos')->where('estado', 'pendiente')->count();
            $pedidosCompletados = \DB::table('pedidos')->where('estado', 'completado')->count();

            return response()->json([
                'pendientes' => $pedidosPendientes,
                'ventas' => $pedidosCompletados, // O ingresos totales si prefieres
                'stock_bajo' => $stockBajo,
                'completados' => $totalProductos, // Usamos esto para mostrar "Total Productos" en una de las tarjetas
                'pedidos_recientes' => []
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getAdminStats: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $usuarioId = $request->query('user_id');
            
            if (!$usuarioId) {
                return response()->json(['error' => 'Usuario no proporcionado'], 400);
            }

            // --- LÓGICA DE LIMPIEZA AUTOMÁTICA (3 DÍAS) ---
            // Borra registros en carrito_detalle que tengan más de 3 días basándose en la fecha del carrito
            $fechaLimite = now()->subDays(3);
            
            DB::table('carrito_detalle')
                ->join('carrito', 'carrito_detalle.carrito_id', '=', 'carrito.id')
                ->where('carrito.usuario_id', $usuarioId)
                ->where('carrito.fecha', '<', $fechaLimite)
                ->delete();
            // ----------------------------------------------

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
                    'producto_variacion.precio',
                    'talla.numero as talla',
                    'carrito_detalle.cantidad'
                )
                ->get();

            return response()->json($items);
        } catch (\Exception $e) {
            Log::error('Error en CartController@index: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
                // Actualizar la fecha del carrito para que los 3 días cuenten desde la última actividad
                DB::table('carrito')->where('id', $carritoId)->update(['fecha' => now()]);
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
