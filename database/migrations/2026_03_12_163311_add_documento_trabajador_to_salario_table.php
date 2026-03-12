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
        Schema::table('salario', function (Blueprint $table) {
            $table->integer('documento_trabajador')->after('id_salario')->nullable();
            
            // Relación con la tabla usuario
            $table->foreign('documento_trabajador')
                  ->references('documento')
                  ->on('usuario')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salario', function (Blueprint $table) {
            $table->dropForeign(['documento_trabajador']);
            $table->dropColumn('documento_trabajador');
        });
    }
};
