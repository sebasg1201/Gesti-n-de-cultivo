<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLicencia extends Model
{

    use HasFactory;

    protected $table = 'tipo_licencia';
    protected $primaryKey = 'id_tipo_licencia';
    public $timestamps = false; // Check if table has timestamps, sql says no

    protected $fillable = [
        'nombre_licencia',
        'tiempo',
        'descripcion',
        'precio',
        'id_estado'
    ];
}