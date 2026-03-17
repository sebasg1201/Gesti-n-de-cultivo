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
        Schema::table('insumo_cosecha', function (Blueprint $table) {
            $table->string('evidencia_foto')->nullable()->after('id_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insumo_cosecha', function (Blueprint $table) {
            $table->dropColumn('evidencia_foto');
        });
    }
};
