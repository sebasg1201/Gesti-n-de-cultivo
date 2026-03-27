<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cultivo;
use App\Models\Cosecha;
use App\Models\Producto;
use App\Models\DetalleProductoCultivo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CultivoController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $id_semilla = $request->query('id_semilla');
        $month = $request->get('month');
        $year = $request->get('year');

        $semillaSeleccionada = null;
        if ($id_semilla) {
            $semillaSeleccionada = \App\Models\TipoSemilla::where('id_empresa', $id_empresa)->findOrFail($id_semilla);
            
            $query = Cosecha::where('id_empresa', $id_empresa)
                ->where('id_semilla', $id_semilla)
                ->with(['semilla', 'terreno']);

            if ($month) {
                $query->whereMonth('fecha_siembra', $month); // Opcionalmente filtrar por fecha de siembra aquí también
            }
            if ($year) {
                $query->whereYear('fecha_siembra', $year);
            }

            $cosechas = $query->orderBy('fecha_siembra', 'desc')->get();
                
            return view('admin.cultivos.index', compact('cosechas', 'semillaSeleccionada'));
        }

        // Si no hay semilla seleccionada, filtrar las recolecciones globales si es necesario para el reporte
        // Pero la vista actual solo muestra categorías. 
        // Implementaremos el exportador para todas las recolecciones de la empresa.

        $categorias = \App\Models\TipoSemilla::where('id_empresa', $id_empresa)
            ->whereHas('cosechas', function($q) use ($id_empresa) {
                $q->where('id_empresa', $id_empresa);
            })
            ->withCount(['cosechas' => function($q) use ($id_empresa) {
                $q->where('id_empresa', $id_empresa);
            }])
            ->get()
            ->map(function($cat) {
                $cosechaConImagen = \App\Models\Cosecha::where('id_semilla', $cat->id_semilla)
                    ->whereNotNull('imagenes')
                    ->first();
                
                $cat->imagen_portada = $cosechaConImagen ? $cosechaConImagen->imagenes : null;
                return $cat;
            });

        return view('admin.cultivos.index', compact('categorias'));
    }

    public function exportCSV(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Cultivo::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['cosecha.semilla', 'detalles.producto', 'trabajador']);

        if ($month) {
            $query->whereMonth('fecha_recoleccion', $month);
        }
        if ($year) {
            $query->whereYear('fecha_recoleccion', $year);
        }

        $recolecciones = $query->orderBy('fecha_recoleccion', 'desc')->get();

        $filename = "reporte_recoleccion_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Variedad', 'Producto', 'Cantidad', 'Unidad', 'F. Recoleccion', 'Trabajador'];

        $callback = function() use($recolecciones, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
            fputcsv($file, $columns, ';');

            foreach ($recolecciones as $cultivo) {
                foreach ($cultivo->detalles as $detalle) {
                    fputcsv($file, [
                        $cultivo->id_cultivo,
                        $cultivo->cosecha->semilla->nombre ?? 'N/A',
                        $detalle->producto->nombre ?? 'N/A',
                        $detalle->cantidad,
                        'Unidades', // O el campo que corresponda
                        $cultivo->fecha_recoleccion,
                        $cultivo->trabajador->nombre ?? 'N/A'
                    ], ';');
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $id_cosecha = $request->query('id_cosecha');

        $cosecha = null;
        $productoReferencia = '';

        if ($id_cosecha) {
            $cosecha = Cosecha::where('id_empresa', $id_empresa)
                ->with(['semilla', 'terreno'])
                ->findOrFail($id_cosecha);
            
            // Sugerir nombre de producto basado en la semilla
            $productoReferencia = $cosecha->semilla->nombre_semilla ?? '';
        }

        $trabajadores = Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3) // 3 = trabajador
            ->get();

        return view('admin.cultivos.create', compact('cosecha', 'trabajadores', 'id_cosecha', 'productoReferencia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cosecha' => 'required|exists:cosecha,id_cosecha',
            'documento_trabajador' => 'required|exists:usuario,documento',
            'fecha_recoleccion' => 'required|date',
            'observaciones' => 'nullable|string'
        ]);

        $id_empresa = $this->getEmpresaId();
        $cosecha = Cosecha::where('id_empresa', $id_empresa)->findOrFail($request->id_cosecha);

        try {
            // Crear el registro de cultivo como tarea pendiente
            Cultivo::create([
                'fecha_recoleccion' => $request->fecha_recoleccion,
                'id_cosecha' => $cosecha->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'descripcion_recoleccion' => $request->observaciones,
                'id_estado' => 1 // Pendiente
            ]);

            return redirect()->route('admin.cultivos.index')->with('success', 'Tarea de recolección asignada al trabajador exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al asignar la recolección: ' . $e->getMessage())->withInput();
        }
    }

    public function finalize($id)
    {
        $id_empresa = $this->getEmpresaId();
        $cosecha = Cosecha::where('id_empresa', $id_empresa)->findOrFail($id);

        try {
            DB::beginTransaction();

            $cosecha->id_estado = 14; // Finalizado/Recolectado
            $cosecha->save();

            if ($cosecha->terreno) {
                $cosecha->terreno->id_estado = 7; // Disponible
                $cosecha->terreno->save();
            }

            DB::commit();
            return redirect()->route('admin.cosechas.index')->with('success', 'Cosecha finalizada y terreno liberado correctamente (Estado: Disponible). El registro histórico se mantiene en Recolección.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al finalizar la cosecha: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cultivo = Cultivo::whereHas('cosecha', function ($query) use ($id_empresa) {
            $query->where('id_empresa', $id_empresa);
        })
        ->with(['cosecha.semilla', 'trabajador', 'detalles.producto', 'cosecha.terreno'])
        ->findOrFail($id);
            
        // Get all sister harvests for the same mother Cosecha
        $historialCosecha = Cultivo::with(['detalles.producto', 'trabajador'])
            ->where('id_cosecha', $cultivo->id_cosecha)
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();

        return view('admin.cultivos.show', compact('cultivo', 'historialCosecha'));
    }
    public function cosechaDetail($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cosecha = Cosecha::where('id_empresa', $id_empresa)
            ->with(['semilla', 'terreno', 'cultivos.detalles.producto', 'cultivos.trabajador'])
            ->findOrFail($id);

        return view('admin.cultivos.cosecha_detail', compact('cosecha'));
    }
}
