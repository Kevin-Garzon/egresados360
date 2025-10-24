<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            // ruta del archivo (ej: "flyers/abcd1234.jpg")
            $table->string('flyer', 2048)->nullable()->after('fecha_cierre');
        });
    }

    public function down(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            $table->dropColumn('flyer');
        });
    }
};
