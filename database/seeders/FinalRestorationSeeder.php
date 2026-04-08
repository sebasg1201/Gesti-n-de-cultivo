<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\CatalogoSemilla;
use App\Models\CatalogoSuelo;
use App\Models\CatalogoRiego;
use App\Models\CatalogoInsumo;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;
use App\Models\TipoSuelo;
use App\Models\Insumo;

class FinalRestorationSeeder extends Seeder
{
    public function run()
    {
        // 1. Seeds
        $this->fullCleanup(
            database_path('data/seeds_catalog.json'),
            CatalogoSemilla::class,
            TipoSemilla::class,
            'id_catalogo',
            'nombre',
            ['tiempo_base_dias', 'rendimiento_promedio'],
            'id'
        );

        // 2. Riegos
        $this->fullCleanup(
            database_path('data/irrigation_catalog.json'),
            CatalogoRiego::class,
            TipoRiego::class,
            'id_catalogo',
            'nombre',
            ['impacto_dias'],
            'id'
        );

        // 3. Suelos
        $this->fullCleanup(
            database_path('data/soils_catalog.json'),
            CatalogoSuelo::class,
            TipoSuelo::class,
            'id_catalogo',
            'nombre',
            ['impacto_dias'],
            'id'
        );

        // 4. Insumos (Use special name column)
        $this->fullCleanup(
            database_path('seeders/insumos_catalog.json'),
            CatalogoInsumo::class,
            Insumo::class,
            'id_catalogo_insumo',
            'nombre_comercial',
            ['impacto_dias'],
            'id_catalogo_insumo'
        );
    }

    private function fullCleanup($jsonPath, $modelClass, $refClass, $fk, $nameCol, $matchAttrs, $pkName)
    {
        if (!File::exists($jsonPath)) return;

        $items = json_decode(File::get($jsonPath), true);
        $validIds = [];

        foreach ($items as $item) {
            $jsonName = ($nameCol == 'nombre_comercial') ? $item['nombre_comercial'] : $item['nombre'];

            // Find best match in DB by comparing numeric attributes
            $query = $modelClass::query();
            foreach ($matchAttrs as $attr) {
                $query->where($attr, (float)$item[$attr]);
            }
            
            // Also try to filter by a prefix of the name to be extra safe
            $query->where($nameCol, 'LIKE', mb_substr($jsonName, 0, 3) . '%');
            
            $matches = $query->get();

            if ($matches->count() > 0) {
                $master = $matches->shift();
                $master->update([$nameCol => $jsonName]);
                $validIds[] = $master->$pkName;

                foreach ($matches as $dup) {
                    $refClass::where($fk, $dup->$pkName)->update([$fk => $master->$pkName]);
                    $dup->delete();
                }
            } else {
                // If it doesn't exist, we must create it properly for Insumos
                if ($modelClass == CatalogoInsumo::class) {
                    $new = $modelClass::create([
                        'nombre_comercial' => $jsonName,
                        'descripcion' => $item['descripcion'],
                        'impacto_dias' => $item['impacto_dias'],
                        'id_tipo_insumo' => \App\Models\TipoInsumo::firstOrCreate(['nombre' => $item['tipo_insumo']])->id_tipo_insumo
                    ]);
                } else {
                    $new = $modelClass::create($item);
                }
                $validIds[] = $new->$pkName;
            }
        }

        // Wipe ANY leftover that isn't a master
        $modelClass::whereNotIn($pkName, $validIds)->get()->each(function ($leftover) use ($modelClass, $refClass, $fk, $nameCol, $validIds, $pkName) {
            // Remap to closest master by name prefix before deleting
            $prefix = mb_substr($leftover->$nameCol, 0, 3);
            $closest = $modelClass::whereIn($pkName, $validIds)
                ->where($nameCol, 'LIKE', $prefix . '%')
                ->first();
            
            if ($closest) {
                $refClass::where($fk, $leftover->$pkName)->update([$fk => $closest->$pkName]);
            }
            $leftover->delete();
        });
    }
}
