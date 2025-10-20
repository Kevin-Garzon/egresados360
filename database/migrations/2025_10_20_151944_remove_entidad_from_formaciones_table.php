<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formaciones', function (Blueprint $table) {
            if (Schema::hasColumn('formaciones', 'entidad')) {
                $table->dropColumn('entidad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('formaciones', function (Blueprint $table) {
            $table->string('entidad', 150)->nullable();
        });
    }
};
