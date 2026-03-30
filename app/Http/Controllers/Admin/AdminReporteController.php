<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cosecha;
use App\Models\Riego;
use App\Models\InsumoCosecha;
use App\Models\FaseProgramada;
use App\Models\RegistroTrabajo;
use App\Models\Cultivo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReporteController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month);
        $anio = $request->input('anio', Carbon::now()->year);

        // --- 1. Estadísticas de Cosechas en el mes ---
        $cosechasMes = Cosecha::whereMonth('fecha_siembra', $mes)
            ->whereYear('fecha_siembra', $anio)
            ->get();

        $totalCosechas = $cosechasMes->count();
        $cosechasFinalizadas = $cosechasMes->where('id_estado', 14)->count();
        $cosechasEnProgreso = $cosechasMes->where('id_estado', '!=', 14)->count();

        // --- 2. Cumplimiento de Tareas ---
        // Riegos
        $riegos = Riego::whereMonth('fecha_programada', $mes)
            ->whereYear('fecha_programada', $anio)
            ->get();
        $totalRiegos = $riegos->count();
        $riegosCompletados = $riegos->where('id_estado', 15)->count();
        
        // Insumos
        $insumos = InsumoCosecha::whereMonth('fecha_programada', $mes)
            ->whereYear('fecha_programada', $anio)
            ->get();
        $totalInsumos = $insumos->count();
        $insumosCompletados = $insumos->where('id_estado', 15)->count();

        // Fases Generales
        $fases = FaseProgramada::whereMonth('fecha_programada', $mes)
            ->whereYear('fecha_programada', $anio)
            ->get();
        $totalFases = $fases->count();
        $fasesCompletadas = $fases->where('id_estado', 15)->count();

        $totalTareas = $totalRiegos + $totalInsumos + $totalFases;
        $totalCompletadas = $riegosCompletados + $insumosCompletados + $fasesCompletadas;
        $porcentajeCumplimiento = $totalTareas > 0 ? ($totalCompletadas / $totalTareas) * 100 : 0;

        // --- 3. Producción (Recolección) ---
        $recolecciones = Cultivo::whereMonth('fecha_recoleccion', $mes)
            ->whereYear('fecha_recoleccion', $anio)
            ->get();
        
        $totalProduccionKg = DB::table('detalle_producto_cultivo')
            ->join('cultivo', 'detalle_producto_cultivo.id_cultivo', '=', 'cultivo.id_cultivo')
            ->whereMonth('cultivo.fecha_recoleccion', $mes)
            ->whereYear('cultivo.fecha_recoleccion', $anio)
            ->sum('cantidad');

        // --- 4. Datos para Gráficos ---
        // Tareas por día del mes
        $tareasPorDia = DB::table(DB::raw("(SELECT fecha_programada as fecha, id_estado FROM riego 
                                            UNION ALL 
                                            SELECT fecha_programada as fecha, id_estado FROM insumo_cosecha 
                                            UNION ALL 
                                            SELECT fecha_programada as fecha, id_estado FROM fase_programada) as todas_tareas"))
            ->select(DB::raw("DAY(fecha) as dia"), DB::raw("COUNT(*) as total"), DB::raw("SUM(CASE WHEN id_estado = 15 THEN 1 ELSE 0 END) as completas"))
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // --- 5. Tareas Pendientes o Perdidas del Mes ---
        $tareasFaltantes = DB::table(DB::raw("(
            SELECT 'Riego' as tipo, id_riego as id, fecha_programada as fecha, id_estado, id_cosecha FROM riego 
            UNION ALL 
            SELECT 'Insumo' as tipo, id_insumo_cosecha as id, fecha_programada as fecha, id_estado, id_cosecha FROM insumo_cosecha 
            UNION ALL 
            SELECT 'General' as tipo, id_fase as id, fecha_programada as fecha, id_estado, NULL as id_cosecha FROM fase_programada
        ) as t"))
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->whereIn('id_estado', [1, 16, 18]) // Pendiente (1), Perdida (16), Perdida Oculta (18)
            ->orderBy('fecha', 'asc')
            ->get();

        // Enriquecer con información de terreno/cosecha
        foreach ($tareasFaltantes as $tf) {
            if ($tf->id_cosecha) {
                $c = Cosecha::with('terreno', 'semilla')->find($tf->id_cosecha);
                $tf->descripcion = ($c->terreno->nombre ?? 'Lote') . ' (' . ($c->semilla->nombre_semilla ?? 'Cultivo') . ')';
            } else {
                $tf->descripcion = 'Labor General / Mantenimiento';
            }
        }

        return view('admin.reportes.index', compact(
            'mes', 'anio', 
            'totalCosechas', 'cosechasFinalizadas', 'cosechasEnProgreso',
            'totalRiegos', 'riegosCompletados',
            'totalInsumos', 'insumosCompletados',
            'totalFases', 'fasesCompletadas',
            'totalTareas', 'totalCompletadas', 'porcentajeCumplimiento',
            'totalProduccionKg', 'tareasPorDia', 'tareasFaltantes'
        ));
    }
}
