<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bienestar_habilidades', function (Blueprint $table) {
            if (Schema::hasColumn('bienestar_habilidades', 'enlace_inscripcion')) {
                $table->dropColumn('enlace_inscripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bienestar_habilidades', function (Blueprint $table) {
            $table->string('enlace_inscripcion', 255)->nullable()->after('fecha');
        });
    }
};
