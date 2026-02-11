<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> ceface9825d6c91e5c11f8390b8116f462d8ff87
use Illuminate\Database\Eloquent\Model;

class TipoLicencia extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $table = 'tipo_licencia';
    protected $primaryKey = 'id_tipo_licencia';
    public $timestamps = false; // Check if table has timestamps, sql says no
=======
    protected $table = 'tipo_licencia';
    protected $primaryKey = 'id_tipo_licencia';

    public $timestamps = false;
>>>>>>> ceface9825d6c91e5c11f8390b8116f462d8ff87

    protected $fillable = [
        'nombre_licencia',
        'tiempo',
        'descripcion',
        'precio',
        'id_estado'
    ];
<<<<<<< HEAD
}
=======
}
>>>>>>> ceface9825d6c91e5c11f8390b8116f462d8ff87
