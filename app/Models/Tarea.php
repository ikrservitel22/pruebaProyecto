<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'registro'; // tabla del sql

    protected $fillable = [        //datos de ingreso 
        'usuario',
        'clave',
        'nombre',
    ];
}