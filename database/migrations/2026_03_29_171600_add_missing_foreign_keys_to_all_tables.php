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
        // 1. Solicitud Compra
        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_tipo_licencia')->references('id_tipo_licencia')->on('tipo_licencia');
            $table->foreign('id_estado')->references('id_estado')->on('estado');
        });

        // 2. Catalog Relationships (tipo_ tables)
        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_catalogo')->references('id')->on('catalogo_riegos');
        });

        Schema::table('tipo_semilla', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_catalogo')->references('id')->on('catalogo_semillas');
        });

        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_catalogo')->references('id')->on('catalogo_suelos');
        });

        Schema::table('tipo_insumo', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
        });

        // 3. Terrain and User
        Schema::table('terreno', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_estado')->references('id_estado')->on('estado');
            $table->foreign('id_tipo_suelo')->references('id_tipo_suelo')->on('tipo_suelo');
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->foreign('id_tipo_usuario')->references('id_tipo_usuario')->on('tipo_usuario');
            $table->foreign('id_estado')->references('id_estado')->on('estado');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_estado_trabajador')->references('id_estado_trabajador')->on('estado_trabajador');
        });

        // 4. Other tables
        Schema::table('soporte', function (Blueprint $table) {
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('documento_trabajador')->references('documento')->on('usuario');
        });

        Schema::table('venta_licencias', function (Blueprint $table) {
            $table->foreign('id_tipo_licencia')->references('id_tipo_licencia')->on('tipo_licencia');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_estado')->references('id_estado')->on('estado');
        });

        Schema::table('salario', function (Blueprint $table) {
            $table->foreign('documento_trabajador')->references('documento')->on('usuario');
            $table->foreign('id_tipo_salario')->references('id_tipo_salario')->on('tipo_salario');
        });

        Schema::table('super_admin', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id_estado')->on('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_admin', function (Blueprint $table) {
            $table->dropForeign(['id_estado']);
        });

        Schema::table('salario', function (Blueprint $table) {
            $table->dropForeign(['documento_trabajador']);
            $table->dropForeign(['id_tipo_salario']);
        });

        Schema::table('venta_licencias', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_licencia']);
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_estado']);
        });

        Schema::table('soporte', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['documento_trabajador']);
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_usuario']);
            $table->dropForeign(['id_estado']);
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_estado_trabajador']);
        });

        Schema::table('terreno', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_estado']);
            $table->dropForeign(['id_tipo_suelo']);
        });

        Schema::table('tipo_insumo', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
        });

        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_catalogo']);
        });

        Schema::table('tipo_semilla', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_catalogo']);
        });

        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_catalogo']);
        });

        Schema::table('solicitud_compra', function (Blueprint $table) {
            $table->dropForeign(['id_empresa']);
            $table->dropForeign(['id_tipo_licencia']);
            $table->dropForeign(['id_estado']);
        });
    }
};
