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
        'id_fase',
        'id_riego',
        'id_cultivo',
        'documento_trabajador',
        'fecha_trabajada',
        'foto_evidencia',
        'id_estado',
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

    public function fase()
    {
        return $this->belongsTo(FaseProgramada::class, 'id_fase', 'id_fase');
    }

    public function riego()
    {
        return $this->belongsTo(Riego::class, 'id_riego', 'id_riego');
    }

    public function cultivo()
    {
        return $this->belongsTo(Cultivo::class, 'id_cultivo', 'id_cultivo');
    }
}
