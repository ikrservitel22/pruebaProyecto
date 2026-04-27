<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para las relaciones usuario-permiso.
 *
 * Representa las asociaciones usuario-permiso en la tabla 'per_usu'.
 * Nota: Este modelo duplica funcionalidad con el modelo CreateUP.
 */
class Perusu extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'per_usu'; // tabla del sql

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'per_usu_id';

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario_id',
        'permiso_id',
    ];
}
