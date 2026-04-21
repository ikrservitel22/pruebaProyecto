@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')

    <h1 class="text-muted text-center fw-bold">CREAR CUENTA</h1>

    <form method="POST" action="/create" class="p-4 border rounded bg-dark">
        @csrf
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" placeholder="usuario">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" placeholder="nombre">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="clave" class="form-control" placeholder="pasword">
            </div>

        </div>
        
        <div class="d-flex justify-content-end mt-3">

            <button type="submit" class="btn border rounded bg-light me-2">crear</button>

            <a href="/login" class="btn border rounded bg-light">
                Iniciar Sesion
            </a>

        </div>
    </form>

@endsection