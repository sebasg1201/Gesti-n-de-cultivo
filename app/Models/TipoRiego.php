<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRiego extends Model
{
    use HasFactory;

    protected $table = 'tipo_riego';
    protected $primaryKey = 'id_tipo_riego';
    public $timestamps = false;

    protected $fillable = [
        'tipo_riego',
        'id_empresa'
    ];

    public function riegos()
    {
        return $this->hasMany(Riego::class, 'id_tipo_riego', 'id_tipo_riego');
    }

}
