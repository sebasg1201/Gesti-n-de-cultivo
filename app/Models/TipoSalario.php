<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSalario extends Model
{
    use HasFactory;

    protected $table = 'tipo_salario';
    protected $primaryKey = 'id_tipo_salario';
    public $timestamps = false;

    protected $fillable = [
        'tipo_salario'
    ];

    public function salarios()
    {
        return $this->hasMany(Salario::class, 'id_tipo_salario', 'id_tipo_salario');
    }
}
