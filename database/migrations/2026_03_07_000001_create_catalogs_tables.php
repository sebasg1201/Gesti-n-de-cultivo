<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Create catalogo_semillas
        Schema::create('catalogo_semillas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('tiempo_base_dias');
            $table->decimal('rendimiento_promedio', 8, 2)->nullable();
            $table->timestamps();
        });

        // 2. Create catalogo_suelos
        Schema::create('catalogo_suelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('impacto_dias');
            $table->timestamps();
        });

        // 3. Fix missing columns in tipo_suelo if not already fixed
        if (!Schema::hasColumn('tipo_suelo', 'id_empresa')) {
            Schema::table('tipo_suelo', function (Blueprint $table) {
                $table->string('id_empresa', 20)->nullable()->after('id_tipo_suelo');
            });
        }

        // Add foreign keys to master tables in the company-specific tables (Optional but professional)
        if (!Schema::hasColumn('tipo_semilla', 'id_catalogo')) {
            Schema::table('tipo_semilla', function (Blueprint $table) {
                $table->unsignedBigInteger('id_catalogo')->nullable()->after('id_empresa');
            });
        }

        if (!Schema::hasColumn('tipo_suelo', 'id_catalogo')) {
            Schema::table('tipo_suelo', function (Blueprint $table) {
                $table->unsignedBigInteger('id_catalogo')->nullable()->after('id_empresa');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('catalogo_semillas');
        Schema::dropIfExists('catalogo_suelos');

        if (Schema::hasColumn('tipo_suelo', 'id_empresa')) {
            Schema::table('tipo_suelo', function (Blueprint $table) {
                $table->dropColumn('id_empresa');
            });
        }

        if (Schema::hasColumn('tipo_semilla', 'id_catalogo')) {
            Schema::table('tipo_semilla', function (Blueprint $table) {
                $table->dropColumn('id_catalogo');
            });
        }

        if (Schema::hasColumn('tipo_suelo', 'id_catalogo')) {
            Schema::table('tipo_suelo', function (Blueprint $table) {
                $table->dropColumn('id_catalogo');
            });
        }
    }
};
