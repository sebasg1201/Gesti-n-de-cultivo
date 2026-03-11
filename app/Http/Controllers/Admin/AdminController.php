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

        // Si es supervisor (2) o trabajador (3), redirigir a su propio dashboard
        if (in_array($usuario->id_tipo_usuario, [2, 3])) {
            return redirect()->route('trabajador.dashboard');
        }

        $id_empresa = $usuario->id_empresa;

        $stats = [
            'cosechas' => \App\Models\Cosecha::where('id_empresa', $id_empresa)->count(),
            'riegos'   => \App\Models\TipoRiego::count(),
            'semillas' => \App\Models\TipoSemilla::where('id_empresa', $id_empresa)->count(),
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

        // Si no es ni supervisor ni trabajador, redirigir al dashboard de admin
        if (!in_array($usuario->id_tipo_usuario, [2, 3])) {
            return redirect()->route('admin.dashboard');
        }

        // Obtener tareas ordenadas por fecha
        $tareas = \App\Models\FaseProgramada::with([
                'cosecha.tipoCosecha.semilla',
                'cosecha.terreno.tipoSuelo',
                'cosecha.semilla'
            ])
            ->where('documento', $usuario->documento)
            ->orderBy('fecha_programada', 'asc')
            ->get();

        return view('trabajadores.trabajador_dashboard', compact('tareas'));
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

    public function actualizarEstadoTarea(Request $request, $id)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            'estado' => 'required|string|in:Pendiente,En Proceso,Realizado'
        ]);

        $tarea = \App\Models\FaseProgramada::where('id_fase', $id)
            ->where('documento', $usuario->documento)
            ->firstOrFail();

        $tarea->update(['estado' => $request->estado]);

        return redirect()->route('trabajador.dashboard')->with('success', 'Estado de la tarea actualizado correctamente.');
    }
}
