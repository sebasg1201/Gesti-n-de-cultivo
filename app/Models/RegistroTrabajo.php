<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroTrabajo extends Model
{
    use HasFactory;

    protected $table = 'registro_trabajo';
    protected $primaryKey = 'id_registro_trabajo';
    public $timestamps = false; // Based on SQL schema provided which has created_at with default current_timestamp but not updated_at

    protected $fillable = [
        'id_insumo_cosecha',
        'documento_trabajador',
        'fecha_trabajada',
        'foto_evidencia',
        'estado_aprobacion',
        'observacion'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }

    public function insumoCosecha()
    {
        return $this->belongsTo(InsumoCosecha::class, 'id_insumo_cosecha', 'id_insumo_cosecha');
    }
}
