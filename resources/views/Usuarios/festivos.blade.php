@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')
   
    <!-- SECCIÓN DE FESTIVOS -->
    <div class="row">
        <div class="col-12">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0">Calendario de Festivos</h5>
                    
                    <!-- Mensaje de éxito tras actualizar -->
                    @if(session('success'))
                        <div class="alert alert-success py-1 px-3 m-0">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Día</th>
                                <th>Mes</th>
                                <th>Descripción</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($festivos as $f)
                            <tr>
                                <td>{{ $f->dia }}</td>
                                <td>{{ $f->mes }}</td>
                                <td>{{ $f->descripcion }}</td>
                                <td class="text-center">
                                    <!-- Botón para abrir el modal usando festivo_id -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $f->festivo_id }}">
                                        Editar
                                    </button>
                                </td>
                            </tr>

                            <!-- MODAL DE EDICIÓN PARA CADA FESTIVO -->
                            <div class="modal fade" id="modalEditar{{ $f->festivo_id }}" tabindex="-1" aria-labelledby="label{{ $f->festivo_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Importante: Asegúrate de que esta URL exista en web.php como Route::post -->
                                        <form action="{{ url('/Festivos/update') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="label{{ $f->festivo_id }}">Editar Festivo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Campo oculto con el ID para el controlador -->
                                                <input type="hidden" name="id" value="{{ $f->festivo_id }}">

                                                <div class="mb-3">
                                                    <label class="form-label">Día</label>
                                                    <input type="number" name="dia" class="form-control" value="{{ $f->dia }}" required min="1" max="31">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Mes</label>
                                                    <input type="number" name="mes" class="form-control" value="{{ $f->mes }}" required min="1" max="12">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion" class="form-control" value="{{ $f->descripcion }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection