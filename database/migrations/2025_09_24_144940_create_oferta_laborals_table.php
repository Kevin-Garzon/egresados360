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
        Schema::create('ofertas_laborales', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->string('empresa', 150);
            $table->text('descripcion')->nullable();
            $table->string('ubicacion', 120)->nullable();
            $table->string('etiquetas')->nullable(); // ej: "React, Remoto, Junior"
            $table->string('url_externa', 2048);     // enlace para postular en sitio externo
            $table->timestamp('publicada_en')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
};
