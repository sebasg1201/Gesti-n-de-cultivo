<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\EntradaInsumo;
use App\Models\Insumo;
use App\Models\TipoSemilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = Proveedor::where('id_empresa', $id_empresa);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('producto', 'like', "%{$search}%")
                    ->orWhere('contacto', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderBy('id_proveedor', 'desc')->paginate(10);
        
        return view('admin.proveedores.index', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'producto' => 'nullable|string|max:100',
            'contacto' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('proveedor', 'contacto')->where('id_empresa', $id_empresa)
            ],
        ], [
            'contacto.unique' => 'Este número de contacto ya está registrado para otro proveedor en su empresa.'
        ]);

        Proveedor::create([
            'nombre' => $request->nombre,
            'producto' => $request->producto,
            'contacto' => $request->contacto,
            'id_empresa' => $id_empresa,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor registrado exitosamente.');
    }

    public function buscarItems(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $search = $request->query('q', '');

        $insumos = Insumo::where('id_empresa', $id_empresa)
            ->where('Nombre', 'like', "%{$search}%")
            ->get()
            ->map(function($i) {
                return [
                    'id' => $i->ID_insumo,
                    'nombre' => $i->Nombre,
                    'tipo' => 'insumo',
                    'unidad' => $i->Unidad_medida ?? 'UNID'
                ];
            });

        $semillas = TipoSemilla::where('id_empresa', $id_empresa)
            ->where('nombre_semilla', 'like', "%{$search}%")
            ->get()
            ->map(function($s) {
                return [
                    'id' => $s->id_semilla,
                    'nombre' => $s->nombre_semilla,
                    'tipo' => 'semilla',
                    'unidad' => 'UNID'
                ];
            });

        return response()->json($insumos->concat($semillas));
    }

    public function storeEntrada(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();
        
        try {
            $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Illuminate\Support\Facades\Log::error("Proveedor no encontrado ID: $id para empresa ID: $id_empresa");
            return redirect()->route('admin.proveedores.index')->with('error', 'El proveedor no pertenece a su empresa o no existe.');
        }

        $request->validate([
            'tipo_item' => 'required|in:insumo,semilla',
            'id_item' => 'required',
            'cantidad_recibida' => 'required|numeric|min:0.01',
            'precio_unitario' => 'nullable|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $id_insumo = null;
            $id_semilla = null;

            if ($request->tipo_item === 'insumo') {
                $id_insumo = $request->id_item;
                $item = Insumo::where('ID_insumo', $id_insumo)->where('id_empresa', $id_empresa)->firstOrFail();
                if ($request->filled('fecha_vencimiento')) {
                    $item->Fecha_vencimiento = $request->fecha_vencimiento;
                }
                $item->save();
            } else {
                $id_semilla = $request->id_item;
                $item = TipoSemilla::where('id_semilla', $id_semilla)->where('id_empresa', $id_empresa)->firstOrFail();
                $item->save();
            }

            EntradaInsumo::create([
                'id_proveedor' => $proveedor->id_proveedor,
                'id_insumo' => $id_insumo,
                'id_semilla' => $id_semilla,
                'id_empresa' => $id_empresa,
                'cantidad_recibida' => $request->cantidad_recibida,
                'fecha_entrada' => now(),
                'precio_unitario' => $request->precio_unitario,
            ]);

            DB::commit();
            return redirect()->route('admin.proveedores.index')->with('success', 'Entrada de inventario registrada y stock actualizado.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Item no encontrado Tipo: {$request->tipo_item}, ID: {$request->id_item} para empresa: $id_empresa");
            return redirect()->back()->withInput()->with('error', 'El producto seleccionado no pertenece a su empresa o no existe.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Error en storeEntrada: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al procesar la entrada: ' . $e->getMessage());
        }
    }

    public function historial($id)
    {
        $id_empresa = $this->getEmpresaId();
        $entradas = EntradaInsumo::with(['insumo', 'semilla'])
            ->where('id_proveedor', $id)
            ->where('id_empresa', $id_empresa)
            ->orderBy('fecha_entrada', 'desc')
            ->get();

        return response()->json($entradas);
    }

    public function update(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();
        $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'producto' => 'nullable|string|max:100',
            'contacto' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('proveedor', 'contacto')
                    ->where('id_empresa', $id_empresa)
                    ->ignore($id, 'id_proveedor')
            ],
        ], [
            'contacto.unique' => 'Este número de contacto ya está registrado para otro proveedor en su empresa.'
        ]);

        $proveedor->update([
            'nombre' => $request->nombre,
            'producto' => $request->producto,
            'contacto' => $request->contacto,
        ]);

        return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function entradasDashboard(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        
        // Month calculations
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;

        $selectedProviderId = $request->input('proveedor');

        $statsQuery = EntradaInsumo::where('id_empresa', $id_empresa);

        if ($selectedProviderId) {
            $statsQuery->where('id_proveedor', $selectedProviderId);

            $totalEntradasMes = (clone $statsQuery)->count();
            $valorTotalRecibido = (clone $statsQuery)->sum(DB::raw('cantidad_recibida * precio_unitario'));
            $porcentajeCrecimiento = 0;
            $promedioPorEntrada = $totalEntradasMes > 0 ? $valorTotalRecibido / $totalEntradasMes : 0;

            $providerRef = Proveedor::find($selectedProviderId);
            $proveedorMasActivo = (object)[
                'nombre' => $providerRef->nombre ?? 'N/A',
                'total' => $totalEntradasMes,
                'is_selection' => true
            ];
        } else {
            $totalEntradasMes = (clone $statsQuery)
                ->whereMonth('fecha_entrada', $currentMonth)
                ->whereYear('fecha_entrada', $currentYear)
                ->count();

            $totalEntradasMesAnterior = (clone $statsQuery)
                ->whereMonth('fecha_entrada', $lastMonth)
                ->whereYear('fecha_entrada', $lastMonthYear)
                ->count();

            $porcentajeCrecimiento = 0;
            if ($totalEntradasMesAnterior > 0) {
                $porcentajeCrecimiento = (($totalEntradasMes - $totalEntradasMesAnterior) / $totalEntradasMesAnterior) * 100;
            } elseif ($totalEntradasMes > 0) {
                $porcentajeCrecimiento = 100;
            }

            $proveedorMasActivo = DB::table('entrada_insumo')
                ->join('proveedor', 'entrada_insumo.id_proveedor', '=', 'proveedor.id_proveedor')
                ->select('proveedor.nombre', DB::raw('count(*) as total'))
                ->where('entrada_insumo.id_empresa', $id_empresa)
                ->whereMonth('entrada_insumo.fecha_entrada', $currentMonth)
                ->whereYear('entrada_insumo.fecha_entrada', $currentYear)
                ->groupBy('proveedor.id_proveedor', 'proveedor.nombre')
                ->orderByDesc('total')
                ->first();

            $valorTotalRecibido = (clone $statsQuery)
                ->whereMonth('fecha_entrada', $currentMonth)
                ->whereYear('fecha_entrada', $currentYear)
                ->sum(DB::raw('cantidad_recibida * precio_unitario'));

            $promedioPorEntrada = $totalEntradasMes > 0 ? $valorTotalRecibido / $totalEntradasMes : 0;
        }

        $promedioPorEntrada = $totalEntradasMes > 0 ? $valorTotalRecibido / $totalEntradasMes : 0;

        $query = EntradaInsumo::with(['proveedor', 'insumo', 'semilla'])
            ->where('id_empresa', $id_empresa);

        if ($request->filled('proveedor')) {
            $query->where('id_proveedor', $request->proveedor);
            $entradas = $query->orderBy('fecha_entrada', 'desc')->paginate(15);
            $isGrouped = false;
        } else {
            // Group by provider to show each person only once
            $entradas = DB::table('entrada_insumo')
                ->join('proveedor', 'entrada_insumo.id_proveedor', '=', 'proveedor.id_proveedor')
                ->select(
                    'proveedor.id_proveedor',
                    'proveedor.nombre',
                    'proveedor.producto as especialidad',
                    DB::raw('count(*) as total_registros'),
                    DB::raw('sum(cantidad_recibida * precio_unitario) as valor_total'),
                    DB::raw('max(fecha_entrada) as ultima_fecha')
                )
                ->where('entrada_insumo.id_empresa', $id_empresa)
                ->groupBy('proveedor.id_proveedor', 'proveedor.nombre', 'proveedor.producto')
                ->orderByDesc('ultima_fecha')
                ->paginate(15);
            $isGrouped = true;
        }
        
        $proveedores = Proveedor::where('id_empresa', $id_empresa)->get();

        return view('admin.proveedores.entradas_dashboard', compact(
            'totalEntradasMes', 
            'porcentajeCrecimiento', 
            'proveedorMasActivo', 
            'valorTotalRecibido', 
            'promedioPorEntrada',
            'entradas',
            'proveedores',
            'isGrouped'
        ));
    }

    public function exportarEntradas(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        
        $selectedProviderId = $request->input('proveedor');

        $query = EntradaInsumo::with(['proveedor', 'insumo', 'semilla'])
            ->where('id_empresa', $id_empresa);

        if ($selectedProviderId) {
            $query->where('id_proveedor', $selectedProviderId);
            $entradas = $query->orderBy('fecha_entrada', 'desc')->get();
            $isGrouped = false;
        } else {
            $entradas = DB::table('entrada_insumo')
                ->join('proveedor', 'entrada_insumo.id_proveedor', '=', 'proveedor.id_proveedor')
                ->select(
                    'proveedor.id_proveedor',
                    'proveedor.nombre',
                    'proveedor.producto as especialidad',
                    DB::raw('count(*) as total_registros'),
                    DB::raw('sum(cantidad_recibida * precio_unitario) as valor_total'),
                    DB::raw('max(fecha_entrada) as ultima_fecha')
                )
                ->where('entrada_insumo.id_empresa', $id_empresa)
                ->groupBy('proveedor.id_proveedor', 'proveedor.nombre', 'proveedor.producto')
                ->orderByDesc('ultima_fecha')
                ->get();
            $isGrouped = true;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.proveedores.pdf_entradas', compact('entradas', 'isGrouped'));
        return $pdf->download('reporte_entradas_proveedores.pdf');
    }

    public function destroy($id)
    {
        $id_empresa = $this->getEmpresaId();
        $proveedor = Proveedor::where('id_proveedor', $id)->where('id_empresa', $id_empresa)->firstOrFail();

        // Verificar si tiene registros asociados en entrada_insumo
        $registrosAsociados = $proveedor->entradas()->count();
        if ($registrosAsociados > 0) {
            return redirect()->route('admin.proveedores.index')->with('error', "No se puede eliminar el proveedor. Tiene $registrosAsociados registro(s) de entrada de inventario asociados (historial).");
        }

        try {
            $proveedor->delete();
            return redirect()->route('admin.proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.proveedores.index')->with('error', 'No se pudo eliminar el proveedor debido a un error de base de datos.');
        }
    }
}
