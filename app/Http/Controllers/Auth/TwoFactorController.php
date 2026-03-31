<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginTwoFactorCode;
use App\Models\Usuario;

class TwoFactorController extends Controller
{
    public function showForm()
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('usuario.login');
        }

        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|size:6',
        ]);

        $userId = session('2fa_user_id');
        $user = Usuario::find($userId);

        if (!$user) {
            return redirect()->route('usuario.login')->withErrors(['email' => 'Sesión expirada.']);
        }

        $cacheKey = '2fa_code_' . $user->documento;

        if (Cache::has($cacheKey) && Cache::get($cacheKey) == $request->code) {
            Cache::forget($cacheKey);
            session()->forget(['2fa_user_id', '2fa_remember']);

            Auth::guard('usuario')->login($user, session('2fa_remember', false));
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
    }

    public function resend(Request $request)
    {
        $userId = session('2fa_user_id');
        if (!$userId) {
            return response()->json(['error' => 'Sesión expirada.'], 422);
        }

        $user = Usuario::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 422);
        }

        $code = rand(100000, 999999);
        Cache::put('2fa_code_' . $user->documento, $code, now()->addMinutes(10));

        try {
            Mail::to($user->correo)->send(new LoginTwoFactorCode($code));
            return response()->json(['success' => 'Se ha enviado un nuevo código a su correo.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
        }
    }
}
