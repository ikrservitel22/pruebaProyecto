<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for permissions management.
 *
 * Represents permissions in the 'permisos' table.
 */
class permisos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permisos'; // tabla del sql

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'permiso_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'permisos'
    ];

    /**
     * Get the users associated with the permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usuarios()
    {
        return $this->belongsToMany(
            Usuarios::class,
            'per_usu',
            'permiso_id',
            'usuario_id'
        );
    }
}
