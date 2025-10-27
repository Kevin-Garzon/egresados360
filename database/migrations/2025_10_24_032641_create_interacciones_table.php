<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interacciones', function (Blueprint $table) {
            $table->id();
            $table->string('module'); // laboral, formacion, bienestar, etc.
            $table->string('action'); // aplicar, inscribirse, visitar, etc.
            $table->string('item_type')->nullable(); // oferta, curso, evento, etc.
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_title')->nullable();

            // Relación opcional con perfil
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->boolean('is_anonymous')->default(true);

            // Datos técnicos mínimos
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            $table->foreign('perfil_id')->references('id')->on('perfiles_egresado')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interacciones');
    }
};
