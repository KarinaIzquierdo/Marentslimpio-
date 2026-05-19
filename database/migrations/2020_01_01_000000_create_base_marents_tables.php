<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Categorías
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // 2. Modelos
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
            $table->string('estado')->default('activo');
            $table->json('tallas')->nullable();
            $table->timestamps();
        });

        // 4. Colores
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        // 5. Tallas
        Schema::create('tallas', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->timestamps();
        });

        // 6. Producto Variaciones
        Schema::create('producto_variacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('talla_id')->constrained('tallas')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('color_secundario_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->decimal('costo', 12, 2)->default(0);
            $table->decimal('precio', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('tiene_descuento')->default(false);
            $table->decimal('valor_descuento', 12, 2)->nullable();
            $table->timestamps();
        });

        // 7. Imágenes
        Schema::create('producto_imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_imagens');
        Schema::dropIfExists('producto_variacions');
        Schema::dropIfExists('tallas');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('modelos');
        Schema::dropIfExists('categorias');
    }
};
