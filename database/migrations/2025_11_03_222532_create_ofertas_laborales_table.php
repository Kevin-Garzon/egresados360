<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ofertas_laborales', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->nullOnDelete();
            $table->text('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            // En tu modelo etiquetas se castea a array → lo guardamos como JSON
            $table->json('etiquetas')->nullable();
            $table->string('url_externa')->nullable();
            $table->dateTime('publicada_en')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->boolean('activo')->default(true);
            // Campos que vi en tu flujo
            $table->unsignedInteger('interacciones')->default(0);
            $table->string('flyer')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('ofertas_laborales');
    }
};

