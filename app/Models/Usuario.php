<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

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
        'id_empresa'
    ];
}
