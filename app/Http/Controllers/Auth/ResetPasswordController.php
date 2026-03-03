<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'correo' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // al menos una letra minúscula
                'regex:/[A-Z]/',      // al menos una letra mayúscula
                'regex:/[0-9]/',      // al menos un número
                'regex:/[@$!%*#?&]/', // al menos un carácter especial
            ],
        ], [
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una mayúscula, un número y un carácter especial (@$!%*#?&).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = \App\Models\SuperAdmin::where('correo', $request->correo)->first();
        $brokerName = 'superadmins';
        
        if (!$user) {
            $user = \App\Models\Usuario::where('correo', $request->correo)->first();
            $brokerName = 'usuarios';
        }

        if (!$user) {
            return back()->withErrors(['correo' => 'No podemos encontrar un usuario con ese correo electrónico.']);
        }

        // Broker 
        $status = Password::broker($brokerName)->reset(
            $request->only('correo', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Here we define how to update the password
                $this->resetPassword($user, $password);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['correo' => __($status)]);
    }

    /**
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword(Authenticatable $user, $password)
    {
        if ($user instanceof \App\Models\SuperAdmin) {
            $user->password_hash = Hash::make($password);
        } else {
            $user->contrasena = Hash::make($password);
        }
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));
    }
}
