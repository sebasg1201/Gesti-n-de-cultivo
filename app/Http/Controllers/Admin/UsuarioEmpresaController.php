<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\TipoUsuario;
use App\Models\Cosecha;
use App\Models\FaseProgramada;
use App\Models\TipoCosecha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioEmpresaController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('usuario')->user();

        // Obtener usuarios de la misma empresa que sean Supervisor (2) o Trabajador (3)
        $usuarios = Usuario::where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->paginate(10);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Solo permitir crear Supervisor (2) y Trabajador (3)
        $roles = TipoUsuario::whereIn('id_tipo_usuario', [2, 3])->get();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('usuario')->user();

        $request->validate([
            'documento' => 'required|numeric|digits_between:8,12|unique:usuario,documento',
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|numeric|digits_between:10,15',
            'contrasena' => 'required|string|min:8',
            'id_tipo_usuario' => 'required|in:2,3',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('usuarios', 'public');
        }

        Usuario::create([
            'documento' => $request->documento,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'contrasena' => Hash::make($request->contrasena),
            'id_tipo_usuario' => $request->id_tipo_usuario,
            'id_empresa' => $admin->id_empresa,
            'id_estado' => 1, // Activo por defecto
            'imagen' => $imagePath
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        $roles = TipoUsuario::whereIn('id_tipo_usuario', [2, 3])->get();
        $estados = \App\Models\Estado::whereIn('id_estado', [1, 3, 10])->get(); // Pendiente, Activa, Suspendido

        return view('admin.usuarios.edit', compact('usuario', 'roles', 'estados'));
    }

    public function update(Request $request, $documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:150',
            'correo' => 'required|email|unique:usuario,correo,' . $usuario->documento . ',documento',
            'telefono' => 'required|numeric|digits_between:10,15',
            'id_tipo_usuario' => 'required|in:2,3',
            'id_estado' => 'required|exists:estado,id_estado',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['nombre', 'correo', 'telefono', 'id_tipo_usuario', 'id_estado']);

        if ($request->filled('contrasena')) {
            $request->validate(['contrasena' => 'string|min:8']);
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        if ($request->hasFile('imagen')) {
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('usuarios', 'public');
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        \Illuminate\Support\Facades\DB::transaction(function () use ($usuario) {
            // Eliminar registros relacionados para evitar errores de clave foránea
            \App\Models\FaseProgramada::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\Salario::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\Riego::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\InsumoCosecha::where('documento_trabajador', $usuario->documento)->delete();
            \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)->delete();

            // Eliminar imagen si existe
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }

            // Eliminar al usuario
            $usuario->delete();
        });

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario y sus tareas asociadas eliminados correctamente.');
    }

    public function asignarTrabajo($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        // Tipos de salario disponibles
        $tiposSalario = \App\Models\TipoSalario::all();

        // Pagos/Salarios registrados para este usuario
        $salarios = \App\Models\Salario::where('documento_trabajador', $documento)
            ->with('tipoSalario')
            ->get();

        return view('admin.usuarios.asignar_trabajo', compact('usuario', 'tiposSalario', 'salarios'));
    }

    public function storeTrabajo(Request $request, $documento)
    {
        $admin = Auth::guard('usuario')->user();

        // Verificar que el usuario pertenece a la empresa
        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'descripcion_pago' => 'nullable|string|max:255',
            'cantidad_pago' => 'required|numeric|min:0',
            'unidad_pago' => 'nullable|string|max:50',
            'id_tipo_salario' => 'nullable|exists:tipo_salario,id_tipo_salario',
        ]);

        \App\Models\Salario::create([
            'documento_trabajador' => $usuario->documento,
            'descripcion_pago' => $request->descripcion_pago,
            'cantidad_pago' => $request->cantidad_pago,
            'unidad_pago' => $request->unidad_pago,
            'fecha_pago' => now(),
            'estado' => 'activo',
            'id_tipo_salario' => $request->id_tipo_salario
        ]);

        return redirect()->route('admin.usuarios.asignar_trabajo', $usuario->documento)
            ->with('success', 'Pago asignado exitosamente al trabajador.');
    }

    public function exportPagos($documento)
    {
        $admin = Auth::guard('usuario')->user();
        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $salarios = \App\Models\Salario::where('documento_trabajador', $documento)
            ->with('tipoSalario')
            ->orderBy('fecha_pago', 'desc')
            ->get();

        $fileName = 'Reporte_Pagos_' . str_replace(' ', '_', $usuario->nombre) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Pago', 'Descripcion', 'Monto', 'Unidad', 'Tipo/Frecuencia', 'Estado', 'Fecha de Pago'];

        $callback = function() use($salarios, $columns) {
            $file = fopen('php://output', 'w');
            // Añadir BOM para que Excel detecte UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';');

            foreach ($salarios as $salario) {
                fputcsv($file, [
                    $salario->id_salario,
                    $salario->descripcion_pago,
                    $salario->cantidad_pago,
                    $salario->unidad_pago,
                    $salario->tipoSalario ? $salario->tipoSalario->tipo_salario : 'General',
                    $salario->estado,
                    $salario->fecha_pago
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
