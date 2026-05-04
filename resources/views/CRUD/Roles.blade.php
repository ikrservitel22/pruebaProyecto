@extends('layouts.app')

@section('content')
<style>
    .card-roles { background: #282b35; border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    .table-dark { --bs-table-bg: #1d2028; color: white; }
    .badge-permiso { 
        background-color: #525768 !important; 
        color: #bdc3d9 !important; 
        padding: 5px 12px !important;
        margin: 2px;
        border-radius: 6px;
        display: inline-block;
        font-size: 0.75rem;
        font-weight: bold;
    }
    .text-rol-name { color: #ffffff !important; font-weight: 600; font-size: 1.1rem; }
    .text-descripcion { color: #ffffffb0; font-size: 0.9rem; }
    .modal-content { background-color: #282b35; color: white; border-radius: 15px; }
    .form-control { background-color: #696f83ca; border: 1px solid #3f3f4b; color: white; }
    .form-control:focus { background-color: #696f83ca; color: white; border-color: #a9afc2; }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-4">
    <div class="card card-roles shadow-lg">
        <div class="card-header bg-transparent d-flex justify-content-between p-4 align-items-center">
            <h2 class="text-white fw-bold mb-0">Gestión de Roles</h2>
            <button class="btn btn-secondary px-4" data-bs-toggle="modal" data-bs-target="#modalCrearRol">
                Nuevo Rol
            </button>
        </div>

        <div class="card-body">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr class="text-secondary small text-uppercase">
                        <th>ID</th>
                        <th>ROL / DESCRIPCIÓN</th>
                        <th>PERMISOS ASIGNADOS</th>
                        <th class="text-end">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $rol)
                        <tr>
                            <td class="text-secondary">#{{ $rol->rol_id }}</td>
                            <td>
                                <div class="text-rol-name">{{ $rol->rol }}</div>
                                <div class="text-descripcion">{{ $rol->descripcion ?? 'Sin descripción' }}</div>
                            </td>
                            <td>
                                @forelse($rol->permisos as $p)
                                    <span class="badge-permiso">{{ $p->permisos }}</span>
                                @empty
                                    <span class="text-muted small">Sin permisos</span>
                                @endforelse
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-light rounded-pill px-3" 
                                    onclick='abrirModalEditar(@json($rol))'>
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCrearRol" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Configurar Nuevo Rol</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="small text-secondary">NOMBRE DEL ROL</label>
                        <input type="text" name="rol" class="form-control" placeholder="Ej: Administrador" required>
                    </div>

                    <div class="mb-4">
                        <label class="small text-secondary">DESCRIPCIÓN</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Explica qué hace este rol..."></textarea>
                    </div>

                    <label class="small text-secondary mb-3">SELECCIONAR PERMISOS</label>
                    <div class="row g-2">
                        @foreach($permisos as $permiso)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" 
                                        value="{{ $permiso->permiso_id }}" id="pc_{{ $permiso->permiso_id }}">
                                    <label class="form-check-label text-white small" for="pc_{{ $permiso->permiso_id }}">
                                        {{ $permiso->permisos }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-light w-100">Crear Rol</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarRol" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <form id="formEditarRol">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-wite">Editar Rol</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_rol_id">
                    
                    <div class="mb-3">
                        <label class="small text-secondary">NOMBRE DEL ROL</label>
                        <input type="text" id="edit_rol_nombre" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="small text-secondary">DESCRIPCIÓN</label>
                        <textarea id="edit_descripcion" class="form-control" rows="2"></textarea>
                    </div>

                    <label class="small text-secondary mb-3">PERMISOS DEL ROL</label>
                    <div class="row g-2">
                        @foreach($permisos as $permiso)
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input edit-permiso" type="checkbox" 
                                        value="{{ $permiso->permiso_id }}" id="ep_{{ $permiso->permiso_id }}">
                                    <label class="form-check-label text-white small" for="ep_{{ $permiso->permiso_id }}">
                                        {{ $permiso->permisos }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-light w-100 text-dark fw-bold">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalEditar(rol) {
    document.getElementById('edit_rol_id').value = rol.rol_id;
    document.getElementById('edit_rol_nombre').value = rol.rol;
    document.getElementById('edit_descripcion').value = rol.descripcion || ''; // Cargamos descripción

    // Limpiar checks
    document.querySelectorAll('.edit-permiso').forEach(c => c.checked = false);

    // Marcar permisos
    if(rol.permisos) {
        rol.permisos.forEach(p => {
            let chk = document.getElementById('ep_' + p.permiso_id);
            if(chk) chk.checked = true;
        });
    }

    new bootstrap.Modal(document.getElementById('modalEditarRol')).show();
}

document.getElementById('formEditarRol').addEventListener('submit', function(e){
    e.preventDefault();
    const id = document.getElementById('edit_rol_id').value;
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    let seleccionados = [];
    document.querySelectorAll('.edit-permiso:checked').forEach(c => seleccionados.push(c.value));

    fetch(`/editar-rol/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
        body: JSON.stringify({
            rol: document.getElementById('edit_rol_nombre').value,
            descripcion: document.getElementById('edit_descripcion').value, // Enviamos descripción
            permisos: seleccionados
        })
    })
    .then(res => res.json())
    .then(data => { if(data.success) location.reload(); });
});
</script>
@endsection