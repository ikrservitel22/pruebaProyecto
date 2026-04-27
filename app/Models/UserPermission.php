<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para las relaciones usuario-permiso.
 * 
 * Representa la tabla intermedia 'per_usu' que asocia usuarios con permisos.
 * Este modelo reemplaza CreateUP.php y Perusu.php.
 */
class UserPermission extends Model
{
    /**
     * La tabla asociada con el modelo.
     * @var string
     */
    protected $table = 'per_usu';

    /**
     * La clave primaria del modelo.
     * @var string
     */
    protected $primaryKey = 'per_usu_id';

    /**
     * Indica si el modelo debe ser timestamped.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'permiso_id',
    ];

    /**
     * Obtener el usuario asociado.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id', 'usuario_id');
    }

    /**
     * Obtener el permiso asociado.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permiso()
    {
        return $this->belongsTo(\App\Models\Permisos::class, 'permiso_id', 'permiso_id');
    }
}