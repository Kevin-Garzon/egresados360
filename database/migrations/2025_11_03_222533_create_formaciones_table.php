<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('formaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->nullOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->string('programa')->nullable();
            $table->string('modalidad')->nullable();
            $table->string('duracion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('url_externa')->nullable();
            $table->boolean('activo')->default(true);
            // (en tu modelo también usas imagen y/o flyer en algunos cambios)
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('formaciones');
    }
};
