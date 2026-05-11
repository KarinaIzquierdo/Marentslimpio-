<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('producto_variacion', function (Blueprint $table) {
    $table->decimal('costo', 10, 2)->nullable();
    $table->boolean('tiene_descuento')->default(false);
    $table->decimal('valor_descuento', 10, 2)->nullable();
});