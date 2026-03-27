<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registro_trabajo', function (Blueprint $table) {
            $table->unsignedInteger('id_cultivo')->nullable()->after('id_insumo_cosecha');
        });
    }

    public function down(): void
    {
        Schema::table('registro_trabajo', function (Blueprint $table) {
            $table->dropColumn('id_cultivo');
        });
    }
};
