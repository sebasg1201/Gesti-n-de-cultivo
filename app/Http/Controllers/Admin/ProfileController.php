<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the profile settings page.
     */
    public function index()
    {
        $usuario = auth()->guard('usuario')->user();
        return view('admin.configuracion.index', compact('usuario'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $usuario = auth()->guard('usuario')->user();
        $id = $usuario->documento;

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuario,correo,' . $id . ',documento',
            'telefono' => 'required|string|max:15',
            'contrasena' => 'nullable|string|min:6|confirmed',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = [
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
            ];

            if ($request->filled('contrasena')) {
                // Ensure we use the correct column name from the model: 'contrasena'
                $data['contrasena'] = Hash::make($request->contrasena);
            }

            if ($request->hasFile('imagen')) {
                // Delete old image if exists
                if ($usuario->imagen && Storage::disk('public')->exists($usuario->imagen)) {
                    Storage::disk('public')->delete($usuario->imagen);
                }
                
                $path = $request->file('imagen')->store('perfiles', 'public');
                $data['imagen'] = $path;
            }

            // Update using current model instance for better handling
            Usuario::where('documento', $id)->update($data);

            return redirect()->back()->with('success', '¡Perfil actualizado correctamente!');
        } catch (\Exception $e) {
            Log::error("Error actualizando perfil: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar los datos: ' . $e->getMessage());
        }
    }
}
