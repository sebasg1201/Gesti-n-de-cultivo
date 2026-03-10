<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entrada_insumo', function (Blueprint $table) {
            $table->integer('id_insumo')->nullable()->change();
            $table->integer('id_semilla')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrada_insumo', function (Blueprint $table) {
            $table->integer('id_insumo')->nullable(false)->change();
            $table->integer('id_semilla')->nullable(false)->change();
        });
    }
};
