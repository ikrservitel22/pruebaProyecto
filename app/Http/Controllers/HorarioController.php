<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para la gestión de horarios.
 *
 * Maneja la creación, edición, eliminación y visualización de horarios,
 * incluyendo la lógica de festivos colombianos y exportación/importación de CSV.
 */
class HorarioController extends Controller
{
    /**
     * Muestra la vista de horarios con el calendario FullCalendar.
     *
     * Obtiene todos los horarios y usuarios, y los formatea para el calendario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function Horario(Request $request)
    {
        // Obtener TODOS los horarios para mostrar en el calendario
        $horarios = DB::table('horarios')
            ->join('registro', 'horarios.usuario_id', '=', 'registro.usuario_id')
            ->select(
                'horarios.*',
                'registro.usuario as usuario_nombre'
            )
            ->get();

        $usuarios = DB::table('registro')->get();

        $horariosFormateados = $horarios->map(function($e) {
            return [
                'id' => $e->horario_id,
                'title' => $e->descripcion . ' (' . $e->usuario_nombre . ')',
                'start' => $e->fecha . 'T' . $e->hora_inicio,
                'end'   => $e->fecha . 'T' . $e->hora_fin,
                'usuario_id' => $e->usuario_id,
                'usuario_nombre' => $e->usuario_nombre,
                'extendedProps' => [
                    'usuario_id' => $e->usuario_id,
                    'usuario_nombre' => $e->usuario_nombre,
                    'descripcion' => $e->descripcion,
                    'horario_id' => $e->horario_id,
                ]
            ];
        });

        // Variables para compatibilidad (si las necesitas en la vista)
        $dias = [];
        $horas = [];

        return view('Usuarios.horario', compact(
            'dias',
            'horas',
            'horarios',
            'usuarios',
            'horariosFormateados'
        ));
    }

    /**
     * Muestra el formulario para crear un nuevo evento de horario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $usuarios = DB::table('registro')->get();

        return view('Usuarios.eventoN', compact('usuarios'));
    }

    /**
     * Almacena un nuevo horario o serie de horarios.
     *
     * Valida los datos y crea horarios únicos o recurrentes, evitando festivos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    public function edit($id)
    {
        $horario = DB::table('horarios')->where('horario_id', $id)->first();
        $usuarios = DB::table('registro')->get();

        return view('Usuarios.editE', compact('horario', 'usuarios'));
    }

    /**
     * Actualiza un horario existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID del horario a actualizar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $horario = DB::table('horarios')->where('horario_id', $id)->first();
            
            if (!$horario) {
                return response()->json(['error' => 'Horario no encontrado'], 404);
            }

            $updateData = [];
            
            // Solo actualizar los campos que se envíen
            if ($request->has('usuario_id')) {
                $updateData['usuario_id'] = $request->usuario_id;
            }
            if ($request->has('fecha')) {
                $updateData['fecha'] = $request->fecha;
            }
            if ($request->has('hora_inicio')) {
                $updateData['hora_inicio'] = $request->hora_inicio;
            }
            if ($request->has('hora_fin')) {
                $updateData['hora_fin'] = $request->hora_fin;
            }
            if ($request->has('descripcion')) {
                $updateData['descripcion'] = $request->descripcion;
            }
            
            if (!empty($updateData)) {
                $updateData['updated_at'] = now();
                DB::table('horarios')
                    ->where('horario_id', $id)
                    ->update($updateData);
            }

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Horario actualizado'], 200);
            }

            return redirect('/Horario')->with('success', 'Horario actualizado');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar horario: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Elimina un horario existente.
     *
     * @param int $id ID del horario a eliminar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $horario = DB::table('horarios')->where('horario_id', $id)->first();
            
            if (!$horario) {
                return response()->json(['error' => 'Horario no encontrado'], 404);
            }

            DB::table('horarios')
                ->where('horario_id', $id)
                ->delete();

            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Horario eliminado'], 200);
            }

            return redirect('/Horario')->with('success', 'Horario eliminado');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar horario: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exporta los horarios a un archivo CSV.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportarCSV(Request $request)
    {
    $mesNumero = $request->mes ?? date('m');

    $anio = $request->anio ?? date('Y');

    $nombreArchivo = "horarios_$mesNumero-$anio.csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$nombreArchivo",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];

    $fecha = \Carbon\Carbon::createFromDate($anio, $mesNumero, 1);

    $mes = $meses[$fecha->format('F')];

    $diasMes = $fecha->daysInMonth;

    $callback = function() use ($mes, $diasMes) {
        $file = fopen('php://output', 'w');

        // Encabezados
        $encabezados = [
            'cedula',
            'horario/día',
            $mes
            ];

        for ($i = 1; $i <= $diasMes; $i++) {
            $encabezados[] = $i;
        }

        

        fputcsv($file, $encabezados);

        // Horarios (filas)
        $horarios = [
            '06:00-16:00',
            '08:00-18:00',
            '10:00-20:00',
            '12:00-22:00'
        ];

        foreach ($horarios as $horarioItem) {
            $fila = [
                ' ',
                $horarioItem
                ];

            for ($i = 1; $i <= $diasMes; $i++) {
                $fila[] = '';
            }

            fputcsv($file, $fila);
        }

        fclose($file);
    };
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Importa horarios desde un archivo CSV.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importarCSV(Request $request)
    {
        $file = $request->file('archivo');

        if (!$file) {
            return back()->with('error', 'No se subió ningún archivo');
        }

        $handle = fopen($file->getRealPath(), 'r');

        // 1. Encabezados
        $header = fgetcsv($handle);

        $mesTexto = ucfirst(strtolower(trim($header[2])));

        $anio = date('Y');

        $meses = [
            'Enero' => '01',
            'Febrero' => '02',
            'Marzo' => '03',
            'Abril' => '04',
            'Mayo' => '05',
            'Junio' => '06',
            'Julio' => '07',
            'Agosto' => '08',
            'Septiembre' => '09',
            'Octubre' => '10',
            'Noviembre' => '11',
            'Diciembre' => '12'
        ];

        $mesNumero = $meses[$mesTexto] ?? date('m');

        // 2. Leer TODAS las filas
        $filas = [];

        while (($row = fgetcsv($handle)) !== false) {
            $filas[] = $row;
        }

        if (count($filas) == 0) {
            return back()->with('error', 'El CSV está vacío');
        }

        // 3. SACAR cedula SOLO de la primera fila
        $cedula = trim($filas[0][0]);

        $usuario = DB::table('registro')
            ->where('cedula', $cedula)
            ->first();


        if (!$usuario) {
            return back()->with('error', 'Debe colocar la cedula en A2');
        }

        $usuario_id = $usuario->usuario_id;
        
        $festivosColombia = $this->obtenerFestivosColombia($anio);

        foreach ($filas as $fila) {

            $horarioTexto = trim($fila[1]);
            if (!$horarioTexto) continue;

            $descripcion = trim($fila[0] ?? '') ?: 'Trabajo';

            if (!str_contains($horarioTexto, '-')) continue;

            [$hora_inicio, $hora_fin] = explode('-', $horarioTexto);

            for ($i = 3; $i < count($fila); $i++) {

                if (strtoupper(trim($fila[$i])) === 'X') {

                    $dia = trim($header[$i]);
                    if (!is_numeric($dia)) continue;

                    $fechaString = $anio . '-' . $mesNumero . '-' . str_pad($dia, 2, '0', STR_PAD_LEFT);
                    $fecha = Carbon::parse($fechaString);

                    // 🔴 VALIDAR FESTIVOS Y DOMINGOS
                    if ($this->esDiaInvalido($fecha, $festivosColombia)) {
                        continue;
                    }

                    DB::table('horarios')->insert([
                        'usuario_id' => $usuario_id,
                        'descripcion' => $descripcion,
                        'fecha' => $fecha->toDateString(),
                        'hora_inicio' => $hora_inicio,
                        'hora_fin' => $hora_fin,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        fclose($handle);

        return back()->with('success', 'Horarios importados correctamente');
    }

}