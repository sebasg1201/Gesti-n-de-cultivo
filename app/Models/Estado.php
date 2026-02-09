<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estado';
    protected $primaryKey = 'id_estado';
    public $timestamps = false; // Based on the image, there are no created_at/updated_at in Estado

    protected $fillable = [
        'nombre_estado',
    ];

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'id_estado', 'id_estado');
    }
}
