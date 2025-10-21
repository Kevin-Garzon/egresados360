<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bienestar_habilidades', function (Blueprint $table) {
            
            if (Schema::hasColumn('bienestar_habilidades', 'fecha_inicio')) {
                $table->dropColumn('fecha_inicio');
            }
            if (Schema::hasColumn('bienestar_habilidades', 'fecha_fin')) {
                $table->dropColumn('fecha_fin');
            }
            if (Schema::hasColumn('bienestar_habilidades', 'duracion')) {
                $table->dropColumn('duracion');
            }

            // Agregar columna 'tema'
            if (!Schema::hasColumn('bienestar_habilidades', 'tema')) {
                $table->string('tema', 60)->after('descripcion');
            }

            // Agregar columnas nuevas
            if (!Schema::hasColumn('bienestar_habilidades', 'fecha')) {
                $table->date('fecha')->after('modalidad');
            }
            if (!Schema::hasColumn('bienestar_habilidades', 'enlace_inscripcion')) {
                $table->string('enlace_inscripcion')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('bienestar_habilidades', 'imagen')) {
                $table->string('imagen')->nullable()->after('enlace_inscripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bienestar_habilidades', function (Blueprint $table) {
            if (Schema::hasColumn('bienestar_habilidades', 'tema')) {
                $table->dropColumn('tema');
            }
            if (Schema::hasColumn('bienestar_habilidades', 'fecha')) {
                $table->dropColumn('fecha');
            }
            if (Schema::hasColumn('bienestar_habilidades', 'enlace_inscripcion')) {
                $table->dropColumn('enlace_inscripcion');
            }
            if (Schema::hasColumn('bienestar_habilidades', 'imagen')) {
                $table->dropColumn('imagen');
            }

            // Volver a agregar las anteriores si se revierte
            $table->date('fecha_inicio')->nullable()->after('modalidad');
            $table->date('fecha_fin')->nullable()->after('fecha_inicio');
            $table->string('duracion', 50)->nullable()->after('fecha_fin');
        });
    }
};
