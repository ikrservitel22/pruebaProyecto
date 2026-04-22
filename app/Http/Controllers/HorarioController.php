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

        $eventosFormateados = $eventos->map(function($e) {
            return [
                'title' => $e->descripcion,
                'start' => $e->fecha . 'T' . $e->hora_inicio,
                'end'   => $e->fecha . 'T' . $e->hora_fin,
            ];
        });

        return view('Usuarios.horario', compact(
            'dias',
            'horas',
            'eventos',
            'usuarios',
            'eventosFormateados'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'descripcion' => 'required',
            'frecuencia' => 'required'
        ]);

        $fechaBase = Carbon::parse($request->fecha);
        $year = $fechaBase->year;
        
        // Generamos el listado completo de festivos para ese año
        $festivosColombia = $this->obtenerFestivosColombia($year);

        if ($request->frecuencia == 'unico') {
            if (!$this->esDiaInvalido($fechaBase, $festivosColombia)) {
                $this->insertarEvento($request, $fechaBase->toDateString());
            } else {
                return redirect('/Horario')->with('error', 'El día seleccionado es festivo o fin de semana');
            }
        } else {
            $inicioMes = $fechaBase->copy()->startOfMonth();
            $finMes = $fechaBase->copy()->endOfMonth();

            for ($date = $inicioMes; $date->lte($finMes); $date->addDay()) {
                $esPar = $date->day % 2 == 0;
                $cumpleFrecuencia = ($request->frecuencia == 'par' && $esPar) || ($request->frecuencia == 'impar' && !$esPar);

                if ($cumpleFrecuencia && !$this->esDiaInvalido($date, $festivosColombia)) {
                    $this->insertarEvento($request, $date->toDateString());
                }
            }
        }

        return redirect('/Horario')->with('success', 'Horarios asignados correctamente');
    }

    /**
     * Determina si el día es fin de semana o está en la lista de festivos calculados
     */
    private function esDiaInvalido($fecha, $festivosColombia)
    {
        // 1. ¿Es fin de semana? (Sábado o Domingo)
        if ($fecha->isWeekend()) {
            return true;
        }

        // 2. ¿Está en la lista de festivos calculados de Colombia (Ley Emiliani/Pascua)?
        if (in_array($fecha->toDateString(), $festivosColombia)) {
            return true;
        }

        // 3. ¿Es un festivo manual de tu tabla 'festivos'? (CORREGIDO)
        // Buscamos directamente en la base de datos para este día específico
        $esFestivoManual = DB::table('festivos')
            ->where('dia', (int)$fecha->day)   // Forzamos a entero para evitar fallos de tipo
            ->where('mes', (int)$fecha->month) // Forzamos a entero
            ->exists(); // Devuelve true si encuentra al menos uno

        if ($esFestivoManual) {
            return true;
        }

        return false;
    }

    /**
     * Calcula TODOS los festivos de Colombia (Fijos, Móviles y Ley Emiliani)
     */
    private function obtenerFestivosColombia($year)
    {
        $festivos = [];

        // 1. Festivos de fecha fija
        $fijos = [
            "$year-01-01", // Año nuevo
            "$year-05-01", // Día del trabajo
            "$year-07-20", // Independencia
            "$year-08-07", // Batalla de Boyacá
            "$year-12-08", // Inmaculada Concepción
            "$year-12-25", // Navidad
        ];
        
        // 2. Festivos Ley Emiliani (Se mueven al siguiente lunes)
        $emiliani = [
            "$year-01-06", // Reyes Magos
            "$year-03-19", // San José
            "$year-06-29", // San Pedro y San Pablo
            "$year-08-15", // Asunción
            "$year-10-12", // Día de la Raza
            "$year-11-01", // Todos los Santos
            "$year-11-11", // Independencia de Cartagena
        ];

        foreach ($fijos as $f) $festivos[] = $f;
        foreach ($emiliani as $f) {
            $date = Carbon::parse($f);
            // Si no es lunes (1), se mueve al lunes siguiente
            if ($date->dayOfWeek !== Carbon::MONDAY) {
                $date->next(Carbon::MONDAY);
            }
            $festivos[] = $date->toDateString();
        }

        // 3. Festivos basados en la Pascua (Butcher)
        $a = $year % 19; $b = floor($year / 100); $c = $year % 100;
        $d = floor($b / 4); $e = $b % 4; $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3); $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4); $k = $c % 4; $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        $pascua = Carbon::create($year, $month, $day);

        // Días exactos de Semana Santa
        $festivos[] = $pascua->copy()->subDays(3)->toDateString(); // Jueves Santo
        $festivos[] = $pascua->copy()->subDays(2)->toDateString(); // Viernes Santo
        
        // Festivos móviles basados en Pascua (también se mueven al lunes)
        $movilesPascua = [
            $pascua->copy()->addDays(43), // Ascensión del Señor
            $pascua->copy()->addDays(64), // Corpus Christi
            $pascua->copy()->addDays(71), // Sagrado Corazón
        ];

        foreach ($movilesPascua as $f) {
            if ($f->dayOfWeek !== Carbon::MONDAY) {
                $f->next(Carbon::MONDAY);
            }
            $festivos[] = $f->toDateString();
        }

        return $festivos;
    }

    private function insertarEvento($request, $fecha)
    {
        DB::table('horarios')->insert([
            'usuario_id' => $request->usuario_id,
            'fecha' => $fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'descripcion' => $request->descripcion,
            'created_at' => now(),
            'updated_at' => now()
        ]);
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