<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoTrabajador extends Model
{
    protected $table = 'estado_trabajador';
    protected $primaryKey = 'id_estado_trabajador';
    public $timestamps = false;

    protected $fillable = [
        'nombre_estado'
    ];
}
