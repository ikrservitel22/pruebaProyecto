<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festivos extends Model
{
    protected $table = 'festivos';

    protected $primaryKey = 'festivo_id';

    public $timestamps = true;

    protected $fillable = [
        'dia',
        'mes',
        'descripcion',
    ];

}
