<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $usuario = auth()->guard('usuario')->user();
        $id_empresa = $usuario->id_empresa;

        $stats = [
            'cosechas' => \App\Models\TipoCosecha::count(),
            'riegos'   => \App\Models\TipoRiego::count(),
            'semillas' => \App\Models\TipoSemilla::count(),
            'usuarios' => \App\Models\Usuario::where('id_empresa', $id_empresa)->count(),
        ];

        // Trabajos agrupados por estado
        $stats['trabajos_pendientes'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('estado', 'Pendiente')->count();

        $stats['trabajos_en_proceso'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('estado', 'En Proceso')->count();

        $stats['trabajos_realizados'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('estado', 'Realizado')->count();

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
        \App\Models\FaseProgramada::where('documento', $usuario->documento)
            ->where('estado', 'Pendiente')
            ->update(['estado' => 'En Progreso']);

        // Obtener tareas ordenadas por fecha
        $tareas = \App\Models\FaseProgramada::with(['cosecha.tipoCosecha.semilla'])
            ->where('documento', $usuario->documento)
            ->orderBy('fecha_programada', 'asc')
            ->get();

        return view('admin.trabajador_dashboard', compact('tareas'));
    }

    public function finalizarTarea($id)
    {
        $usuario = auth()->guard('usuario')->user();
        
        $tarea = \App\Models\FaseProgramada::where('id_fase', $id)
            ->where('documento', $usuario->documento)
            ->firstOrFail();
            
        $tarea->update(['estado' => 'Realizado']);

        return redirect()->route('trabajador.dashboard')->with('success', 'Tarea marcada como finalizada correctamente.');
    }
}
