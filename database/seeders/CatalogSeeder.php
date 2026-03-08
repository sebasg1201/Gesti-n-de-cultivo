<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CatalogoSemilla;
use App\Models\CatalogoSuelo;
use App\Models\CatalogoRiego;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        // 1. Seeds
        $seedsPath = database_path('data/seeds_catalog.json');
        if (File::exists($seedsPath)) {
            $seeds = json_decode(File::get($seedsPath), true);
            foreach ($seeds as $seed) {
                CatalogoSemilla::updateOrCreate(
                    ['nombre' => $seed['nombre']],
                    [
                        'descripcion' => $seed['descripcion'],
                        'tiempo_base_dias' => $seed['tiempo_base_dias'],
                        'rendimiento_promedio' => $seed['rendimiento_promedio'] ?? 0,
                    ]
                );
            }
        }

        // 2. Soils
        $soilsPath = database_path('data/soils_catalog.json');
        if (File::exists($soilsPath)) {
            $soils = json_decode(File::get($soilsPath), true);
            foreach ($soils as $soil) {
                CatalogoSuelo::updateOrCreate(
                    ['nombre' => $soil['nombre']],
                    [
                        'impacto_dias' => $soil['impacto_dias'],
                        'descripcion' => $soil['descripcion'] ?? null,
                    ]
                );
            }
        }

        // 3. Irrigation
        $irrigationPath = database_path('data/irrigation_catalog.json');
        if (File::exists($irrigationPath)) {
            $irrigationList = json_decode(File::get($irrigationPath), true);
            foreach ($irrigationList as $irrigation) {
                CatalogoRiego::updateOrCreate(
                    ['nombre' => $irrigation['nombre']],
                    [
                        'impacto_dias' => $irrigation['impacto_dias'],
                        'descripcion_tecnica' => $irrigation['descripcion_tecnica'] ?? null,
                    ]
                );
            }
        }
    }
}
