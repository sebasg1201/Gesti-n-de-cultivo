<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\CatalogoSemilla;
use App\Models\CatalogoSuelo;
use App\Models\CatalogoRiego;
use App\Models\CatalogoInsumo;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;
use App\Models\TipoSuelo;
use App\Models\Insumo;

class CleanDuplicatesSeeder extends Seeder
{
    public function run()
    {
        // 1. Seeds
        $this->mergeBySource(
            database_path('data/seeds_catalog.json'),
            CatalogoSemilla::class,
            TipoSemilla::class,
            'id_catalogo',
            'nombre',
            'id'
        );

        // 2. Riegos
        $this->mergeBySource(
            database_path('data/irrigation_catalog.json'),
            CatalogoRiego::class,
            TipoRiego::class,
            'id_catalogo',
            'nombre',
            'id'
        );

        // 3. Suelos
        $this->mergeBySource(
            database_path('data/soils_catalog.json'),
            CatalogoSuelo::class,
            TipoSuelo::class,
            'id_catalogo',
            'nombre',
            'id'
        );

        // 4. Insumos
        $this->mergeBySource(
            database_path('seeders/insumos_catalog.json'),
            CatalogoInsumo::class,
            Insumo::class,
            'id_catalogo_insumo',
            'nombre_comercial',
            'id_catalogo_insumo'
        );
    }

    private function mergeBySource($jsonPath, $modelClass, $referenceClass, $foreignKey, $nameColumn, $pkName)
    {
        if (!File::exists($jsonPath)) return;

        $items = json_decode(File::get($jsonPath), true);
        foreach ($items as $item) {
            $cleanName = ($modelClass == CatalogoInsumo::class) ? $item['nombre_comercial'] : $item['nombre'];
            
            // Find the GOOD record
            $good = $modelClass::where($nameColumn, $cleanName)->first();
            if (!$good) continue;

            // Strategy: Create a pattern from the clean name replacing accents with %
            // Fríjol -> Fr%jol
            $pattern = preg_replace('/[áéíóúñÁÉÍÓÚÑ]/u', '%', $cleanName);
            
            $bads = $modelClass::where($nameColumn, 'LIKE', $pattern)
                ->where($nameColumn, 'LIKE', '%?%')
                ->where($pkName, '!=', $good->$pkName)
                ->get();

            foreach ($bads as $bad) {
                // Remap
                $referenceClass::where($foreignKey, $bad->$pkName)->update([
                    $foreignKey => $good->$pkName
                ]);
                // Delete
                $bad->delete();
            }
        }
    }
}
