<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para las relaciones usuario-permiso.
 *
 * Representa las asociaciones usuario-permiso en la tabla 'per_usu'.
 */
class CreateUP extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'per_usu'; // tabla del sql

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario_id',
        'permiso_id'
    ];

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
