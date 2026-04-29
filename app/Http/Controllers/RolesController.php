<?php

namespace App\Http\Controllers;

use App\Models\roles; // Asegúrate de que tu modelo se llame así
use App\Models\Permisos;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    // Mostrar vista principal
    public function index()
    {
        // Traemos los roles con sus permisos cargados (Eager Loading)
        $roles = roles::with('permisos')->get();
        $permisos = Permisos::all();

        return view('CRUD.Roles', compact('roles', 'permisos'));
    }

    // Crear rol
    public function createRol(Request $request)
    {
        $request->validate([
            'rol' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255', // Nuevo campo
            'permisos' => 'array'
        ]);

        if (roles::where('rol', $request->rol)->exists()) {
            return redirect()->back()->with('error', 'El rol ya existe');
        }

        $nuevoRol = roles::create([
            'rol' => $request->rol,
            'descripcion' => $request->descripcion, // Guardamos descripción
        ]);

        if ($request->has('permisos')) {
            $nuevoRol->permisos()->sync($request->permisos);
        }

        return redirect()->back()->with('success', 'Rol creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $rol = roles::findOrFail($id);

        $rol->update([
            'rol' => $request->rol,
            'descripcion' => $request->descripcion // Actualizamos descripción
        ]);

        $rol->permisos()->sync($request->permisos ?? []);

        return response()->json(['success' => true]);
    }
}