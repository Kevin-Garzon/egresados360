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
        Schema::table('formaciones', function (Blueprint $table) {
            // Campo para registrar cantidad de interacciones (clics, visitas, etc.)
            $table->unsignedInteger('interacciones')->default(0)->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formaciones', function (Blueprint $table) {
            $table->dropColumn('interacciones');
        });
    }
};
