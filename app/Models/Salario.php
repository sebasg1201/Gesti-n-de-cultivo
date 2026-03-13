<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salario extends Model
{
    use HasFactory;

    protected $table = 'salario';
    protected $primaryKey = 'id_salario';
    public $timestamps = false;

    protected $fillable = [
        'documento_trabajador',
        'descripcion_pago',
        'cantidad_pago',
        'unidad_pago',
        'fecha_pago',
        'estado',
        'id_tipo_salario'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }

    public function tipoSalario()
    {
        return $this->belongsTo(TipoSalario::class, 'id_tipo_salario', 'id_tipo_salario');
    }
}
