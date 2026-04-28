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
                        <h2>Lista de Usuarios</h2>
                        @if(isset($usuarios) && $usuarios->count() == 0)
                            <p class="text-muted">No se encontraron resultados para la búsqueda.</p>
                        @endif
                    </div>
                    @if (in_array(session('rol_nombre'), ['admin', 'administrativo', 'supervizor'], true))
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
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        @if (in_array(session('rol_nombre'), ['admin'], true))
                            <th>Clave</th>
                        @endif
                        @if (in_array(session('rol_nombre'), ['admin', 'supervizor'], true))
                            <th>Cédula</th>
                        @endif
                        <th>Rol</th>
                        @if (in_array(session('rol_nombre'), ['admin', 'administrativo', 'supervizor'], true))
                            <th>Acciones</th>
                        @endif
                        
                    </tr>
                </thead>

                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->usuario_id }}</td>
                            <td>{{ $usuario->nombre }}</td> 
                            <td>{{ $usuario->usuario }}</td>
                            @if (in_array(session('rol_nombre'), ['admin'], true))
                                <td>{{ $usuario->clave }}</td> 
                            @endif
                            @if (in_array(session('rol_nombre'), ['admin', 'supervizor'], true))
                                <td>{{ $usuario->cedula }}</td> 
                            @endif
                            <td>{{ $usuario->rol_nombre ?? 'Sin rol' }}</td>
                            @if (in_array(session('rol_nombre'), ['admin', 'administrativo', 'supervizor'], true))
                                <td>
                                @if (in_array(session('rol_nombre'), ['admin'], true))
                                    <button type="button" 
                                        class="btn btn-danger"
                                        onclick="confirmarEliminacion({{ $usuario->usuario_id }})">
                                        Delete
                                    </button>

                                    <form id="formEliminar{{ $usuario->usuario_id }}" 
                                        action="{{ route('Usuarios.Softdelete', $usuario->usuario_id) }}" 
                                        method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                                @if (in_array(session('rol_nombre'), ['admin', 'administrativo', 'supervizor'], true))
                                    <a href="{{ route('Usuarios.Edit', $usuario->usuario_id) }}" class="btn btn-success">
                                        Edit
                                    </a>
                                @endif
                                <td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>

            </table>
            <!-- Paginación -->
            <div class="justify-content-center mt-4">
                {{ $usuarios->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection