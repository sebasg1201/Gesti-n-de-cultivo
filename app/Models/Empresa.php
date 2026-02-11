<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    public $timestamps = false; // The image shows fecha_creacion, but typically Laravel uses created_at. I'll treat it as standard or custom.
    // If fecha_creacion is the only timestamp, we might need to configure it.
    // tailored to the image:
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = null; // Image doesn't show updated_at

    protected $fillable = [
        'nombre_empresa',
        'nombre_repre_legal',
        'telefono',
        'correo',
        'direccion',
        'id_estado',
        'fecha_creacion'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }
}
