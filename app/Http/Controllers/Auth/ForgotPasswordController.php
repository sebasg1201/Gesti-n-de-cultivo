<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\SuperAdmin;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['correo' => 'required|email']);

        $user = SuperAdmin::where('correo', $request->correo)->first();

        if (!$user) {
            return back()->withErrors(['correo' => 'No podemos encontrar un usuario con ese correo electrónico.']);
        }

        // Generate 6-digit code
        $code = rand(100000, 999999);
        $cacheKey = 'password_reset_code_' . $request->correo;

        // Store in cache for 5 minutes
        Cache::put($cacheKey, $code, 300);

        // Send Email
        try {
            Mail::to($request->correo)->send(new \App\Mail\ResetPasswordCode($code));
        } catch (\Exception $e) {
            return back()->withErrors(['correo' => 'Hubo un error al enviar el correo. Por favor intenta más tarde.']);
        }

        // Store email in session for verify view
        session(['reset_email' => $request->correo]);

        return redirect()->route('password.verify.form')->with([
            'email' => $request->correo,
            'status' => '¡Código enviado! Revisa tu correo electrónico.'
        ]);
    }
}
