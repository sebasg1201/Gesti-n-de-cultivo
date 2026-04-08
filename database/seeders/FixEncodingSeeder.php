<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\CatalogoSemilla;
use App\Models\CatalogoSuelo;
use App\Models\CatalogoRiego;
use App\Models\CatalogoInsumo;
use App\Models\TipoInsumo;
use App\Models\TipoRiego;
use App\Models\Insumo;

class FixEncodingSeeder extends Seeder
{
    public function run()
    {
        // Force conversion of tables first to be absolutely sure
        $tables = ['catalogo_riegos', 'catalogo_semillas', 'catalogo_suelos', 'catalogo_insumos', 'tipo_insumo', 'tipo_riego', 'insumo'];
        foreach ($tables as $table) {
            try {
                DB::statement("ALTER TABLE $table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            } catch (\Exception $e) { /* ignore if fails */ }
        }

        // 1. Irrigation
        $irrigationPath = database_path('data/irrigation_catalog.json');
        if (File::exists($irrigationPath)) {
            $list = json_decode(File::get($irrigationPath), true);
            foreach ($list as $item) {
                // Fix Catalog
                $prefix = substr($item['nombre'], 0, 5);
                CatalogoRiego::where('nombre', 'LIKE', $prefix . '%')->update([
                    'nombre' => $item['nombre'],
                    'descripcion_tecnica' => $item['descripcion_tecnica'] ?? null,
                    'impacto_dias' => $item['impacto_dias']
                ]);
                
                // Fix User Data (TipoRiego)
                TipoRiego::where('tipo_riego', 'LIKE', $prefix . '%')->update([
                    'tipo_riego' => $item['nombre']
                ]);
            }
        }

        // 2. Seeds
        $seedsPath = database_path('data/seeds_catalog.json');
        if (File::exists($seedsPath)) {
            $list = json_decode(File::get($seedsPath), true);
            foreach ($list as $item) {
                $prefix = substr($item['nombre'], 0, 5);
                CatalogoSemilla::where('nombre', 'LIKE', $prefix . '%')->update([
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion'],
                    'tiempo_base_dias' => $item['tiempo_base_dias']
                ]);
            }
        }

        // 3. Soils
        $soilsPath = database_path('data/soils_catalog.json');
        if (File::exists($soilsPath)) {
            $list = json_decode(File::get($soilsPath), true);
            foreach ($list as $item) {
                $prefix = substr($item['nombre'], 0, 5);
                CatalogoSuelo::where('nombre', 'LIKE', $prefix . '%')->update([
                    'nombre' => $item['nombre'],
                    'impacto_dias' => $item['impacto_dias'],
                    'descripcion' => $item['descripcion'] ?? null
                ]);
            }
        }

        // 4. Insumos
        $insumosPath = database_path('seeders/insumos_catalog.json');
        if (File::exists($insumosPath)) {
            $list = json_decode(File::get($insumosPath), true);
            foreach ($list as $item) {
                $prefix = substr($item['nombre_comercial'], 0, 5);
                
                // Fix TipoInsumo
                $tipoPrefix = substr($item['tipo_insumo'], 0, 4);
                $tipo = TipoInsumo::where('nombre', 'LIKE', $tipoPrefix . '%')->first();
                if ($tipo) {
                    $tipo->update(['nombre' => $item['tipo_insumo']]);
                } else {
                    $tipo = TipoInsumo::firstOrCreate(['nombre' => $item['tipo_insumo']]);
                }

                // Fix Catalog Insumo
                CatalogoInsumo::where('nombre_comercial', 'LIKE', $prefix . '%')->update([
                    'nombre_comercial' => $item['nombre_comercial'],
                    'descripcion' => $item['descripcion'],
                    'impacto_dias' => $item['impacto_dias'],
                    'id_tipo_insumo' => $tipo->id_tipo_insumo
                ]);

                // Fix User Data (Insumo)
                Insumo::where('Nombre', 'LIKE', $prefix . '%')->update([
                    'Nombre' => $item['nombre_comercial']
                ]);
            }
        }
    }
}
