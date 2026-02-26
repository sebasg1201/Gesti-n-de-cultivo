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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->email;
        if (!$email || !$token) {
            return redirect()->route('password.request')->withErrors(['correo' => 'El enlace de restablecimiento es inválido o faltan datos.']);
        }

        $user = \App\Models\SuperAdmin::where('correo', $email)->first();

        /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
        $broker = \Illuminate\Support\Facades\Password::broker('superadmins');

        if (!$user || !$broker->tokenExists($user, $token)) {
            return redirect()->route('password.request')->withErrors(['correo' => 'El enlace de restablecimiento ya ha sido utilizado, ha expirado, o es inválido. Por favor, solicita uno nuevo.']);
        }

        return response()
            ->view('auth.passwords.reset', ['token' => $token, 'email' => $email])
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
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
                'regex:/[!\"#$%&\'()*+,\-.\/:;<=>?@\[\]^_`{|}~]/', // al menos un carácter especial
            ],
        ], [
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una mayúscula, un número y un carácter especial (@$!%*#?&).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Broker 'superadmins'
        $status = Password::broker('superadmins')->reset(
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
        $user->password_hash = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));
    }
}
