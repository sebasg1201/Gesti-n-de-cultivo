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
        if (!Schema::hasColumn('fases_programadas', 'id_terreno')) {
            Schema::table('fases_programadas', function (Blueprint $table) {
                // Si id_cosecha no existe, no usamos 'after'
                if (Schema::hasColumn('fases_programadas', 'id_cosecha')) {
                    $table->integer('id_terreno')->nullable()->after('id_cosecha');
                } else {
                    $table->integer('id_terreno')->nullable();
                }
                $table->foreign('id_terreno')->references('id_terreno')->on('terreno')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->dropForeign(['id_terreno']);
            $table->dropColumn('id_terreno');
        });
    }
};
