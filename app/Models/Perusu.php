<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for user-permission relationships.
 *
 * Represents user-permission associations in the 'per_usu' table.
 * Note: This model duplicates functionality with CreateUP model.
 */
class Perusu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'per_usu'; // tabla del sql

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'per_usu_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        //datos de ingreso
        'usuario_id',
        'permiso_id',
    ];
}
