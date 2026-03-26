<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaseProgramada extends Model
{
    use HasFactory;

    protected $table = 'fases_programadas';
    protected $primaryKey = 'id_fase';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'fecha_programada',
        'id_estado',
        'id_terreno',
        'documento_trabajador'
    ];

    public function terreno()
    {
        return $this->belongsTo(Terreno::class, 'id_terreno', 'id_terreno');
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
