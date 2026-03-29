<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Limpiar datos inconsistentes que impiden la creación de FKs
        // Cambiar 0 por NULL en las columnas que van a ser Llaves Foráneas
        // El valor 0 no es válido si no existe un registro con ID 0 en la tabla padre.
        DB::table('registro_trabajo')->where('id_fase', 0)->update(['id_fase' => null]);
        DB::table('registro_trabajo')->where('id_riego', 0)->update(['id_riego' => null]);
        DB::table('registro_trabajo')->where('id_insumo_cosecha', 0)->update(['id_insumo_cosecha' => null]);

        // 2. Aplicar las restricciones de Llave Foránea en registro_trabajo
        Schema::table('registro_trabajo', function (Blueprint $table) {
            // Aseguramos que las columnas permitan NULL y tengan el tipo correcto
            $table->integer('id_fase')->nullable()->change();
            $table->integer('id_riego')->nullable()->change();
            $table->integer('id_insumo_cosecha')->nullable()->change();

            // Intentar agregar las relaciones (usando try-catch por si alguna ya existe parcialmente)
            try {
                $table->foreign('id_fase')->references('id_fase')->on('fases_programadas')->onDelete('set null');
            } catch (\Exception $e) {}

            try {
                $table->foreign('id_riego')->references('id_riego')->on('riego')->onDelete('set null');
            } catch (\Exception $e) {}

            try {
                $table->foreign('id_insumo_cosecha')->references('id_insumo_cosecha')->on('insumo_cosecha')->onDelete('set null');
            } catch (\Exception $e) {}
            
            // Relaciones faltantes comunes
            try {
                $table->foreign('id_estado')->references('id_estado')->on('estado');
            } catch (\Exception $e) {}

            try {
                $table->foreign('documento_trabajador')->references('documento')->on('usuario');
            } catch (\Exception $e) {}
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_trabajo', function (Blueprint $table) {
            $table->dropForeign(['id_fase']);
            $table->dropForeign(['id_riego']);
            $table->dropForeign(['id_insumo_cosecha']);
            $table->dropForeign(['id_estado']);
            $table->dropForeign(['documento_trabajador']);
        });
    }
};
