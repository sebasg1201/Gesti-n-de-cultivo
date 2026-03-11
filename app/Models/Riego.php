<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riego extends Model
{
    protected $table = 'riego';
    protected $primaryKey = 'id_riego';
    public $timestamps = false;

    protected $fillable = [
        'cant_agua_apl',
        'observaciones',
        'id_tipo_riego',
        'id_cosecha',
        'documento_trabajador',
        'id_estado',
        'fecha_programada'
    ];

    public function tipoRiego()
    {
        return $this->belongsTo(TipoRiego::class, 'id_tipo_riego', 'id_tipo_riego');
    }

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class, 'id_cosecha', 'id_cosecha');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }
}
