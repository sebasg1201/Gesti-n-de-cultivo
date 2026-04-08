<?php

namespace App\Http\Controllers;

use App\Models\TipoSuelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoSueloController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }
    public function index()
    {
        $id_empresa = $this->getEmpresaId();
        $tipoSuelos = TipoSuelo::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        $registeredIds = TipoSuelo::where('id_empresa', $id_empresa)
            ->whereNotNull('id_catalogo')
            ->pluck('id_catalogo')
            ->toArray();

        return view('admin.tipo_suelos.index', compact('tipoSuelos', 'registeredIds'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $suelos = \App\Models\CatalogoSuelo::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($suelos);
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        // Batch Store (Chips)
        if ($request->has('items') && is_array($request->items)) {
            $createdCount = 0;
            foreach ($request->items as $item) {
                if (isset($item['id_catalogo']) && $item['id_catalogo']) {
                    $exists = TipoSuelo::where('id_empresa', $id_empresa)
                        ->where('id_catalogo', $item['id_catalogo'])
                        ->exists();
                    if ($exists) continue;
                }

                TipoSuelo::create([
                    'id_empresa' => $id_empresa,
                    'id_catalogo' => $item['id_catalogo'] ?? null,
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'impacto_dias' => $item['impacto_dias'] ?? 0,
                    'capacidad_retencion_litros_m2' => $item['capacidad_retencion_litros_m2'] ?? 0,
                ]);
                $createdCount++;
            }
            return redirect()->route('tipo_suelos.index')
                ->with('success', "$createdCount suelos registrados.");
        }

        // Single Store (Manual)
        $request->validate([
            'id_catalogo' => 'nullable|exists:catalogo_suelos,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'impacto_dias' => 'required|integer',
            'capacidad_retencion_litros_m2' => 'nullable|numeric|min:0',
        ]);

        if ($request->filled('id_catalogo')) {
            $exists = TipoSuelo::where('id_empresa', $id_empresa)
                ->where('id_catalogo', $request->id_catalogo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Este tipo de suelo ya está configurado.');
            }
        }

        TipoSuelo::create([
            'id_empresa' => $id_empresa,
            'id_catalogo' => $request->id_catalogo ?: null,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias,
            'capacidad_retencion_litros_m2' => $request->capacidad_retencion_litros_m2 ?? 0,
        ]);

        return redirect()->route('tipo_suelos.index')
            ->with('success', 'Suelo configurado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'impacto_dias' => 'required|integer',
            'capacidad_retencion_litros_m2' => 'nullable|numeric|min:0',
        ]);

        $tipoSuelo = TipoSuelo::where('id_tipo_suelo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSuelo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias,
            'capacidad_retencion_litros_m2' => $request->capacidad_retencion_litros_m2,
        ]);

        return redirect()->route('tipo_suelos.index')
            ->with('success', 'Tipo de suelo actualizado correctamente');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();
        $tipoSuelo = TipoSuelo::where('id_tipo_suelo', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        // Verificar si está siendo usado en terrenos
        $usosTerreno = \App\Models\Terreno::where('id_tipo_suelo', $id)
            ->where('id_empresa', $id_empresa)
            ->count();
            
        if ($usosTerreno > 0) {
            return redirect()->route('tipo_suelos.index')
                ->with('error', "No se puede eliminar el tipo de suelo. Está configurado en $usosTerreno terreno(s) de su empresa.");
        }

        try {
            $tipoSuelo->delete();
            return redirect()->route('tipo_suelos.index')
                ->with('success', 'Tipo de suelo eliminado correctamente de su configuración.');
        } catch (\Exception $e) {
            return redirect()->route('tipo_suelos.index')
                ->with('error', 'No se pudo eliminar el tipo de suelo debido a registros internos asociados.');
        }
    }
}
