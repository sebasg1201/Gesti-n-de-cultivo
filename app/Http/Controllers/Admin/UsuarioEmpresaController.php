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

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
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
            'imagen' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['nombre', 'correo', 'telefono', 'id_tipo_usuario']);

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

        if ($usuario->imagen) {
            Storage::disk('public')->delete($usuario->imagen);
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function asignarTrabajo($documento)
    {
        $admin = Auth::guard('usuario')->user();

        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->whereIn('id_tipo_usuario', [2, 3])
            ->firstOrFail();

        // Obtener solo las cosechas de la empresa del admin
        $cosechas = \App\Models\Cosecha::with(['tipoCosecha.semilla', 'tipoCosecha.riego'])
            ->where('id_empresa', $admin->id_empresa)
            ->get();

        // Fases actualmente asignadas al usuario
        $fases = FaseProgramada::where('documento_trabajador', $documento)->with('cosecha')->get();

        return view('admin.usuarios.asignar_trabajo', compact('usuario', 'cosechas', 'fases'));
    }

    public function storeTrabajo(Request $request, $documento)
    {
        $admin = Auth::guard('usuario')->user();

        // Verificar que el usuario pertenece a la empresa
        $usuario = Usuario::where('documento', $documento)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'id_cosecha' => 'required|exists:cosecha,id_cosecha',
            'descripcion' => 'required|string',
            'fecha_programada' => 'required|date'
        ]);

        FaseProgramada::create([
            'id_cosecha' => $request->id_cosecha,
            'descripcion' => $request->descripcion,
            'id_estado' => 1, // 1 = Pendiente
            'fecha_programada' => $request->fecha_programada,
            'documento_trabajador' => $usuario->documento
        ]);

        return redirect()->route('admin.usuarios.asignar_trabajo', $usuario->documento)
            ->with('success', 'Trabajo asignado exitosamente al usuario.');
    }
}
