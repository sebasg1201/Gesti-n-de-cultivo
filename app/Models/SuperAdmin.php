<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class SuperAdmin extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = 'super_admin';
    protected $primaryKey = 'id_super_admin';

    protected $fillable = [
        'nombre',
        'usuario',
        'correo',
        'password_hash',
        'id_estado',
        'ultimo_login',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  mixed  $driver
     * @return mixed
     */
    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }
}
