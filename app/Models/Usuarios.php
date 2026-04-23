<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'registro'; // tabla del sql
    protected $primaryKey = 'usuario_id';
    protected $fillable = [        //datos de ingreso 
        'usuario',
        'clave',
        'nombre',
        'state',
        'cedula'
    ];
    public function permisos()
    {
        return $this->belongsToMany(
            Permisos::class,
            'per_usu',
            'usuario_id',
            'permiso_id'
        );
    }
}