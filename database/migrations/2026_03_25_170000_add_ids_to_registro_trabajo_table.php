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
        Schema::table('registro_trabajo', function (Blueprint $table) {
            $table->integer('id_fase')->nullable()->after('id_insumo_cosecha');
            $table->integer('id_riego')->nullable()->after('id_fase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_trabajo', function (Blueprint $table) {
            $table->dropColumn(['id_fase', 'id_riego']);
        });
    }
};
