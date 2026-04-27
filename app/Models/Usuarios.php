<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for user management.
 *
 * Represents users in the 'registro' table.
 */
class Usuarios extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registro'; // tabla del sql

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'usuario_id';

    /**
     * The attributes that are mass assignable.
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
     * Get the permissions associated with the user.
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
}