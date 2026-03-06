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
        // Safely drop FK if it exists (may already be gone)
        try {
            Schema::table('fases_programadas', function (Blueprint $table) {
                $table->dropForeign('fases_programadas_ibfk_1');
            });
        } catch (\Exception $e) {
            // FK doesn't exist, skip
        }

        // Change documento column type in usuario if needed
        if (Schema::hasColumn('usuario', 'documento')) {
            Schema::table('usuario', function (Blueprint $table) {
                $table->bigInteger('documento')->change();
            });
        }

        // Only act on id_usuario if that column exists (it may be named 'documento')
        if (Schema::hasColumn('fases_programadas', 'id_usuario')) {
            Schema::table('fases_programadas', function (Blueprint $table) {
                $table->bigInteger('id_usuario')->change();
                $table->foreign('id_usuario')->references('documento')->on('usuario');
            });
        }
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
