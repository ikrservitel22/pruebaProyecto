<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la gestión de días festivos.
 *
 * Representa los días festivos en la tabla 'festivos'.
 */
class Festivos extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'festivos';

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'festivo_id';

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dia',
        'mes',
        'descripcion',
    ];

}
