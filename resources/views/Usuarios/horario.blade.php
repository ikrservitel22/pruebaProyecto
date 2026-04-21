@extends('layouts.app')

@php
    $hideFooter = true;// oculta el footer
@endphp 

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')

<form method="GET" class="p-4 border rounded bg-dark">>
    <div class="row">
        <input type="date" class="col-md-5 ms-5 m-2" id="role" name="fecha" value="{{ request('fecha') }}">
        <button class="col-md-2 ms-2 m-2 btn btn-light bg-light" type="submit">Ver semana</button>
        <a class="col-md-3 m-2  btn btn-light bg-light" href="/Evento">Crear Evento</a>
    </div>

    <table class="table table-bordered text-center rounded p-1 mt-4 bg-dark">
        <thead>
            <tr>
                <th class="bg-dark text-light border"><strong><h5>Hora</h5></strong></th>
                @foreach($dias as $dia)
                    <th class="bg-dark text-light border">
                        <strong><h7>
                            {{ strtoupper($dia['nombre']) }} <br>
                            {{ $dia['numero'] }}
                        </strong></h7>
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($horas as $hora)
                <tr>
                    <td class="bg-secondary text-light border" style="font-size: 16px; width:150px;">
                        <strong>
                            {{ date('g:iA', strtotime($hora . ':00')) }}-{{ date('g:iA', strtotime(($hora + 1) . ':00')) }}
                        </strong>
                    </td>

                    @foreach($dias as $dia)
                        <td class="text-light border">
                            @php
                                $evento = $eventos->first(function($e) use ($dia, $hora) {

                                    $fechaEvento = \Carbon\Carbon::parse($e->fecha)->format('Y-m-d');

                                    $inicio = \Carbon\Carbon::parse($e->hora_inicio)->format('H');
                                    $fin = \Carbon\Carbon::parse($e->hora_fin)->format('H');

                                    return $fechaEvento == $dia['fecha']
                                        && $hora >= $inicio
                                        && $hora < $fin;
                                });
                            @endphp

                            @if($evento)
                                <a href="{{ route('Usuarios.editE', $evento->horario_id) }}" >
                                <div class="btn bg-perso text-white p-1 rounded container-fluid">
                                    <strong><h6>{{ $evento->descripcion }} <br></strong></h6>
                                    <strong><h7>User: {{ $evento->usuario_nombre }}</strong></h7><br>
                                    <h7 class="text-start p">
                                        {{ \Carbon\Carbon::parse($evento->hora_inicio)->format('g:iA') }}
                                        -
                                        {{ \Carbon\Carbon::parse($evento->hora_fin)->format('g:iA') }}
                                    </h7>
                                </div>
                                </a>
                            @else
                                <div class="text-muted bg-light p-1 rounded">-</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    
</form>
@endsection