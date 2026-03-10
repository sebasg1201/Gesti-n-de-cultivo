<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $usuario = auth()->guard('usuario')->user();
        $id_empresa = $usuario->id_empresa;

        $stats = [
            'cosechas' => \App\Models\Cosecha::where('id_empresa', $id_empresa)->count(),
            'riegos' => \App\Models\TipoRiego::count(),
            'semillas' => \App\Models\TipoSemilla::where('id_empresa', $id_empresa)->count(),
            'usuarios' => \App\Models\Usuario::where('id_empresa', $id_empresa)->count(),
        ];

        // Trabajos agrupados por estado
        $stats['trabajos_pendientes'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 1)->count(); // 1 = Pendiente

        $stats['trabajos_en_proceso'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 8)->count(); // 8 = En Proceso

        $stats['trabajos_realizados'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 9)->count(); // 9 = Realizado

        return view('admin.inicio', compact('stats'));
    }

    public function configuracion()
    {
        return view('admin.configuracion.index');
    }

    public function trabajadorInicio()
    {
        $usuario = auth()->guard('usuario')->user();

        // Cambiar automáticamente estado Pendiente a En Progreso
        \App\Models\FaseProgramada::where('documento_trabajador', $usuario->documento)
            ->where('id_estado', 1) // 1 = Pendiente
            ->update(['id_estado' => 8]); // 8 = En Proceso

        // Obtener tareas ordenadas por fecha
        $tareas = \App\Models\FaseProgramada::with(['cosecha.tipoCosecha.semilla'])
            ->where('documento_trabajador', $usuario->documento)
            ->orderBy('fecha_programada', 'asc')
            ->get();

        return view('admin.trabajador_dashboard', compact('tareas'));
    }

    public function finalizarTarea($id)
    {
        $usuario = auth()->guard('usuario')->user();

        $tarea = \App\Models\FaseProgramada::where('id_fase', $id)
            ->where('documento_trabajador', $usuario->documento)
            ->firstOrFail();

        $tarea->update(['id_estado' => 9]); // 9 = Realizado

        return redirect()->route('trabajador.dashboard')->with('success', 'Tarea marcada como finalizada correctamente.');
    }
}
