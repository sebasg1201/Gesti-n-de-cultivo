<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Create catalogo_riegos
        Schema::create('catalogo_riegos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion_tecnica')->nullable();
            $table->timestamps();
        });

        // 2. Add id_catalogo to tipo_riego
        if (!Schema::hasColumn('tipo_riego', 'id_catalogo')) {
            Schema::table('tipo_riego', function (Blueprint $table) {
                $table->unsignedBigInteger('id_catalogo')->nullable()->after('id_empresa');
            });
        }

        // 3. Seed Irrigation Catalog
        DB::table('catalogo_riegos')->insert([
            ['nombre' => 'Goteo', 'descripcion_tecnica' => 'Suministro lento y directo a las raíces, ahorro máximo de agua.'],
            ['nombre' => 'Aspersión', 'descripcion_tecnica' => 'Simulación de lluvia, ideal para grandes superficies.'],
            ['nombre' => 'Micro-aspersión', 'descripcion_tecnica' => 'Riego fino para cultivos delicados o invernaderos.'],
            ['nombre' => 'Gravedad (Surcos)', 'descripcion_tecnica' => 'Distribución por canales, uso tradicional en terrenos planos.'],
            ['nombre' => 'Manual (Manguera/Balde)', 'descripcion_tecnica' => 'Aplicación directa controlada por el operario.'],
            ['nombre' => 'Hidropónico', 'descripcion_tecnica' => 'Circulación de solución nutritiva en agua.'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('catalogo_riegos');

        if (Schema::hasColumn('tipo_riego', 'id_catalogo')) {
            Schema::table('tipo_riego', function (Blueprint $table) {
                $table->dropColumn('id_catalogo');
            });
        }
    }
};
