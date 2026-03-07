<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UsuarioLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.usuario-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'correo' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('usuario')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Check if user is active
            if (Auth::guard('usuario')->user()->id_estado != 3) { // Assuming 3 is active like SuperAdmin
                Auth::guard('usuario')->logout();
                throw ValidationException::withMessages([
                    'email' => __('Tu cuenta está inactiva.'),
                ]);
            }

            if (Auth::guard('usuario')->user()->id_tipo_usuario == 3) {
                return redirect()->route('trabajador.dashboard');
            }

            return redirect()->route('admin.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('usuario')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
