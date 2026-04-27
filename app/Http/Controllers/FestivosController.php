<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para la gestión de días festivos.
 *
 * Maneja la visualización, creación, actualización y eliminación de festivos.
 */
class FestivosController extends Controller
{
    /**
     * Muestra la lista de días festivos.
     *
     * @return \Illuminate\View\View
     */
    public function festivo()
    {
        $festivos = DB::table('festivos')
            ->select('festivo_id', 'dia', 'mes', 'descripcion')
            ->get();

        return view('Usuarios.festivos', compact('festivos'));
    }

    /**
     * Actualiza un día festivo existente.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        DB::table('festivos')
            ->where('festivo_id', $request->id) // 'festivo_id' sin la S
            ->update([
                'dia' => $request->dia,
                'mes' => $request->mes,
                'descripcion' => $request->descripcion,
            ]);

        return redirect('/Festivos')->with('success', 'Evento actualizado');
    }

    /**
     * Crea un nuevo día festivo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'descripcion' => 'required|string'
        ]);

        DB::table('festivos')->insert([
            'dia' => $request->dia,
            'mes' => $request->mes,
            'descripcion' => $request->descripcion
        ]);

        return redirect('/Festivos')->with('success', 'Festivo creado correctamente');
    }

    /**
     * Elimina un día festivo.
     *
     * @param int $id ID del festivo a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        DB::table('festivos')->where('festivo_id', $id)->delete();

        return redirect('/Festivos')->with('success', 'Festivo eliminado correctamente');
    }

}
