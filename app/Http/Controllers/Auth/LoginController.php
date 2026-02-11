<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt using the 'superadmin' guard
        // Note: The database has 'correo' and 'password_hash'. 
        // Laravel's attempt method expects 'password' key in credentials to match against hashed password.
        // We need to map 'email' input to 'correo' column.
        $credentials = [
            'correo' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('superadmin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Check if superadmin is active
            if (!Auth::guard('superadmin')->user()->activo) {
                Auth::guard('superadmin')->logout();
                throw ValidationException::withMessages([
                    'email' => __('Tu cuenta está inactiva.'),
                ]);
            }

            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('superadmin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
