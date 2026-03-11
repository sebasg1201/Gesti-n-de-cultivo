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
        Schema::create('tipo_insumo', function (Blueprint $table) {
            $table->id('id_tipo_insumo');
            $table->string('id_empresa', 50)->nullable(); // using string as other schemas seem to do
            $table->unsignedBigInteger('id_catalogo');
            $table->string('nombre_insumo', 100);
            $table->string('descripcion', 250)->nullable();

            $table->foreign('id_catalogo')->references('id')->on('catalogo_insumos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_insumo');
    }
};
