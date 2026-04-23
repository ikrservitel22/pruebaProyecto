<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Models\CreateUP;
use App\Models\Perusu;

class UsuariosController extends Controller
{
    public function index()
    {   
        $Usuarios = Usuarios::all();
        return view('Usuarios.principal', compact('Usuarios')); //muestra la vista login
    }

    public function create(Request $request)
    {
        $user = Usuarios::where('usuario', $request->usuario) // flitra si ya hay usuarios con el mismo usuario
                            ->first();

            if ($user) {
                return redirect('/create')->with('error_2', 'usuario existente'); // mensaje error

            } else {
                $usuario = Usuarios::create([ // grada los datos

                    'nombre' => $request->nombre,
                    'usuario' => $request->usuario,
                    'clave' => $request->clave,
                    'state' => true,
                    'permiso_id' => '2',
                    'cedula' => $request->cedula
                ]);
                Perusu::create([
                    'usuario_id' => $usuario->usuario_id, // importante
                    'permiso_id' => 2
                ]);
            }
        return redirect('/login')->with('success', 'usuario creado');
    }

    public function login(Request $request) // flitra si el usuario y contraseña coinciden
    {   
        $user = Usuarios::where('usuario', $request->usuario)
                    ->where('clave', $request->clave)
                    ->first();
        if ($user) {
                    // BUSCAR PERMISO EN TABLA INTERMEDIA
            $permiso = CreateUP::where('usuario_id', $user->usuario_id)
                                ->value('permiso_id');
            session([
                'usuario' => $user->usuario, //guardo el usuario 
                'id' => $user->usuario_id,
                'permiso_id' => $permiso
            ]);
            
            return redirect('/')->with('success', 'Sesión iniciada correctamente'); // sí existe
        } else {
            return redirect('/login')->with('error', 'Usuario o clave incorrectos'); // da error
        }   
    }

    public function lista()
    {
        $Usuarios = Usuarios::all(); // trae datos de la BD
        return view('Usuarios.lista', compact('Usuarios'));
    }

    public function inputtt()
    {
        $Usuarios = Usuarios::all();
        return view('Usuarios.inputtt', compact('Usuarios')); 
    }
}