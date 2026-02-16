<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\VentaLicencias;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // --- 1. License Stats (from DashboardController) ---

        // Licencias Por Vencer
        $licenciasPorVencer = DB::table('venta_licencias as vl')
            ->join('tipo_licencia as tl', 'vl.id_tipo_licencia', '=', 'tl.id_tipo_licencia')
            ->where('vl.id_estado', 1) // Active
            ->get()
            ->filter(function ($licencia) {
                $meses = (int) filter_var($licencia->tiempo, FILTER_SANITIZE_NUMBER_INT);
                if ($meses == 0) $meses = 12;
                $fechaFin = Carbon::parse($licencia->fecha_inicio)->addMonths($meses);
                return $fechaFin->diffInDays(now()) <= 30 && $fechaFin->isFuture();
            })
            ->count();

        // Renovadas este mes
        $renovadasEsteMes = VentaLicencias::whereMonth('fecha_inicio', Carbon::now()->month)
            ->whereYear('fecha_inicio', Carbon::now()->year)
            ->count();

        // Total Licencias
        $totalLicencias = DB::table('venta_licencias')->count();

        // --- 2. Company Stats (from EmpresaController) ---

        // Count by status
        $empresasNuevas = Empresa::where('id_estado', 1)->count(); // Pendiente
        $empresasSuspendidas = Empresa::where('id_estado', 2)->count(); // Bloqueada/Suspendida
        $empresasActivas = Empresa::where('id_estado', 3)->count(); // Activa
        $totalEmpresas = Empresa::count();


        // --- 3. Chart Data (Example: Licenses per Month for current year) ---
        // --- 3. Chart Data (Example: Licenses per Month for current year) ---
        $ventasPorMes = VentaLicencias::select(
            DB::raw('count(id_key) as total'),
            DB::raw("DATE_FORMAT(fecha_inicio, '%m') as month") // MySQL syntax
        )
            ->whereYear('fecha_inicio', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $chartData[] = $ventasPorMes[$month] ?? 0;
        }

        // --- 4. Chart Data: Company Status Distribution ---
        $statusDistribution = [$empresasNuevas, $empresasSuspendidas, $empresasActivas];

        return view('SuperAdmin.reportes', compact(
            'licenciasPorVencer',
            'renovadasEsteMes',
            'totalLicencias',
            'empresasNuevas',
            'empresasSuspendidas',
            'empresasActivas',
            'totalEmpresas',
            'chartData',
            'statusDistribution'
        ));
    }
}
