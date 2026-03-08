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
        // 1. Foreign Key for Seeds
        Schema::table('tipo_semilla', function (Blueprint $table) {
            $table->foreign('id_catalogo')
                ->references('id')
                ->on('catalogo_semillas')
                ->onDelete('restrict');
        });

        // 2. Foreign Key for Soils
        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->foreign('id_catalogo')
                ->references('id')
                ->on('catalogo_suelos')
                ->onDelete('restrict');
        });

        // 3. Foreign Key for Irrigation
        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->foreign('id_catalogo')
                ->references('id')
                ->on('catalogo_riegos')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_semilla', function (Blueprint $table) {
            $table->dropForeign(['id_catalogo']);
        });

        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->dropForeign(['id_catalogo']);
        });

        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->dropForeign(['id_catalogo']);
        });
    }
};
