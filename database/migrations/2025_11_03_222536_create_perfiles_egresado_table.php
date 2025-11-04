<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('perfiles_egresado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('correo')->nullable();
            $table->string('celular')->nullable();
            $table->string('programa')->nullable();
            $table->unsignedSmallInteger('anio_egreso')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('perfiles_egresado');
    }
};
