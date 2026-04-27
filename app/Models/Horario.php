<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for schedule management.
 *
 * Represents schedules in the 'horarios' table.
 */
class Horario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'horarios';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'horario_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
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