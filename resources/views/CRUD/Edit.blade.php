@extends('layouts.app')

@section('Button')
    <a href="/lista" class="btn border btn-dark">Exit</a>
@endsection

@section('content')

<h1 class="text-muted text-center fw-bold">EDITAR USUARIO</h1>

<form method="POST" action="{{ route('Usuarios.Update', $Usuario->usuario_id) }}" class="p-4 border rounded bg-dark">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $Usuario->nombre }}" readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" value="{{ $Usuario->usuario }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Contraseña</label>
            <input type="text" name="clave" class="form-control" value="{{ $Usuario->clave }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Permiso</label>
            <select name="permiso_id" class="form-control">
                @foreach($Permisos as $permiso)
                    <option value="{{ $permiso->permiso_id }}"
                        {{ $Usuario->permiso_id == $permiso->permiso_id ? 'selected' : '' }}>
                        {{ $permiso->permisos }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
    
    <div class="d-flex justify-content-end mt-3">

        <button type="submit" class="btn border rounded bg-light me-2">
            Actualizar
        </button>

        <a href="/lista" class="btn border rounded bg-light">
            Volver
        </a>

    </div>
</form>

@endsection