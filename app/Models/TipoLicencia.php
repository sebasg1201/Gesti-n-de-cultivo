<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoLicencia extends Model
{
    protected $table = 'tipo_licencia';
    protected $primaryKey = 'id_tipo_licencia';

    public $timestamps = false;

    protected $fillable = [
        'nombre_licencia',
        'tiempo',
        'descripcion',
        'precio',
        'id_estado'
    ];
}
