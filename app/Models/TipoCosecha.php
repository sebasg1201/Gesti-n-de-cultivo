<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TipoSemilla;
use App\Models\TipoRiego;


class TipoCosecha extends Model
{
    protected $table = 'tipo_cosecha';

    protected $primaryKey = 'id_tipo_cosecha';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;


    public function semilla()
    {
        return $this->belongsTo(TipoSemilla::class, 'id_semilla');
    }

    public function riego()
    {
        return $this->belongsTo(TipoRiego::class, 'id_tipo_riego');
    }



    protected $fillable = [
        'tiempo',
        'terreno',
        'id_semilla',
        'id_tipo_riego',
        'id_empresa'
    ];
}

