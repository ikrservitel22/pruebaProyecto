<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para los roles.
 */
class roles extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'rol_id';

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
    protected $fillable = [
        'rol',
        'descripcion',
    ];

    /**
     * Obtener los usuarios asociados con el rol.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuarios::class,
            'rol_usu',
            'rol_id',
            'usuario_id'
        );
    }

    /**
     * Obtener los permisos asociados con el rol.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */


    public function permisos()
    {
        return $this->belongsToMany(
            Permisos::class,
            'per_rol',
            'rol_id',
            'permiso_id'
        );
    }
}
