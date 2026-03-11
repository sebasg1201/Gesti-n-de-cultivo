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
        Schema::create('catalogo_insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion', 250)->nullable();
        });

        // Insert default items
        DB::table('catalogo_insumos')->insert([
            ['nombre' => 'Semillas', 'descripcion' => 'Semillas para siembra de todo tipo de cultivo'],
            ['nombre' => 'Abono', 'descripcion' => 'Abonos y fertilizantes orgánicos o sintéticos'],
            ['nombre' => 'Químicos', 'descripcion' => 'Productos químicos generales para mantenimiento agrícola'],
            ['nombre' => 'Venenos/Plaguicidas', 'descripcion' => 'Control de plagas e insectos'],
            ['nombre' => 'Herbicidas', 'descripcion' => 'Control de malezas'],
            ['nombre' => 'Fungicidas', 'descripcion' => 'Tratamiento contra hongos'],
            ['nombre' => 'Herramientas', 'descripcion' => 'Herramientas menores o implementos'],
            ['nombre' => 'Otros', 'descripcion' => 'Otros insumos agrícolas'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_insumos');
    }
};
