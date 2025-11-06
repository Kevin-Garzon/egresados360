<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('visitas_diarias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique();
            $table->unsignedInteger('total')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('visitas_diarias');
    }
};

