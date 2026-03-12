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
        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->decimal('consumo_agua_ideal', 8, 2)->nullable()->after('impacto_dias');
        });

        Schema::table('terreno', function (Blueprint $table) {
            $table->decimal('area_m2', 8, 2)->nullable()->after('Alto');
        });

        Schema::table('cosecha', function (Blueprint $table) {
            $table->integer('frecuencia_riego_dias')->nullable()->after('fecha_siembra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->dropColumn('consumo_agua_ideal');
        });

        Schema::table('terreno', function (Blueprint $table) {
            $table->dropColumn('area_m2');
        });

        Schema::table('cosecha', function (Blueprint $table) {
            $table->dropColumn('frecuencia_riego_dias');
        });
    }
};
