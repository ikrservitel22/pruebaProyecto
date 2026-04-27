<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\Usuarios;

/**
 * Controlador para crear usuarios con permisos.
 *
 * Maneja la creación de usuarios junto con sus permisos asociados.
 */
class CreateUPController extends Controller
{
    /**
     * Crea un nuevo usuario con permisos.
     *
     * Verifica si el usuario ya existe y, si no, lo crea junto con su permiso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function CreateUP(Request $request)
    {
        $user = Usuarios::where('usuario', $request->usuario) // flitra si ya hay usuarios con el mismo usuario
                            ->first();
        if ($user) {
            return redirect('/CreateUP')->with('error_2', 'usuario existente'); // mensaje error
        } else {
            // Guardar el nuevo usuario en la tabla 'registro'
            $usuario = Usuarios::create([
                'nombre' => $request->nombre,
                'usuario' => $request->usuario,
                'clave' => $request->clave,
                'state' => true,
                'cedula' => $request->cedula,
            ]);

            // Guardar el permiso asociado en la tabla intermedia
            UserPermission::create([
                'permiso_id' => $request->permiso,
                'usuario_id' => $usuario->usuario_id,
            ]);
        }
        return redirect('/CreateUP')->with('success', 'usuario creado');
    }
}
