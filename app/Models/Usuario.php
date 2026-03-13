<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Usuario extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $table = 'usuario';
    protected $primaryKey = 'documento';
    public $incrementing = false; 
    public $timestamps = false;

    protected $fillable = [
        'documento',
        'imagen',
        'nombre',
        'telefono',
        'correo',
        'contrasena',
        'id_tipo_usuario',
        'id_estado',
        'id_empresa',
        'id_estado_trabajador'
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo_usuario', 'id_tipo_usuario');
    }

    public function estadoTrabajador()
    {
        return $this->belongsTo(EstadoTrabajador::class, 'id_estado_trabajador', 'id_estado_trabajador');
    }
}
