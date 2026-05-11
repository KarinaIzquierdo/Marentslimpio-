<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('nombres')->after('id');
            $table->string('apellidos')->after('nombres');
            $table->string('documento')->nullable()->after('apellidos');
            $table->string('celular')->nullable()->after('documento');

            $table->dropColumn('name'); // quitamos el campo viejo
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('name');
            $table->dropColumn(['nombres', 'apellidos', 'documento', 'celular']);
        });
    }
};