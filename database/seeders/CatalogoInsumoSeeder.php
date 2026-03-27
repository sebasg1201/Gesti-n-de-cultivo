<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\TipoInsumo;
use App\Models\CatalogoInsumo;

class CatalogoInsumoSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/insumos_catalog.json');
        if (File::exists($jsonPath)) {
            $insumosList = json_decode(File::get($jsonPath), true);

            foreach ($insumosList as $insumo) {
                // Primero asegurar que el tipo existe
                $tipoModel = TipoInsumo::firstOrCreate(
                ['nombre' => $insumo['tipo_insumo']]
                );

                // Luego crear el insumo en el catálogo
                CatalogoInsumo::updateOrCreate(
                ['nombre_comercial' => $insumo['nombre_comercial']],
                [
                    'descripcion' => $insumo['descripcion'],
                    'impacto_dias' => $insumo['impacto_dias'],
                    'id_tipo_insumo' => $tipoModel->id_tipo_insumo
                ]
                );
            }
        }
    }
}
