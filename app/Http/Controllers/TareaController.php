<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::all();
        return view('tareas', compact('tareas'));
    }

    public function store(Request $request)
    {
        Tarea::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'clave' => $request->clave
        ]);

        return redirect('/');
    }
}