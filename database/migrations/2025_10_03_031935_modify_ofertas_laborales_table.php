<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            
            if (Schema::hasColumn('ofertas_laborales', 'empresa')) {
                $table->dropColumn('empresa');
            }

            
            $table->json('etiquetas')->nullable()->change();

            
            if (!Schema::hasColumn('ofertas_laborales', 'fecha_cierre')) {
                $table->timestamp('fecha_cierre')->nullable()->after('publicada_en');
            }

            
            $table->foreign('empresa_id')
                  ->references('id')
                  ->on('empresas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('ofertas_laborales', function (Blueprint $table) {
            $table->string('empresa', 150)->nullable();
            $table->string('etiquetas', 255)->nullable()->change();
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('fecha_cierre');
        });
    }
};
