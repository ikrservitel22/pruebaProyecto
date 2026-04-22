@extends('layouts.app')

@php
    $hideFooter = true;// oculta el footer
@endphp 

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@php
    use Carbon\Carbon;

    // Control de celdas ocupadas por rowspan
    $ocupadas = [];
@endphp

@vite(['resources/js/app.js'])

@section('content')

<form method="GET" class="p-4 border rounded bg-dark">>
    <div class="row">
        <input type="date" class="col-md-5 ms-5 m-2" id="role" name="fecha" value="{{ request('fecha') }}">
        <button class="col-md-2 ms-2 m-2 btn btn-light bg-light" type="submit">Ver semana</button>
        <a class="col-md-3 m-2  btn btn-light bg-light" href="/Evento">Crear Evento</a>
    </div>

<table class="table table-bordered text-center mt-4"
       style="border-collapse: collapse; table-layout: fixed; background-color: #fbfbfb;">
    
    <thead>
        <tr>
            <th style="width: 120px;" class="text-light bg-dark border">Hora</th>
            @foreach($dias as $dia)
                <th class="text-light border bg-dark">
                    {{ $dia['nombre'] }} {{ $dia['numero'] }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($horas as $hora)
            <tr class="bg-perso" style="height: 90px;">
                
                {{-- Columna de horas --}}
                <td class="bg-secondary text-light border" style="vertical-align: middle;">
                    {{ date('g:iA', strtotime($hora . ':00')) }}
                </td>

                @foreach($dias as $dia)

                    @php
                        // Si esta celda ya está ocupada por un rowspan → saltar
                        if(isset($ocupadas[$dia['fecha']][$hora])) {
                            continue;
                        }

                        // Eventos en esta celda
                        $eventosEnEstaHora = $eventos->filter(function($e) use ($dia, $hora) {
                            $fechaEvento = Carbon::parse($e->fecha)->format('Y-m-d');
                            $inicio = (int) Carbon::parse($e->hora_inicio)->format('H');
                            $fin = (int) Carbon::parse($e->hora_fin)->format('H');

                            return $fechaEvento == $dia['fecha']
                                && $hora >= $inicio
                                && $hora < $fin;
                        });
                    @endphp

                    {{-- 🔴 SI HAY MÁS DE UN EVENTO → VISTA COMPACTA --}}
                    @if($eventosEnEstaHora->count() > 1)

                        <td class="text-light border p-1 bg-perso" style="vertical-align: top;">
                            
                            @foreach($eventosEnEstaHora as $evento)
                                <div style="
                                    background: rgb(111, 116, 130);
                                    margin:2px;
                                    padding:3px;
                                    border-radius:4px;
                                    font-size: 0.7rem;
                                ">
                                    <strong>
                                        {{ \Illuminate\Support\Str::limit($evento->descripcion, 12) }}
                                    </strong><br>

                                    <span style="font-size:0.6rem; opacity:0.8;">
                                        {{ Carbon::parse($evento->hora_inicio)->format('g:i') }}
                                    </span>
                                </div>
                            @endforeach

                        </td>

                    {{-- 🟢 UN SOLO EVENTO --}}
                    @elseif($eventosEnEstaHora->count() == 1)

                        @php
                            $evento = $eventosEnEstaHora->first();

                            $inicio = (int) Carbon::parse($evento->hora_inicio)->format('H');
                            $fin = (int) Carbon::parse($evento->hora_fin)->format('H');

                            $esInicio = $hora == $inicio;
                            $duracion = max(1, $fin - $inicio);
                        @endphp

                        @if($esInicio)

                            {{-- Marcar celdas ocupadas --}}
                            @for($i = $inicio; $i < $fin; $i++)
                                @php
                                    $ocupadas[$dia['fecha']][$i] = true;
                                @endphp
                            @endfor

                                <td rowspan="{{ $duracion }}"
                                    class="text-light border p-1 bg-secondary rounded"
                                    style="vertical-align: top;">

                                <a href="{{ route('Usuarios.editE', $evento->horario_id) }}"
                                   style="text-decoration: none; color:white;">

                                    <div style="font-size: 0.8rem;">
                                        <strong>{{ $evento->descripcion }}</strong><br>

                                        <span style="font-size: 0.7rem; opacity:0.8;">
                                            {{ $evento->usuario_nombre }}
                                        </span><br>

                                        <span style="font-size: 0.7rem;">
                                            {{ Carbon::parse($evento->hora_inicio)->format('g:i') }}
                                            -
                                            {{ Carbon::parse($evento->hora_fin)->format('g:i') }}
                                        </span>
                                    </div>

                                </a>
                            </td>

                        @endif

                    {{-- ⚫ SIN EVENTOS --}}
                    @else

                        <td class="text-muted border"
                            style="background-color:#000; opacity:0.1;">
                            -
                        </td>

                    @endif

                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
    
<div id="calendar">
    <div class="modal fade" id="modalEditarEvento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <form id="formEditarEvento" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        
                        <input type="hidden" name="id" id="evento_id">

                        <div class="mb-2">
                            <label>Descripción</label>
                            <input type="text" name="descripcion" id="evento_descripcion" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Fecha</label>
                            <input type="date" name="fecha" id="evento_fecha" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Hora inicio</label>
                            <input type="time" name="hora_inicio" id="evento_inicio" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Hora fin</label>
                            <input type="time" name="hora_fin" id="evento_fin" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
    window.eventos = @json($eventosFormateados);
</script>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },

            events: @json($eventosFormateados)
        });

        calendar.render();
    });
</script>

</form>
@endsection