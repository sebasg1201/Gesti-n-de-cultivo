<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tipo_suelo', function (Blueprint $table) {
            if (!Schema::hasColumn('tipo_suelo', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('nombre');
            }
        });
    }

    public function down()
    {
        Schema::table('tipo_suelo', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
};
