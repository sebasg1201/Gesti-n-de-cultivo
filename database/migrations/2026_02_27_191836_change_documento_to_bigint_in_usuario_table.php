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
            $table->dropForeign('fases_programadas_ibfk_1');
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->bigInteger('documento')->change();
        });

        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->bigInteger('id_usuario')->change();
            $table->foreign('id_usuario')->references('documento')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->integer('documento')->change();
        });

        Schema::table('fases_programadas', function (Blueprint $table) {
            $table->integer('id_usuario')->change();
            $table->foreign('id_usuario', 'fases_programadas_ibfk_1')->references('documento')->on('usuario');
        });
    }
};
