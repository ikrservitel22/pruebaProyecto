@extends('layouts.app')

@php
    $hideSidebar = false;// oculta el sidebar
@endphp

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection


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
                <label class="form-label">Password</label>
                <input type="password" name="clave" class="form-control" placeholder="pasword">
            </div>

        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn border rounded bg-light me-2">iniciar sesion</button>
        </div>
    </form>

    <div class="text-center mt-3">
        <span>¿No tienes cuenta?</span> 
        <a href="/create" class="text-primary">Regístrate aquí</a>
    </div>

@endsection
