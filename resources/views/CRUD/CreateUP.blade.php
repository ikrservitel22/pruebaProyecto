@extends('layouts.app')

@if(session()->has('usuario'))
    @section('Button') {{-- muestra el boton solo en esta vista--}}
        <a href="/logout" class="btn btn-outline-light">Cerrar Sesión</a>
    @endsection
@endif

@section('content')

    <h1 class="text-muted text-center fw-bold">CREAR CUENTA</h1>

    <form method="POST" action="/CreateUP" class="p-4 border rounded bg-dark">
        @csrf
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">User</label>
                <input type="text" name="usuario" class="form-control" placeholder="usuario">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="nombre" class="form-control" placeholder="nombre">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="clave" class="form-control" placeholder="password">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select name="permiso" class="form-select text-dark" aria-label="Default select example">
                    <option value="" selected>Seleccione un permiso</option>
                    <option value="1">Admin</option>
                    <option value="2">Read</option>
                    <option value="3">Read/Write</option>
                </select>
            </div>

        </div>
        
        <div class="d-flex justify-content-end mt-3">

            <button type="submit" class="btn border rounded bg-light me-2">crear usuario</button>
        </div>
    </form>


@endsection