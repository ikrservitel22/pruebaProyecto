<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermisosController extends Controller
{
    public function index()
    {
        $tareas = Tarea::all();
        return view('Usuarios.lista', compact('tareas'));
    }
}
