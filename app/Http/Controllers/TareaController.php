<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {   
        $tareas = Tarea::all();
        return view('Usuarios.principal', compact('tareas')); //muestra la vista login
    }

    public function create(Request $request)
    {
        $user = Tarea::where('usuario', $request->usuario) // flitra si ya hay usuarios con el mismo usuario
                            ->first();

            if ($user) {
                return redirect('/create')->with('error_2', 'usuario existente'); // mensaje error

            } else {
                Tarea::create([ // grada los datos

                    'nombre' => $request->nombre,
                    'usuario' => $request->usuario,
                    'clave' => $request->clave
                ]);
            }
        return redirect('/login')->with('success', 'usuario creado');
    }

    public function login(Request $request) // flitra si el usuario y contraseña coinciden
    {   
        $user = Tarea::where('usuario', $request->usuario)
                    ->where('clave', $request->clave)
                    ->first();
        if ($user) {
            session([
                'usuario' => $user->usuario, //guardo el usuario 
                'id' => $user->usuario_id
            ]);
            return redirect('/')->with('success', 'Sesión iniciada correctamente'); // sí existe
        } else {
            return redirect('/login')->with('error', 'Usuario o clave incorrectos'); // da error
        }   
    }

    public function lista()
    {
        $tareas = Tarea::all(); // trae datos de la BD
        return view('Usuarios.lista', compact('tareas'));
    }

    public function inputtt()
    {
        $tareas = Tarea::all();
        return view('Usuarios.inputtt', compact('tareas')); 
    }

}