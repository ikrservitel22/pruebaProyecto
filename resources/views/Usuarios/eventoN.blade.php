@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')

    <h1 class="text-muted text-center fw-bold">CREAR EVENTO</h1>
    <form method="POST" action="{{ route('Usuarios.eventoN') }}" class="p-4 border rounded bg-dark">
        @csrf
        <div class="mb-3">
            <label>Frecuencia de asignación</label>
            <select name="frecuencia" class="form-control" required>
                <option value="unico">Solo este día ({{ $fecha ?? 'seleccionado' }})</option>
                <option value="par">Todos los días PARES del mes</option>
                <option value="impar">Todos los días IMPARES del mes</option>
            </select>
            <small class="text-muted">Esto aplicará el horario según el número del día (2, 4, 6... o 1, 3, 5...).</small>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select name="usuario_id" class="col-md-6 mb-3 form-control" id="role" required>
                    <option value="">Seleccione Usuario</option>
                    @foreach($usuarios as $u)
                        <option value="{{ $u->usuario_id }}">
                            {{ $u->usuario }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre del evento</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción del evento">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" placeholder="fecha del evento">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Hora de Inicio</label>
                <input type="time" name="hora_inicio" class="form-control" placeholder="hora de inicio">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Hora de Fin</label>
                <input type="time" name="hora_fin" class="form-control" placeholder="hora de fin">
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn border rounded bg-light me-2">crear evento</button>
            <a href="/Horario" class="btn border rounded bg-light me-2">volver</a>
        </div>
    </form>
    
@endsection