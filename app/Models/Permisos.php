<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la gestión de permisos.
 *
 * Representa los permisos en la tabla 'permisos'.
 */
class permisos extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'permisos'; // tabla del sql

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'permiso_id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'permisos'
    ];

    /**
     * Obtener los roles asociados con el permiso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            roles::class,
            'per_rol',
            'permiso_id',
            'rol_id'
        );
    }
}
