<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function Horario(Request $request)
    {
        
        $fecha = $request->fecha // 1. Fecha seleccionada o actual
            ? Carbon::parse($request->fecha) 
            : now();

        $inicioSemana = $fecha->copy()->startOfWeek(); // lunes
        $finSemana = $inicioSemana->copy()->addDays(6); // domingo
        
        $eventos = DB::table('horarios')
            ->join('registro', 'horarios.usuario_id', '=', 'registro.usuario_id')
            ->select(
                'horarios.*',
                'registro.usuario as usuario_nombre'
            )
            ->whereBetween('fecha', [
                $inicioSemana->format('Y-m-d'),
                $finSemana->format('Y-m-d')
            ])
            ->get();

        $usuarios = DB::table('registro')->get();
        // Días
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dia = $inicioSemana->copy()->addDays($i);

            $dias[] = [
                'nombre' => $dia->locale('es')->isoFormat('ddd'), // lun, mar...
                'numero' => $dia->day,
                'fecha' => $dia->toDateString()
            ];
        }
        // Horas (1 a 24)
        $horas = [];
        for ($h = 0; $h <= 24; $h++) {
            $horas[] = $h;
        }

       return view('Usuarios.horario', compact('dias', 'horas', 'eventos', 'usuarios'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'descripcion' => 'required'
        ]);

        DB::table('horarios')->insert([
            'usuario_id' => $request->usuario_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'descripcion' => $request->descripcion,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/Horario');
    }
    public function create()
    {
        $usuarios = DB::table('registro')->get();

        return view('Usuarios.eventoN', compact('usuarios'));
    }
    public function edit($id)
    {
        $evento = DB::table('horarios')->where('horario_id', $id)->first();
        $usuarios = DB::table('registro')->get();

        return view('Usuarios.editE', compact('evento', 'usuarios'));
    }
    public function update(Request $request, $id)
    {
        DB::table('horarios')
            ->where('horario_id', $id)
            ->update([
                'usuario_id' => $request->usuario_id,
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'descripcion' => $request->descripcion,
            ]);

        return redirect('/Horario')->with('success', 'Evento actualizado');
    }
}