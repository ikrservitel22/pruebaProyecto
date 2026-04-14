@extends('layouts.app')

@section('content')

    <h1 class="text-muted text-center fw-bold">INICIO DE SESION</h1>

    <form method="POST" action="/login" class="p-4 border rounded bg-dark">
        @csrf
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" placeholder="usuario">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="password" name="clave" class="form-control" placeholder="pasword">
            </div>

        </div>
        
        <div class="d-flex justify-content-end mt-3">

            <button type="submit" class="btn border rounded bg-light me-2">iniciar sesion</button>

            <a href="/create" class="btn border rounded bg-light me-2">
                crear cuenta
            </a>

            <a href="/inputtt" class="btn border rounded bg-light">
                lista de inputs
            </a>

        </div>
    </form>

@endsection
