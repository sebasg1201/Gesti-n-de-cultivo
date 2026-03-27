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
        Schema::table('riego', function (Blueprint $table) {
            if (Schema::hasColumn('riego', 'evidencia_foto')) {
                $table->dropColumn('evidencia_foto');
            }
        });

        Schema::table('fases_programadas', function (Blueprint $table) {
            if (Schema::hasColumn('fases_programadas', 'evidencia_foto')) {
                $table->dropColumn('evidencia_foto');
            }
        });

        Schema::table('insumo_cosecha', function (Blueprint $table) {
            if (Schema::hasColumn('insumo_cosecha', 'evidencia_foto')) {
                $table->dropColumn('evidencia_foto');
            }
            if (Schema::hasColumn('insumo_cosecha', 'fecha_realizacion')) {
                $table->dropColumn('fecha_realizacion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riego', function (Blueprint $table) {
            $table->string('evidencia_foto', 255)->nullable();
        });

        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->string('evidencia_foto', 255)->nullable();
        });

        Schema::table('insumo_cosecha', function (Blueprint $table) {
            $table->string('evidencia_foto', 255)->nullable();
            $table->dateTime('fecha_realizacion')->nullable();
        });
    }
};
