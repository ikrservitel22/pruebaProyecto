@extends('layouts.app')

@section('Button') {{-- muestra el boton solo en esta vista--}}
    <a href="/" class="btn border btn-dark">Exit</a>
@endsection

@section('content')

    <h1 class="text-muted text-center fw-bold">Listado</h1>

    <div class="accordion" id="accordionExample">

    <table class="table table-dark">
        <thead>
            <tr>
                @foreach($listas as $lista)
                    <th scope="col" class="text-white border rounded">
                        {{ $lista['nombre'] }}
                    </th>   
                @endforeach
            </tr>
        </thead>
        <tbody class="table-light">
            @foreach($Datos as $Dato)
                <tr>
                    <th scope="row">{{ $Dato->usuario_id }}</th>
                    <td>{{ $Dato->nombre }}</td>
                    <td>{{ $Dato->usuario }}</td>
                    <td>{{ $Dato->clave }}</td>
                    @if($Dato->permiso_id == 1)
                        <td>Admin</td>
                    @elseif($Dato->permiso_id == 2)
                        <td>Read</td>
                    @elseif($Dato->permiso_id == 3)
                        <td>Read/Write</td>
                    @else
                        <td>Sin rol</td>
                    @endif
                        <td>
                            @if ($Dato->permiso_id == 1 || $Dato->permiso_id == 2 || $Dato->permiso_id == 3 || $Dato->permiso_id == 4)
                                <a href="/" class="btn btn-outline-light bg-secondary border">
                                    See
                                </a>
                            @endif
                            @if ($Dato->permiso_id == 1 || $Dato->permiso_id == 3 || $Dato->permiso_id == 4)
                                <a href="/" class="btn btn-outline-light bg-primary border">
                                    Edit
                                </a>
                            @endif
                            @if ($Dato->permiso_id == 1 || $Dato->permiso_id == 4)
                                <button type="button" 
                                    class="btn btn-danger"
                                    onclick="confirmarEliminacion({{ $Dato->usuario_id }})">
                                    Eliminar
                                </button>
                                <form id="formEliminar{{ $Dato->usuario_id }}" 
                                    action="{{ route('Usuarios.destroy', $Dato->usuario_id) }}" 
                                    method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>

    

    </div>

@endsection