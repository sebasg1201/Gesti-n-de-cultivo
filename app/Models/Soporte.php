<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soporte';
    protected $primaryKey = 'id_soporte';

    protected $fillable = [
        'documento_trabajador',
        'id_empresa',
        'asunto',
        'mensaje',
        'respuesta',
        'estado'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
}
