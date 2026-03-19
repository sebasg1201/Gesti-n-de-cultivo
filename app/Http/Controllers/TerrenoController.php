<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TerrenoController extends Controller
{
    private function getEmpresaId()
    {
        $user = Auth::guard('usuario')->user();
        if (!$user) {
            abort(403, 'Sesión expirada o acceso no autorizado.');
        }
        return $user->id_empresa;
    }
    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');
        $ciudad = $request->get('ciudad');

        $query = \App\Models\Terreno::with(['tipoSuelo', 'estado'])
            ->where('id_empresa', $id_empresa);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }
        if ($ciudad) {
            $query->where('ciudad', 'like', "%$ciudad%");
        }

        $terrenos = $query->orderBy('created_at', 'desc')->paginate(10);

        $tipoSuelos = \App\Models\TipoSuelo::where('id_empresa', $id_empresa)->get();
        $estados = \App\Models\Estado::all();
        
        // Obtener lista de municipios únicos para el filtro
        $municipios = \App\Models\Terreno::where('id_empresa', $id_empresa)
            ->whereNotNull('ciudad')
            ->distinct()
            ->pluck('ciudad');

        return view('admin.terreno.index', compact('terrenos', 'tipoSuelos', 'estados', 'municipios'));
    }

    public function exportCSV(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');
        $ciudad = $request->get('ciudad');

        $query = \App\Models\Terreno::with(['tipoSuelo', 'estado'])
            ->where('id_empresa', $id_empresa);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }
        if ($ciudad) {
            $query->where('ciudad', 'like', "%$ciudad%");
        }

        $terrenos = $query->get();

        $filename = "reporte_terrenos_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nombre', 'Ubicacion', 'Departamento', 'Ciudad/Municipio', 'Cod. Postal', 'Area (m2)', 'Suelo', 'Estado', 'F. Registro'];

        $callback = function() use($terrenos, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
            fputcsv($file, $columns, ';');

            foreach ($terrenos as $terreno) {
                fputcsv($file, [
                    $terreno->id_terreno,
                    $terreno->nombre,
                    $terreno->ubicacion,
                    $terreno->departamento,
                    $terreno->ciudad,
                    $terreno->codigo_postal,
                    $terreno->Ancho * $terreno->Alto,
                    $terreno->tipoSuelo->nombre ?? 'N/A',
                    $terreno->estado->nombre_estado ?? 'N/A',
                    $terreno->created_at ? $terreno->created_at->format('Y-m-d') : 'N/A'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'nullable|string|max:150',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo',
            'departamento' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100'
        ]);

        // Check if a Terreno with same name exists for the company
        $exists = \App\Models\Terreno::where('id_empresa', $id_empresa)
            ->where('nombre', $request->nombre)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Ya existe un terreno con este nombre.');
        }

        \App\Models\Terreno::create([
            'id_empresa' => $id_empresa,
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'Ancho' => $request->Ancho,
            'Alto' => $request->Alto,
            'id_estado' => 7, // 7 = Disponible
            'id_tipo_suelo' => $request->id_tipo_suelo,
            'departamento' => $request->departamento,
            'codigo_postal' => $request->codigo_postal,
            'ciudad' => $request->ciudad,
        ]);

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'ubicacion' => 'nullable|string|max:150',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'Ancho' => 'required|numeric|min:1',
            'Alto' => 'required|numeric|min:1',
            'id_tipo_suelo' => 'required|exists:tipo_suelo,id_tipo_suelo',
            'id_estado' => 'required|exists:estado,id_estado',
            'departamento' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100'
        ]);

        $terreno = \App\Models\Terreno::where('id_terreno', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        $terreno->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'Ancho' => $request->Ancho,
            'Alto' => $request->Alto,
            'id_tipo_suelo' => $request->id_tipo_suelo,
            'id_estado' => $request->id_estado,
            'departamento' => $request->departamento,
            'codigo_postal' => $request->codigo_postal,
            'ciudad' => $request->ciudad,
        ]);

        return redirect()->route('admin.terrenos.index')
            ->with('success', 'Terreno actualizado correctamente');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();

        $terreno = \App\Models\Terreno::where('id_terreno', $id)
            ->where('id_empresa', $id_empresa)
            ->firstOrFail();

        // Verificar si tiene cosechas asociadas
        if ($terreno->cosechas()->count() > 0) {
            return redirect()->route('admin.terrenos.index')
                ->with('error', 'No se puede eliminar el terreno porque tiene cosechas asociadas. Por favor, elimine las cosechas primero.');
        }

        try {
            $terreno->delete();
            return redirect()->route('admin.terrenos.index')
                ->with('success', 'Terreno eliminado correctamente');
        } catch (\Exception $e) {
            Log::error("Error eliminando terreno: " . $e->getMessage());
            return redirect()->route('admin.terrenos.index')
                ->with('error', 'Ocurrió un error al intentar eliminar el terreno.');
        }
    }
}
