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
        Schema::create('bienestar_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150); 
            $table->text('descripcion')->nullable();
            $table->string('tipo', 100)->nullable(); 
            $table->string('contacto', 150)->nullable(); 
            $table->string('ubicacion', 150)->nullable(); 
            $table->string('url', 2048)->nullable(); 
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bienestar_servicios');
    }
};
