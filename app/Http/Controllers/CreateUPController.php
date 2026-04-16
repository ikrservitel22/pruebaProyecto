<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreateUP;
use App\Models\Usuarios;

class CreateUPController extends Controller
{
    public function CreateUP(Request $request)
    {
        $user = Usuarios::where('usuario', $request->usuario) // flitra si ya hay usuarios con el mismo usuario
                            ->first();
        if ($user) {
            return redirect('/CreateUP')->with('error_2', 'usuario existente'); // mensaje error
        } else {
            // Guardar usuario
            $usuario = Usuarios::create([
                'nombre' => $request->nombre,
                'usuario' => $request->usuario,
                'clave' => $request->clave
            ]);

            CreateUP::create([ // grada los datos
                'permiso_id' => $request->permiso,
                'usuario_id' => $usuario->id,
            ]);
        }
        return redirect('/CreateUP')->with('success', 'usuario creado');
    }
}
