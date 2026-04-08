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
        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->integer('id_salario')->nullable()->after('id_estado');
            $table->foreign('id_salario')->references('id_salario')->on('salario')->onDelete('set null');
        });

        Schema::table('riego', function (Blueprint $table) {
            $table->integer('id_salario')->nullable()->after('id_estado');
            $table->foreign('id_salario')->references('id_salario')->on('salario')->onDelete('set null');
        });

        Schema::table('insumo_cosecha', function (Blueprint $table) {
            $table->integer('id_salario')->nullable()->after('id_estado');
            $table->foreign('id_salario')->references('id_salario')->on('salario')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->dropForeign(['id_salario']);
            $table->dropColumn('id_salario');
        });

        Schema::table('riego', function (Blueprint $table) {
            $table->dropForeign(['id_salario']);
            $table->dropColumn('id_salario');
        });

        Schema::table('insumo_cosecha', function (Blueprint $table) {
            $table->dropForeign(['id_salario']);
            $table->dropColumn('id_salario');
        });
    }
};
