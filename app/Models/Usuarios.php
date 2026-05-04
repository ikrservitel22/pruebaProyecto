<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
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
     * Obtener los roles asociados con el usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    // 👇 "mi ID es usuario_id"
    public function getJWTIdentifier()
    {
        return $this->getKey(); // retorna el valor de usuario_id
    }

    // 👇 no necesitas datos extra en el token por ahora
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(
            roles::class,
            'rol_usu',
            'usuario_id',
            'rol_id'
        );
    }

    /**
     * Obtener las relaciones usuario-rol.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'usuario_id', 'usuario_id');
    }

    /**
     * Obtener todos los permisos del usuario a través de sus roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public function permisosDeRol()
    {
        return $this->roles->flatMap->permisos->unique('permiso_id');
    }

    /**
     * Determina si el usuario tiene un rol por nombre.
     *
     * @param string $nombreRol
     * @return bool
     */
    public function hasRole(string $nombreRol): bool
    {
        $nombreRol = strtolower($nombreRol);
        return $this->roles->contains(function ($rol) use ($nombreRol) {
            return strtolower($rol->rol) === $nombreRol;
        });
    }

    /**
     * Determina si el usuario tiene un permiso por nombre a través de sus roles.
     *
     * @param string $nombrePermiso
     * @return bool
     */
    public function hasPermission(string $nombrePermiso): bool
    {
        $nombrePermiso = strtolower($nombrePermiso);
        return $this->permisosDeRol()->contains(function ($permiso) use ($nombrePermiso) {
            return strtolower($permiso->permisos) === $nombrePermiso;
        });
    }

    /**
     * Determina si el usuario puede acceder a una funcionalidad basada en permisos.
     * Los administradores tienen acceso a todo por defecto.
     *
     * @param string $nombrePermiso
     * @return bool
     */
    public function canAccess(string $nombrePermiso): bool
    {
        return $this->hasRole('admin') || $this->hasPermission($nombrePermiso);
    }

    public function getAuthPassword()
    {
        return $this->clave;
    }
}