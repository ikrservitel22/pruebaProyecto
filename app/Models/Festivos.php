<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for holiday management.
 *
 * Represents holidays in the 'festivos' table.
 */
class Festivos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'festivos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'festivo_id';

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
        'dia',
        'mes',
        'descripcion',
    ];

}
