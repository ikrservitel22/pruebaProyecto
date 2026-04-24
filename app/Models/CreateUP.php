<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateUP extends Model
{
    protected $table = 'per_usu'; // tabla del sql

    protected $fillable = [        //datos de ingreso 
        'usuario_id',
        'permiso_id'
    ];
    
    public $timestamps = false;
}
