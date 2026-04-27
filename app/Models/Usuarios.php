<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la gestión de usuarios.
 *
 * Representa a los usuarios en la tabla 'registro'.
 */
class Usuarios extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'registro'; // tabla del sql

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'usuario_id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario',
        'clave',
        'nombre',
        'state',
        'cedula'
    ];

    /**
     * Obtener los permisos asociados con el usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permisos()
    {
        return $this->belongsToMany(
            Permisos::class,
            'per_usu',
            'usuario_id',
            'permiso_id'
        );
    }

    /**
     * Obtener las relaciones usuario-permiso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'usuario_id', 'usuario_id');
    }
}