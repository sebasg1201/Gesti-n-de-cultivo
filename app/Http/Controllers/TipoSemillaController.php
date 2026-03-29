<?php

namespace App\Http\Controllers;

use App\Models\TipoSemilla;
use App\Models\CatalogoSemilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoSemillaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index()
    {
        $id_empresa = $this->getEmpresaId();
        $tipoSemillas = TipoSemilla::with('catalogo')
            ->where('id_empresa', $id_empresa)
            ->paginate(10);

        $registeredIds = TipoSemilla::where('id_empresa', $id_empresa)
            ->whereNotNull('id_catalogo')
            ->pluck('id_catalogo')
            ->toArray();

        return view('admin.tipo_semillas.index', compact('tipoSemillas', 'registeredIds'));
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');
        $seeds = CatalogoSemilla::where('nombre', 'LIKE', "%{$search}%")->get();
        return response()->json($seeds);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        // Check if it's a batch store (from chips)
        if ($request->has('items')) {
            $items = $request->input('items');
            $createdCount = 0;

            foreach ($items as $item) {
                // Skip if already registered
                if (isset($item['id_catalogo']) && !empty($item['id_catalogo'])) {
                    $exists = TipoSemilla::where('id_empresa', $idEmpresa)
                        ->where('id_catalogo', $item['id_catalogo'])
                        ->exists();
                    if ($exists) continue;
                }

                TipoSemilla::create([
                    'id_empresa' => $idEmpresa,
                    'id_catalogo' => $item['id_catalogo'] ?: null,
                    'nombre_semilla' => $item['nombre_semilla'],
                    'tiempo_base_dias' => $item['tiempo_base_dias'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'rendimiento_promedio' => $item['rendimiento_promedio'] ?? 0,
                    'espacio_por_planta_m2' => $item['espacio_por_planta_m2'] ?? 0.5,
                    'stock_actual' => 0,
                ]);
                $createdCount++;
            }

            return redirect()->route('tipo_semillas.index')
                ->with('success', "$createdCount variedades añadidas correctamente.");
        }

        // Manual Single Store
        $request->validate([
            'id_catalogo' => 'nullable|exists:catalogo_semillas,id',
            'nombre_semilla' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'tiempo_base_dias' => 'required|integer|min:0',
            'rendimiento_promedio' => 'required|numeric|min:0',
            'espacio_por_planta_m2' => 'required|numeric|min:0.0001',
        ]);

        if ($request->filled('id_catalogo')) {
            $exists = TipoSemilla::where('id_empresa', $idEmpresa)
                ->where('id_catalogo', $request->id_catalogo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Esta variedad de semilla ya está registrada.');
            }
        }

        TipoSemilla::create([
            'id_empresa' => $idEmpresa,
            'id_catalogo' => $request->id_catalogo ?: null,
            'nombre_semilla' => $request->nombre_semilla,
            'tiempo_base_dias' => $request->tiempo_base_dias,
            'descripcion' => $request->descripcion,
            'rendimiento_promedio' => $request->rendimiento_promedio,
            'espacio_por_planta_m2' => $request->espacio_por_planta_m2,
            'stock_actual' => 0,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Variedad registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_semilla' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'tiempo_base_dias' => 'required|integer|min:0',
            'rendimiento_promedio' => 'required|numeric|min:0',
            'espacio_por_planta_m2' => 'required|numeric|min:0.0001',
        ]);

        $tipoSemilla = TipoSemilla::where('id_semilla', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSemilla->update([
            'nombre_semilla' => $request->nombre_semilla,
            'descripcion' => $request->descripcion,
            'tiempo_base_dias' => $request->tiempo_base_dias,
            'rendimiento_promedio' => $request->rendimiento_promedio,
            'espacio_por_planta_m2' => $request->espacio_por_planta_m2,
        ]);

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Información de la semilla actualizada.');
    }

    public function destroy($id)
    {
        $tipoSemilla = TipoSemilla::where('id_semilla', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $tipoSemilla->delete();

        return redirect()->route('tipo_semillas.index')
            ->with('success', 'Semilla eliminada de su catálogo correctamente.');
    }
}
