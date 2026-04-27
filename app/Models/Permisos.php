<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permisos extends Model
{
    protected $table = 'permisos'; // tabla del sql
    protected $primaryKey = 'permiso_id';
    protected $fillable = [        //datos de ingreso 
        'permisos'
    ];
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuarios::class,
            'per_usu',
            'permiso_id',
            'usuario_id'
        );
    }
}
