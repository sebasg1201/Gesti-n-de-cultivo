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
        'estado',
        'id_cosecha',
        'documento'
    ];

    public function cosecha()
    {
        return $this->belongsTo(TipoCosecha::class, 'id_cosecha', 'id_tipo_cosecha');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'documento', 'documento');
    }
}
