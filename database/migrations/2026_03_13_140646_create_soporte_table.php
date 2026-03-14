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
        if (!Schema::hasTable('soporte')) {
            Schema::create('soporte', function (Blueprint $table) {
                $table->id('id_soporte');
                $table->bigInteger('documento_trabajador')->index();
                $table->string('id_empresa')->index();
                $table->string('asunto');
                $table->text('mensaje');
                $table->text('respuesta')->nullable();
                $table->string('estado')->default('Pendiente'); // Pendiente, Respondido, Cerrado
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soporte');
    }
};
