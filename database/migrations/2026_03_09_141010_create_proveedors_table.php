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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->string('nombre');
            $table->string('producto')->nullable();
            $table->integer('cantidad')->default(0);
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('ID_insumo')->nullable();
            $table->string('id_empresa', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
