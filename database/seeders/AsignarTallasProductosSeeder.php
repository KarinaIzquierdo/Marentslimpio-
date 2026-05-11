<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class AsignarTallasProductosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Producto::with('modelo.categoria')->get();

        foreach ($productos as $producto) {
            // Obtener categoría desde el modelo del producto
            $categoriaNombre = strtolower($producto->modelo?->categoria?->nombre ?? '');
            
            // Asignar tallas según categoría
            if (str_contains($categoriaNombre, 'niño') || str_contains($categoriaNombre, 'nino') || str_contains($categoriaNombre, 'infantil')) {
                // Tallas niños: 20, 22, 24, 26, 28, 30, 32, 34
                $tallas = ['20', '22', '24', '26', '28', '30', '32', '34'];
            } elseif (str_contains($categoriaNombre, 'dama') || str_contains($categoriaNombre, 'mujer')) {
                // Tallas dama: 35-40
                $tallas = ['35', '36', '37', '38', '39', '40'];
            } elseif (str_contains($categoriaNombre, 'caballero') || str_contains($categoriaNombre, 'hombre')) {
                // Tallas caballero: 38-45
                $tallas = ['38', '39', '40', '41', '42', '43', '44', '45'];
            } else {
                // Por defecto: 35-45
                $tallas = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
            }

            // Guardar tallas como JSON
            $producto->tallas = $tallas;
            $producto->save();

            $this->command->info("Producto: {$producto->nombre} - Categoria: {$categoriaNombre} - Tallas: " . implode(', ', $tallas));
        }

        $this->command->info('Tallas asignadas correctamente a todos los productos.');
    }
}
