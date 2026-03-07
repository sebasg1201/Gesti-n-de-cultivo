<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riego extends Model
{
    protected $table = 'riego';
    protected $primaryKey = 'id_riego';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'cant_agua_apl',
        'id_tipo_riego'
    ];

    public function tipoRiego()
    {
        return $this->belongsTo(TipoRiego::class, 'id_tipo_riego', 'id_tipo_riego');
    }
}
