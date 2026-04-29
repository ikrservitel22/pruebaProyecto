<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para las relaciones usuario-rol.
 * 
 * Representa la tabla intermedia 'rol_usu' que asocia usuarios con roles.
 * Este modelo reemplaza CreateUP.php y Rolusu.php.
 */
class UserPermission extends Model
{
    /**
     * La tabla asociada con el modelo.
     * @var string
     */
    protected $table = 'rol_usu';

    /**
     * La clave primaria del modelo.
     * @var string
     */
    protected $primaryKey = 'rol_usu_id';

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
        'rol_id',
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
     * Obtener el rol asociado.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rol()
    {
        return $this->belongsTo(roles::class, 'rol_id', 'rol_id');
    }
}