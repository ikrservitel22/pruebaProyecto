@extends('layouts.app')

@section('Button') {{-- muestra el boton solo en esta vista--}}
    <a href="/" class="btn border btn-dark">Exit</a>
@endsection

@section('content')

    <h1 class="text-muted text-center fw-bold">Listado</h1>

    <div class="accordion" id="accordionExample">

    @foreach($tareas as $tarea)
        <div class="accordion-item borer">
            <h2 class="accordion-header">
                <button 
                    class="accordion-button collapsed" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapse{{ $loop->index }}" 
                    aria-expanded="false"
                >
                    Usuario: {{ $tarea->usuario }}
                </button>
            </h2>

            <div 
                id="collapse{{ $loop->index }}" 
                class="accordion-collapse collapse"
                data-bs-parent="#accordionExample"
            >
                <div class="accordion-body">
                    <p><strong>Nombre:</strong> {{ $tarea->nombre }}</p>
                    <p><strong>Password:</strong> {{ $tarea->clave }}</p>
                </div>
            </div>
        </div>
    @endforeach

    </div>

@endsection