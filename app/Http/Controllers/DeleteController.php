<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

/**
 * Controlador para eliminar usuarios.
 *
 * Maneja la eliminación de usuarios del sistema.
 */
class DeleteController extends Controller
{
    /**
     * Elimina un usuario.
     *
     * @param int $id ID del usuario a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();

        return redirect('/lista')->with('success', 'Usuario eliminado');
    }
}
