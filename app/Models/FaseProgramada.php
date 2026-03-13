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
        'id_cosecha',
        'documento_trabajador'
    ];

    public function cosecha()
    {
        return $this->belongsTo(Cosecha::class, 'id_cosecha', 'id_cosecha');
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
