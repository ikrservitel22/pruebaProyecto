<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controlador para permisos.
 *
 * Actualmente vacío y con errores (referencia a modelo inexistente).
 */
class PermisosController extends Controller
{
    /**
     * Muestra la lista de tareas (ERROR: modelo Tarea no existe).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tareas = Tarea::all();
        return view('Usuarios.lista', compact('tareas'));
    }
}
