<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Elimina las columnas antiguas de interacciones.
     */
    public function up(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            if (Schema::hasColumn('ofertas_laborales', 'interacciones')) {
                $table->dropColumn('interacciones');
            }
        });

        Schema::table('formaciones', function (Blueprint $table) {
            if (Schema::hasColumn('formaciones', 'interacciones')) {
                $table->dropColumn('interacciones');
            }
        });
    }

    /**
     * Permite revertir los cambios si fuera necesario.
     */
    public function down(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            if (!Schema::hasColumn('ofertas_laborales', 'interacciones')) {
                $table->integer('interacciones')->default(0);
            }
        });

        Schema::table('formaciones', function (Blueprint $table) {
            if (!Schema::hasColumn('formaciones', 'interacciones')) {
                $table->integer('interacciones')->default(0);
            }
        });
    }
};
