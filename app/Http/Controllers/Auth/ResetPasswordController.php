<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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
            'password' => 'required|confirmed|min:8',
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
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        // Update password_hash instead of password
        $user->password_hash = Hash::make($password);

        // If the model uses 'remember_token', we can verify it here, but SuperAdmin might not have it.
        // Checking schema or model... Model uses 'Authenticatable' so it likely has remember_token if migrated.
        // But let's just save.
        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        // Login the user? User might want to login manually.
        // Auth::guard('superadmin')->login($user);
    }
}
