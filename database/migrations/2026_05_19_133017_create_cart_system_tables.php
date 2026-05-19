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
        Schema::create('carrito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();
        });

        Schema::create('carrito_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carrito')->onDelete('cascade');
            $table->foreignId('producto_variacion_id')->constrained('producto_variacions')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_detalle');
        Schema::dropIfExists('carrito');
    }
};
