<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use App\Models\SuperAdmin;
use Illuminate\Contracts\Auth\CanResetPassword;



class CodeVerificationController extends Controller
{
    public function show(Request $request)
    {
        $email = session('reset_email') ?? old('email') ?? $request->email;

        if (!$email || !\Illuminate\Support\Facades\Cache::has('password_reset_code_' . $email)) {
            return redirect()->route('password.request')->withErrors(['correo' => 'No hay un código de verificación pendiente o ha expirado. Por favor solicita uno nuevo.']);
        }

        // Reflash flashed session data to persist it across multiple reloads if needed
        session()->reflash();

        return response()
            ->view('auth.passwords.verify', ['email' => $email])
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|size:6',
        ]);

        $email = $request->email;
        $code = $request->code;
        $cacheKey = 'password_reset_code_' . $email;

        if (Cache::has($cacheKey) && Cache::get($cacheKey) == $code) {

            /** @var CanResetPassword $user */
            $user = SuperAdmin::where('correo', $email)->first();
            $brokerName = 'superadmins';

            if (!$user) {
                $user = \App\Models\Usuario::where('correo', $email)->first();
                $brokerName = 'usuarios';
            }

            if (!$user) {
                return back()->with('error', 'Usuario no encontrado.')->with('email', $email);
            }

            // Generate standard password reset token
            /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
            $broker = Password::broker($brokerName);
            $token = $broker->createToken($user);

            // Clear the code and session email
            Cache::forget($cacheKey);
            session()->forget('reset_email');

            // Redirect to the reset form with the token
            return redirect()->route('password.reset', ['token' => $token, 'email' => $email]);
        }

        return back()->with('error', 'El código es incorrecto o ha expirado.')->with('email', $email);
    }
}
