<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusu extends Model
{
    protected $table = 'per_usu'; // tabla del sql
    protected $primaryKey = 'per_usu_id';
    public $timestamps = false;
    protected $fillable = [        //datos de ingreso 
        'usuario_id',
        'permiso_id',
    ];
}
