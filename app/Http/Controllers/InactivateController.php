<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Controlador para inactivar usuarios.
 *
 * Maneja la eliminación suave (soft delete) de usuarios cambiando su estado.
 */
class InactivateController extends Controller
{
    /**
     * Inactiva un usuario (eliminación suave).
     *
     * Cambia el estado del usuario a 0 en lugar de eliminarlo físicamente.
     *
     * @param int $id ID del usuario a inactivar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Softdelete($id)
    {
        DB::table('registro')
            ->where('usuario_id', $id)
            ->update([
                'state' => 0
            ]);

        return redirect('/lista')->with('success', 'Usuario eliminado');
    }
}
