<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para las relaciones usuario-rol.
 *
 * Representa las asociaciones usuario-rol en la tabla 'rol_usu'.
 */
class CreateUP extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'rol_usu'; // tabla del sql

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario_id',
        'rol_id'
    ];

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
