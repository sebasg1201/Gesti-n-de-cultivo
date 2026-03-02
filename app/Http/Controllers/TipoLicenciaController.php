<?php

namespace App\Http\Controllers;

use App\Models\TipoLicencia;
use App\Models\SolicitudCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoLicenciaController extends Controller
{
    public function index()
    {
        $licencias = TipoLicencia::paginate(3);

        // Calcular cuáles tipos están en uso (solicitudes o asignaciones)
        $idsEnSolicitudes = SolicitudCompra::pluck('id_tipo_licencia')->unique();
        $idsEnAsignaciones = DB::table('venta_licencias')->pluck('id_tipo_licencia')->unique();
        $idsEnUso = $idsEnSolicitudes->merge($idsEnAsignaciones)->unique();

        return view('SuperAdmin.tipo_licencias', compact('licencias', 'idsEnUso'));
    }

    public function create()
    {
        return view('SuperAdmin.create_licencia');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_licencia' => 'required|string|max:100',
            'tiempo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        TipoLicencia::create([
            'nombre_licencia' => $request->nombre_licencia,
            'tiempo' => $request->tiempo,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'id_estado' => 1
        ]);

        return redirect()->route('licencias.index')
            ->with('success', 'Licencia creada correctamente');
    }

    public function edit($id)
    {
        $licencia = TipoLicencia::findOrFail($id);

        $enSolicitudes = SolicitudCompra::where('id_tipo_licencia', $id)->exists();
        $enAsignaciones = DB::table('venta_licencias')->where('id_tipo_licencia', $id)->exists();

        if ($enSolicitudes || $enAsignaciones) {
            return redirect()->route('licencias.index')
                ->with('error', 'No se puede editar el plan "' . $licencia->nombre_licencia . '" porque ya está en uso.');
        }

        return view('SuperAdmin.edit_licencia', compact('licencia'));
    }

    public function update(Request $request, $id)
    {
        $licencia = TipoLicencia::findOrFail($id);

        $enSolicitudes = SolicitudCompra::where('id_tipo_licencia', $id)->exists();
        $enAsignaciones = DB::table('venta_licencias')->where('id_tipo_licencia', $id)->exists();

        if ($enSolicitudes || $enAsignaciones) {
            return redirect()->route('licencias.index')
                ->with('error', 'No se puede editar el plan "' . $licencia->nombre_licencia . '" porque ya está en uso.');
        }

        $request->validate([
            'nombre_licencia' => 'required|string|max:100',
            'tiempo' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        $licencia->update([
            'nombre_licencia' => $request->nombre_licencia,
            'tiempo' => $request->tiempo,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio
        ]);

        return redirect()->route('licencias.index')
            ->with('success', 'Licencia actualizada correctamente');
    }

    public function destroy($id)
    {
        $licencia = TipoLicencia::findOrFail($id);

        // Verificar si hay solicitudes de compra que usen este tipo de licencia
        $enSolicitudes = SolicitudCompra::where('id_tipo_licencia', $id)->exists();

        // Verificar si hay asignaciones de licencia (venta_licencias) que usen este tipo
        $enAsignaciones = DB::table('venta_licencias')->where('id_tipo_licencia', $id)->exists();

        if ($enSolicitudes && $enAsignaciones) {
            return redirect()->route('licencias.index')
                ->with('error', 'No se puede eliminar el plan "' . $licencia->nombre_licencia . '" porque está en uso: tiene solicitudes de compra y licencias asignadas a empresas.');
        }

        if ($enSolicitudes) {
            return redirect()->route('licencias.index')
                ->with('error', 'No se puede eliminar el plan "' . $licencia->nombre_licencia . '" porque hay solicitudes de compra que lo tienen seleccionado.');
        }

        if ($enAsignaciones) {
            return redirect()->route('licencias.index')
                ->with('error', 'No se puede eliminar el plan "' . $licencia->nombre_licencia . '" porque ya ha sido asignado a una o más empresas.');
        }

        $licencia->delete();

        return redirect()->route('licencias.index')
            ->with('success', 'Plan "' . $licencia->nombre_licencia . '" eliminado correctamente.');
    }
}
