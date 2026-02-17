<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCompra extends Model
{
    use HasFactory;

    protected $table = 'solicitud_compra';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'nit_empresa',
        'comprobante_pago',
        'id_super_admin',
        'id_estado',
        'fecha_solicitud',
        'fecha_revision',
        'id_tipo_licencia',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function superAdmin()
    {
        return $this->belongsTo(SuperAdmin::class, 'id_super_admin', 'id_super_admin');
    }

    public function tipoLicencia()
    {
        return $this->belongsTo(TipoLicencia::class, 'id_tipo_licencia', 'id_tipo_licencia');
    }

    // Relación con empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'nit_empresa', 'id_empresa');
    }
}
