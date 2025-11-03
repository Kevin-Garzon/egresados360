<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bienestar_mentorias', function (Blueprint $table) {
            if (Schema::hasColumn('bienestar_mentorias', 'url')) {
                $table->dropColumn('url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bienestar_mentorias', function (Blueprint $table) {
            $table->string('url', 255)->nullable()->after('descripcion');
        });
    }
};
