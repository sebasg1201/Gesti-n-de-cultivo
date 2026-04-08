<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatalogoSemilla;
use App\Models\CatalogoSuelo;
use App\Models\CatalogoRiego;
use App\Models\CatalogoInsumo;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;
use App\Models\TipoSuelo;
use App\Models\Insumo;

class EmergencyRepairSeeder extends Seeder
{
    public function run()
    {
        // 1. Repair Seeds
        $userSeeds = TipoSemilla::all();
        foreach ($userSeeds as $us) {
            $cat = CatalogoSemilla::where('nombre', $us->nombre_semilla)->first();
            if ($cat) {
                $us->update(['id_catalogo' => $cat->id]);
            }
        }

        // 2. Repair Irrigation
        $userRiegos = TipoRiego::all();
        foreach ($userRiegos as $ur) {
            $cat = CatalogoRiego::where('nombre', $ur->tipo_riego)->first();
            if ($cat) {
                $ur->update(['id_catalogo' => $cat->id]);
            }
        }

        // 3. Repair Soils
        $userSuelos = TipoSuelo::all();
        foreach ($userSuelos as $usl) {
            $cat = CatalogoSuelo::where('nombre', $usl->nombre)->first();
            if ($cat) {
                $usl->update(['id_catalogo' => $cat->id]);
            }
        }

        // 4. Repair Insumos
        $userInsumos = Insumo::all();
        foreach ($userInsumos as $ui) {
            $cat = CatalogoInsumo::where('nombre_comercial', $ui->Nombre)->first();
            if ($cat) {
                $ui->update(['id_catalogo_insumo' => $cat->id_catalogo_insumo]);
            }
        }
    }
}
