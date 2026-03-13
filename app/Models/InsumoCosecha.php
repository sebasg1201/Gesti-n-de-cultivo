<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumoCosecha extends Model
{
    use HasFactory;

    protected $table = 'insumo_cosecha';
    protected $primaryKey = 'id_insumo_cosecha';
    public $timestamps = false;

    protected $fillable = [
        'id_cosecha',
        'id_insumo',
        'documento_trabajador',
        'id_estado',
        'cantidad_usada',
        'impacto_dias',
        'fecha_programada',
        'fecha_realizacion'
    ];

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class, 'id_cosecha', 'id_cosecha');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo', 'ID_insumo');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'documento_trabajador', 'documento');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
}
