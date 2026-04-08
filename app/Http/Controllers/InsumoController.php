<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\CatalogoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsumoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Insumo::with(['catalogo.tipoInsumo'])
            ->where('id_empresa', $id_empresa);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $insumos = $query->orderBy('created_at', 'desc')->paginate(10);
        $tiposInsumo = \App\Models\TipoInsumo::all();

        $registeredCatalogoIds = Insumo::where('id_empresa', $id_empresa)
            ->whereNotNull('id_catalogo_insumo')
            ->pluck('id_catalogo_insumo')
            ->toArray();

        return view('admin.insumos.index', compact('insumos', 'tiposInsumo', 'registeredCatalogoIds'));
    }

    public function exportCSV(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Insumo::with(['catalogo.tipoInsumo'])
            ->where('id_empresa', $id_empresa);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $insumos = $query->get();

        $filename = "reporte_insumos_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nombre', 'Categoria', 'Stock Actual', 'Impacto Dias', 'F. Registro'];

        $callback = function() use($insumos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
            fputcsv($file, $columns, ';');

            foreach ($insumos as $insumo) {
                fputcsv($file, [
                    $insumo->ID_insumo,
                    $insumo->Nombre,
                    $insumo->catalogo->tipoInsumo->nombre ?? 'N/A',
                    $insumo->stock_actual,
                    $insumo->impacto_dias,
                    $insumo->created_at ? $insumo->created_at->format('Y-m-d') : 'N/A'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function catalog(Request $request)
    {
        $search = $request->get('q');

        $insumosCatalogo = CatalogoInsumo::with('tipoInsumo')
            ->where('nombre_comercial', 'LIKE', "%{$search}%")
            ->orWhere('descripcion', 'LIKE', "%{$search}%")
            ->get();

        return response()->json($insumosCatalogo);
    }

    public function store(Request $request)
    {
        $idEmpresa = $this->getEmpresaId();

        // Batch Store (from Tags/Chips)
        if ($request->has('items') && is_array($request->items)) {
            $createdCount = 0;
            foreach ($request->items as $item) {
                if (isset($item['id_catalogo_insumo']) && $item['id_catalogo_insumo']) {
                    $exists = Insumo::where('id_empresa', $idEmpresa)
                        ->where('id_catalogo_insumo', $item['id_catalogo_insumo'])
                        ->exists();
                    if ($exists) continue;
                }

                Insumo::create([
                    'id_empresa' => $idEmpresa,
                    'id_catalogo_insumo' => $item['id_catalogo_insumo'] ?: null,
                    'Nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'impacto_dias' => $item['impacto_dias'] ?? 0,
                    'stock_actual' => 0,
                    'cantidad_stock' => 0,
                ]);
                $createdCount++;
            }

            return redirect()->route('insumos.index')
                ->with('success', "$createdCount suministros añadidos correctamente.");
        }

        // Single Manual Store
        $request->validate([
            'id_catalogo_insumo' => 'nullable|exists:catalogo_insumos,id_catalogo_insumo',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'categoria_manual' => 'nullable|exists:tipo_insumo,id_tipo_insumo',
            'impacto_dias' => 'nullable|integer',
        ]);

        if ($request->filled('id_catalogo_insumo')) {
            $exists = Insumo::where('id_empresa', $idEmpresa)
                ->where('id_catalogo_insumo', $request->id_catalogo_insumo)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Este insumo ya está registrado en su inventario.');
            }
        }
        
        Insumo::create([
            'id_empresa' => $idEmpresa,
            'id_catalogo_insumo' => $request->id_catalogo_insumo ?: null,
            'Nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias ?? 0,
            'stock_actual' => 0,
            'cantidad_stock' => 0,
        ]);

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo configurado y añadido a su inventario (con stock inicial de 0).');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:250',
            'impacto_dias' => 'nullable|integer',
        ]);

        $insumo = Insumo::where('ID_insumo', $id)
            ->where('id_empresa', $this->getEmpresaId())
            ->firstOrFail();

        $insumo->update([
            'Nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'impacto_dias' => $request->impacto_dias ?? 0,
        ]);

        return redirect()->route('insumos.index')
            ->with('success', 'Información del insumo actualizada.');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();
        $insumo = Insumo::where('ID_insumo', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        // Verificar historial de entradas (facturas o ingresos de stock)
        $entradasContador = \App\Models\EntradaInsumo::where('id_insumo', $id)->count();
        if ($entradasContador > 0) {
            return redirect()->route('insumos.index')
                ->with('error', "No se puede eliminar el insumo. Tiene $entradasContador registro(s) de entrada de stock asociados.");
        }

        // Verificar historial de aplicaciones (uso en el campo)
        $aplicacionesContador = \App\Models\InsumoCosecha::where('id_insumo', $id)->count();
        if ($aplicacionesContador > 0) {
            return redirect()->route('insumos.index')
                ->with('error', "No se puede eliminar el insumo. Ha sido aplicado en $aplicacionesContador lote(s) de cultivo/cosecha.");
        }

        try {
            $insumo->delete();
            return redirect()->route('insumos.index')
                ->with('success', 'Insumo eliminado de su inventario correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('insumos.index')
                ->with('error', 'No se pudo eliminar el insumo debido a una relación activa en su base de datos.');
        }
    }
}
