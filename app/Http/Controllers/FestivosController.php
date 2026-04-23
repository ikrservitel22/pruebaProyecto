<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FestivosController extends Controller
{
    public function festivo()
    {
        $festivos = DB::table('festivos')
            ->select('festivo_id', 'dia', 'mes', 'descripcion') // 'festivo_id' sin la S
            ->get();

        return view('Usuarios.festivos', compact('festivos'));
    }

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

}
