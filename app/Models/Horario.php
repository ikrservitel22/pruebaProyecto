<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la gestión de horarios.
 *
 * Representa los horarios en la tabla 'horarios'.
 */
class Horario extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'horarios';

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'horario_id';

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
        'usuario_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'descripcion'
    ];
}