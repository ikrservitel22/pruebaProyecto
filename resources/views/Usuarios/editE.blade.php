@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')

<h1 class="text-muted text-center fw-bold">EDITAR EVENTO</h1>

<form method="POST" action="{{ route('evento.update', $evento->horario_id) }}" class="p-4 border rounded bg-dark">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Descripción</label>
            <input type="text" name="descripcion" class="form-control" value="{{ $evento->descripcion }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Usuario</label>
            <select name="usuario_id" class="form-control">
                @foreach($usuarios as $u)
                    <option value="{{ $u->usuario_id }}"
                        {{ $evento->usuario_id == $u->usuario_id ? 'selected' : '' }}>
                        {{ $u->usuario }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $evento->fecha }}">
        </div>

        <div class="col-md-3 mb-3">
            <label>Hora inicio</label>
            <input type="time" name="hora_inicio" class="form-control" value="{{ $evento->hora_inicio }}">
        </div>

        <div class="col-md-3 mb-3">
            <label>Hora fin</label>
            <input type="time" name="hora_fin" class="form-control" value="{{ $evento->hora_fin }}">
        </div>

    </div>

    <div class="d-flex justify-content-end mt-3">

        <button type="submit" class="btn bg-light me-2">
            Actualizar
        </button>

        <button type="button" onclick="history.back()" class="btn bg-light">
            Volver
        </button>

    </div>
</form>

@endsection