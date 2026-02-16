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
        return view('auth.passwords.verify');
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

            if (!$user) {
                return back()->with('error', 'Usuario no encontrado.');
            }

            // Generate standard password reset token
            /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
            $broker = Password::broker('superadmins');
            $token = $broker->createToken($user);

            // Clear the code
            Cache::forget($cacheKey);

            // Redirect to the reset form with the token
            return redirect()->route('password.reset', ['token' => $token, 'email' => $email]);
        }

        return back()->with('error', 'El código es incorrecto o ha expirado.');
    }
}
