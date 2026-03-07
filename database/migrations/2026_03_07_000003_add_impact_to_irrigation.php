<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Add impacto_dias to catalogo_riegos
        if (!Schema::hasColumn('catalogo_riegos', 'impacto_dias')) {
            Schema::table('catalogo_riegos', function (Blueprint $table) {
                $table->integer('impacto_dias')->default(0)->after('nombre');
            });
        }

        // 2. Add impacto_dias to tipo_riego
        if (!Schema::hasColumn('tipo_riego', 'impacto_dias')) {
            Schema::table('tipo_riego', function (Blueprint $table) {
                $table->integer('impacto_dias')->default(0)->after('tipo_riego');
            });
        }

        // 3. Update catalog with professional values
        DB::table('catalogo_riegos')->where('nombre', 'Goteo')->update(['impacto_dias' => -3]);
        DB::table('catalogo_riegos')->where('nombre', 'Aspersión')->update(['impacto_dias' => 0]);
        DB::table('catalogo_riegos')->where('nombre', 'Micro-aspersión')->update(['impacto_dias' => -1]);
        DB::table('catalogo_riegos')->where('nombre', 'Gravedad (Surcos)')->update(['impacto_dias' => 2]);
        DB::table('catalogo_riegos')->where('nombre', 'Hidropónico')->update(['impacto_dias' => -7]);
    }

    public function down()
    {
        if (Schema::hasColumn('catalogo_riegos', 'impacto_dias')) {
            Schema::table('catalogo_riegos', function (Blueprint $table) {
                $table->dropColumn('impacto_dias');
            });
        }

        if (Schema::hasColumn('tipo_riego', 'impacto_dias')) {
            Schema::table('tipo_riego', function (Blueprint $table) {
                $table->dropColumn('impacto_dias');
            });
        }
    }
};
