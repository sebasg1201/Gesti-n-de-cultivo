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
        Schema::create('insumo', function (Blueprint $table) {
            $table->id('ID_insumo');
            $table->string('Nombre');
            $table->string('Calidad')->nullable();
            $table->integer('cantidad_stock')->default(0);
            $table->date('Fecha_ingreso')->nullable();
            $table->date('Fecha_vencimiento')->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_proveedor')->nullable();
            $table->string('id_empresa', 20)->nullable();
            $table->timestamps();
        });

        Schema::table('insumo', function (Blueprint $table) {
            $table->foreign('id_proveedor', 'fk_insumo_prov_123')->references('id_proveedor')->on('proveedor')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumo');
    }
};
