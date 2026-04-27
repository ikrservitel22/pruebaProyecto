@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')
<div class="container-lg">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8">
                        <h2>Listade Usuarios</h2>
                    </div>
                    @if (session('permiso_id') == 1 || session('permiso_id') == 3 || session('permiso_id') == 4)
                        <div class="col-sm-4 text-end">
                            <a href="/CreateUP" class="btn btn-info">
                                <i class="fa fa-plus"></i> Nuevo Usuario
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        @foreach($listas as $lista)
                            <th>{{ $lista['nombre'] }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($Datos as $Dato)
                        <tr>
                            <td>{{ $Dato->usuario_id }}</td>
                            <td>{{ $Dato->nombre }}</td> 
                            <td>{{ $Dato->usuario }}</td>
                            @if (session('permiso_id') == 1 || session('permiso_id') == 4 )
                                <td>{{ $Dato->clave }}</td> 
                                <td>{{ $Dato->cedula }}</td> 
                            @endif
                            <td>{{ $Dato->permiso_nombre }}</td>
                            <td>
                                @if (session('permiso_id') == 1 || session('permiso_id') == 4 )
                                        <button type="button" 
                                            class="btn btn-danger"
                                            onclick="confirmarEliminacion({{ $Dato->usuario_id }})">
                                            Delete
                                        </button>

                                        <form id="formEliminar{{ $Dato->usuario_id }}" 
                                            action="{{ route('Usuarios.Softdelete', $Dato->usuario_id) }}" 
                                            method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                @endif
                                @if (session('permiso_id') == 1 || session('permiso_id') == 3 || session('permiso_id') == 4)
                                    <a href="{{ route('Usuarios.Edit', $Dato->usuario_id) }}" class="btn btn-success">
                                        Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection