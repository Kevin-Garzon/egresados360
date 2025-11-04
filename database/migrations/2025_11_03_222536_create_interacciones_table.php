<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interacciones', function (Blueprint $table) {
            $table->id();
            $table->string('module');                // p.ej. "Ofertas", "Formaciones", "Bienestar"
            $table->string('action');                // "click", "view", etc.
            $table->string('item_type')->nullable(); // p.ej. "oferta", "formacion"
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_title')->nullable();
            $table->foreignId('perfil_id')->nullable()->constrained('perfiles_egresado')->nullOnDelete();
            $table->boolean('is_anonymous')->default(false);
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['module', 'action']);
            $table->index(['item_type', 'item_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('interacciones');
    }
};

