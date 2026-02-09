<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SuperAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'super_admin';
    protected $primaryKey = 'id_super_admin';

    protected $fillable = [
        'nombre',
        'usuario',
        'correo',
        'password_hash',
        'activo',
        'ultimo_login',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    // Check if we need to map 'password' attribute to 'password_hash' for Laravel to interact with it seamlessly
    // But usually getAuthPassword() is enough for login. 
    // If we want to reset password, we might need a mutator.
}
