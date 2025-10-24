<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formaciones', function (Blueprint $table) {
            $table->string('duracion', 50)->nullable()->after('costo');
        });
    }

    public function down(): void
    {
        Schema::table('formaciones', function (Blueprint $table) {
            $table->dropColumn('duracion');
        });
    }
};
