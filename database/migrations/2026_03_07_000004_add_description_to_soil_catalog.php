<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('catalogo_suelos', function (Blueprint $table) {
            if (!Schema::hasColumn('catalogo_suelos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('impacto_dias');
            }
        });
    }

    public function down()
    {
        Schema::table('catalogo_suelos', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
};
