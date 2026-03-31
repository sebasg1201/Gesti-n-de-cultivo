<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginTwoFactorCode;

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
            $user = Auth::guard('usuario')->user();

            // Check if user is active
            if ($user->id_estado != 3) { // 3 = Activa
                Auth::guard('usuario')->logout();
                throw ValidationException::withMessages([
                    'email' => __('Tu cuenta está inactiva.'),
                ]);
            }

            // 2FA Flow for Administrators (not in [2,3])
            if (!in_array($user->id_tipo_usuario, [2, 3])) {
                $code = rand(100000, 999999);
                Cache::put('2fa_code_' . $user->documento, $code, now()->addMinutes(10));

                try {
                    Mail::to($user->correo)->send(new LoginTwoFactorCode($code));
                    
                    // Temporary session state
                    session(['2fa_user_id' => $user->documento, '2fa_remember' => $request->has('remember')]);
                    
                    // Logout immediately so they are NOT authenticated yet
                    Auth::guard('usuario')->logout();
                    
                    return redirect()->route('login.verify');
                } catch (\Exception $e) {
                    Auth::guard('usuario')->logout();
                    return back()->withErrors(['email' => 'Error al enviar el código de seguridad.']);
                }
            }

            $request->session()->regenerate();

            if (in_array($user->id_tipo_usuario, [2, 3])) {
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
