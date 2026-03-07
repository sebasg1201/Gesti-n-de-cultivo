<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('cosecha', 'id_empresa')) {
            Schema::table('cosecha', function (Blueprint $table) {
                $table->string('id_empresa', 20)->nullable()->after('id_cosecha');
            });
        }

        if (!Schema::hasColumn('tipo_semilla', 'id_empresa')) {
            Schema::table('tipo_semilla', function (Blueprint $table) {
                $table->string('id_empresa', 20)->nullable()->after('id_semilla');
            });
        }

        if (!Schema::hasColumn('tipo_riego', 'id_empresa')) {
            Schema::table('tipo_riego', function (Blueprint $table) {
                $table->string('id_empresa', 20)->nullable()->after('id_tipo_riego');
            });
        }

        if (!Schema::hasColumn('terreno', 'id_empresa')) {
            Schema::table('terreno', function (Blueprint $table) {
                $table->string('id_empresa', 20)->nullable()->after('id_terreno');
            });
        }
    }

    public function down()
    {
        Schema::table('cosecha', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
        Schema::table('tipo_semilla', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
        Schema::table('tipo_riego', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
        Schema::table('terreno', function (Blueprint $table) {
            $table->dropColumn('id_empresa');
        });
    }
};
