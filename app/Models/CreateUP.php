<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for user-permission relationships.
 *
 * Represents user-permission associations in the 'per_usu' table.
 */
class CreateUP extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'per_usu'; // tabla del sql

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario_id',
        'permiso_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
