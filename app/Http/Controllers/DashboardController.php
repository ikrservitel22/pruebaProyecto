<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dash()
    {
        // Obtener eventos por día (1=Domingo, 2=Lunes...)
        $eventosPorDia = DB::table('horarios')
            ->selectRaw('DAYOFWEEK(fecha) as dia, COUNT(*) as total')
            ->groupBy('dia')
            ->pluck('total', 'dia');

        //  Orden correcto de días
        $diasOrdenados = [
            2 => 'Lunes',
            3 => 'Martes',
            4 => 'Miércoles',
            5 => 'Jueves',
            6 => 'Viernes',
            7 => 'Sábado',
            1 => 'Domingo'
        ];

        $labels = [];
        $data = [];

        foreach ($diasOrdenados as $numero => $nombre) {
            $labels[] = $nombre;
            $data[] = $eventosPorDia[$numero] ?? 0;
        }

        return view('Usuarios.dashboard', compact('labels', 'data'));
    }
    public function festivo()
    {
        $festivos = DB::table('festivos')
            ->select('dia', 'mes', 'descripcion')
            ->get();
        return view('Usuarios.festivos', compact('festivos'));
    }

    public function update(Request $request)
    {
        DB::table('festivos')
            ->where('id', $request->id) 
            ->update([
                'dia' => $request->dia,
                'mes' => $request->mes,
                'descripcion' => $request->descripcion,
            ]);

        return redirect('/Festivos')->with('success', 'Evento actualizado');
    }
}