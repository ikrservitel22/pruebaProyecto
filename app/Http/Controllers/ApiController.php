<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\Horario;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        // Validar credenciales en la tabla 'registro'
        $usuario = Usuarios::where('usuario', $request->usuario)
                    ->where('clave', $request->clave)
                    ->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario o Contraseña Incorrectos'], 401);
        }

        $token = JWTAuth::fromUser($usuario);
    
        return response()->json([
            'token' => $token,
            'user' => [
                'usuario' => $usuario->usuario
            ]
        ]);
    }
    public function usuariou()
    {
            return response()->json(Usuarios::all());
    }
    public function usuarios($id)
    {
            return response()->json(
                Usuarios::findOrFail($id)
            );
    }
    public function horariou()
    {
        $horarios = Horario::select('fecha', 'hora_inicio', 'hora_fin', 'usuario_id', 'descripcion')->get();

        return response()->json($horarios);
    }
    public function horarios($id)
    {
            return response()->json(
                Horario::findOrFail($id)
            );
    }
    public function festivou()
    {
        $horarios = Festivos::select('fecha', 'hora_inicio', 'hora_fin', 'usuario_id', 'descripcion')->get();

        return response()->json($horarios);
    }
    public function festivos($id)
    {
            return response()->json(
                Festivos::findOrFail($id)
            );
    }
}

