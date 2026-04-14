@extends('layouts.app')

@section('content')

    <h1 class="text-muted text-center fw-bold">Listado</h1>

    @foreach($tareas as $tarea)
        <div class="mb-2 p-2 border rounded bg-secondary">
            <p class="text-light"><strong>Usuario: </strong> {{ $tarea->usuario }} </p>
            <p class="text-light"><strong>Nombre: </strong> {{ $tarea->nombre }} </p>
            <p class="text-light"><strong>Password: </strong> {{ $tarea->clave }} </p>
            <input type="search" class="btn border rounded bg-light me-2">permisos</button>
        </div>
    @endforeach

    <a href="/" class="btn btn-danger">
        Exit
    </a>


@endsection