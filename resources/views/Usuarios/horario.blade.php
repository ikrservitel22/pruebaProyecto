@extends('layouts.app')

@php
    $hideFooter = true;
@endphp 

@section('Button')
    <button onclick="history.back()" class="btn btn-outline-light">← Volver</button>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

@vite(['resources/js/app.js'])

@section('content')

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<!-- Estilos personalizados para el calendario con tema del proyecto -->
<style>
    .calendar-wrapper {
        background: linear-gradient(135deg, #d900ff 0%, #66ff00 100%);
        border-radius: 12px;
        padding: 0;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .calendar-header {
        background: linear-gradient(135deg, #6e7582 0%, #282b35 100%);
        padding: 20px 25px;
        border-bottom: 3px solid #3b4858;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .calendar-header h2 {
        margin: 0;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .btn-calendar-create {
        background: #5b606b;
        border: none;
        color: white;
        font-weight: 600;
        padding: 5px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-calendar-create:hover {
        background: linear-gradient(135deg,  #282b35 0%, #6e7582 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        color: white;
    }

    .fc {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #34495e;
        border: none;
    }

    #calendar {
        background: #6e7582; /* color sidebar */
        padding: 15px;
        border-radius: 0;
        box-shadow: none;
    }

    .fc .fc-button-primary {
        background-color: #282b35 !important; /* azul pag */
        border-color: #dbdbdb !important; /* gris boton */
        color: white;
        font-weight: 600;
    }

    .fc .fc-button-primary:hover,
    .fc .fc-button-primary:focus {
        background-color: #51565f !important;
        border-color: #dbdbdb !important;
    }

    .fc .fc-button-primary.fc-button-active {
        background-color: #282b35 !important;
        border-color: #6e7582 !important;
    }

    .fc .fc-toolbar {
        padding: 12px 15px;
        background-color: #282b35;
        flex-wrap: wrap;
        gap: 10px;
    }

    .fc .fc-toolbar-title {
        color: #ffffff;
        font-size: 1.6rem;
        font-weight: 700;
    }

    .fc .fc-col-header {
        background-color: #282b35;
    }

    .fc .fc-col-header-cell {
        color: #ffffff;
        font-weight: 600;
        padding: 12px 4px;
    }

    .fc .fc-daygrid-day {
        background-color: #3f4454;
        border-color: #a1a6ae;
    }

    .fc .fc-daygrid-day:hover {
        background-color: #6e7582;
    }

    .fc .fc-daygrid-day.fc-day-other {
        background-color: #3e4249;
        opacity: 0.6;
    }

    .fc .fc-daygrid-day-number {
        color: #969fb1;
        padding: 8px;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: #61687d;
    }

    .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        color: #a8b5d3;
        font-weight: bold;
    }

    .fc .fc-event {
        background-color: #575d68 !important;
        border-color: #8a92a2 !important;
        cursor: pointer !important;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .fc .fc-event:hover {
        background-color: #8a92a2 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .fc .fc-event-title {
        color: white;
        font-weight: 700;
        padding: 4px 6px;
        font-size: 0.85rem;
    }

    .fc .fc-timegrid-slot {
        height: 3em;
        color: #ffffff !important;
    }

    .fc .fc-timegrid-slot-label {
        vertical-align: middle;
        font-size: 0.75rem;
        color: #ffffff;
    }

    .fc .fc-col-time-base {
        color: #f7f7f7;
    }

    .fc .fc-button-group .fc-button {
        border-radius: 6px;
        margin-right: 4px;
    }

    .modal-header {
        background: linear-gradient(135deg, #282b35 0%, #6e7582 100%);
        border-color: #1a252f;
    }

    .modal-header .modal-title {
        color: #ecf0f1;
        font-weight: 700;
    }

    .modal-body {
        background-color: #ecf0f1;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        border-top: 1px solid #dee2e6;
    }

    .form-control, .form-select {
        background-color: #fff;
        border-color: #bdc3c7;
        color: #2c3e50;
        border-radius: 6px;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #464f5e;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        color: #2c3e50;
    }

    .form-label {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #c0392b;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #a93226;
    }

    .btn-primary {
        background-color: #44495a;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #1f618d;
    }
</style>

<div class="calendar-wrapper">
    <div class="calendar-header">
        <h2>Calendario de Horarios</h2>
        <button class="btn btn-calendar-create" data-bs-toggle="modal" data-bs-target="#modalCrearHorario">
            Nuevo Horario
        </button>
    </div>
    

    <!-- Contenedor del calendario -->
    <div id="calendar">
        <button id="btnDescargarCSV" class="btn btn-calendar-create mt-4 border">
            Descargar CSV
        </button><br>
        <form action="{{ route('horarios.importar') }}" method="POST" enctype="multipart/form-data" class="ms-2 ">
            @csrf
            <div class="mb-2">
                <input type="file" name="archivo" class="form-control " accept=".csv" required>
            </div>

            <button type="submit" class="btn btn-calendar-create mt-3 ms-2 border">
                Importar Horarios
            </button>
        </form>
    </div>
</div>

<!-- Modal para crear horario -->
<div class="modal fade" id="modalCrearHorario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCrearHorario" method="POST" action="{{ route('Usuarios.eventoN') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"> Crear Nuevo Horario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Usuario/Tipo</label>
                        <select name="usuario_id" id="horario_usuario" class="form-select" required >
                            <option value="">-- Seleccione un usuario --</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->usuario_id }}">{{ $u->usuario }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción del Horario</label>
                        <input type="text" name="descripcion" id="horario_descripcion" class="form-control" required placeholder="Nombre o descripción del horario">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de creación</label>
                        <select id="tipo_creacion" class="form-select">
                            <option value="dia">Solo un día</option>
                            <option value="mes">Todo el mes</option>
                        </select>
                    </div>

                    <!-- CAMPOS PARA UN SOLO DÍA -->
                    <div id="fecha_exacta">
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="horario_fecha" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora Inicio</label>
                                <input type="time" name="hora_inicio" id="horario_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hora Fin</label>
                                <input type="time" name="hora_fin" id="horario_fin" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- CAMPOS PARA TODO EL MES -->
                    <div id="campo_mes" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Frecuencia</label>
                            <select name="frecuencia" class="form-select">
                                <option value="par">Días pares</option>
                                <option value="impar">Días impares</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Horario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar horario -->
<div class="modal fade" id="modalEditarHorario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarHorario">
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"> Editar Horario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_horario_id">

                    <div class="mb-3">
                        <label class="form-label">Usuario/Tipo</label>
                        <select name="usuario_id" id="edit_horario_usuario" class="form-select" required>
                            <option value="">-- Seleccione un usuario --</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->usuario_id }}">{{ $u->usuario }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción del Horario</label>
                        <input type="text" name="descripcion" id="edit_horario_descripcion" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="edit_horario_fecha" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Inicio</label>
                            <input type="time" name="hora_inicio" id="edit_horario_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Fin</label>
                            <input type="time" name="hora_fin" id="edit_horario_fin" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnEliminarHorario"> Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    document.getElementById('btnDescargarCSV').addEventListener('click', function () {
        const calendar = window.calendarInstance;

        const fecha = calendar.getDate(); // fecha actual del calendario

        const mes = fecha.getMonth() + 1; // 1-12
        const anio = fecha.getFullYear();

        window.location.href = `/exportar-horarios?mes=${mes}&anio=${anio}`;
    });

    console.log('CALENDAR INIT');
    // Datos disponibles para el calendario
    window.eventos = @json($horariosFormateados);
    window.eventosDetalle = @json($horarios);
    
    let currentEditingEventId = null;

    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');
        
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            
            // Mostrar horas en vista semanal/diaria
            slotDuration: '01:00:00',
            slotLabelInterval: '01:00',
            slotLabelFormat: {
                meridiem: 'short',
                hour: 'numeric',
                minute: '2-digit'
            },
            
            // Eventos formateados
            events: window.eventos,
            
            eventDisplay: 'block',
            eventTextColor: '#ffffff',
            eventBackgroundColor: '#3498db',
            eventBorderColor: '#2980b9',
            
            // Al hacer click en un horario existente
            eventClick: function(info) {
                abrirModalEditar(info.event);
            },
            
            // Al seleccionar una fecha en el calendario
            dateClick: function(info) {
                const fecha = info.dateStr;
                const hora = info.date.getHours().toString().padStart(2, '0') + ':00';
                
                // Limpiar el formulario
                document.getElementById('formCrearHorario').reset();
                document.getElementById('horario_fecha').value = fecha;
                document.getElementById('horario_inicio').value = hora;
                document.getElementById('horario_fin').value = (parseInt(hora) + 1).toString().padStart(2, '0') + ':00';
                
                const modalElement = document.getElementById('modalCrearHorario');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            },
            
            // Permitir arrastrear eventos
            editable: true,
            eventDrop: function(info) {
                actualizarEventoDrop(info.event);
            },
            eventResize: function(info) {
                actualizarEventoResize(info.event);
            },
            
            locale: 'es',
            firstDay: 1, // Lunes como primer día
        });

        calendar.render();
        window.calendarInstance = calendar;
    });

    //filtro para selector
    document.getElementById('tipo_creacion').addEventListener('change', function() {
        const valor = this.value;

        const campoMes = document.getElementById('campo_mes');
        const fechaExacta = document.getElementById('fecha_exacta');

        if (valor === 'mes') {
            campoMes.style.display = 'block';
            fechaExacta.style.display = 'none';
        } else {
            campoMes.style.display = 'none';
            fechaExacta.style.display = 'block';
        }
    });

    // Función para abrir el modal de editar
    function abrirModalEditar(event) {
        console.log('Abriendo evento ID:', event.id);
        currentEditingEventId = event.id;
        
        // Buscar el evento completo en los detalles
        const horarioDetalle = window.eventosDetalle.find(e => e.horario_id == event.id);
        console.log('Evento detalle encontrado:', horarioDetalle);
        
        document.getElementById('edit_horario_id').value = event.id;
        
        // Limpiar y asignar los valores
        document.getElementById('edit_horario_descripcion').value = horarioDetalle ? horarioDetalle.descripcion : event.title.split(' (')[0];
        
        // Asignar el usuario - IMPORTANTE: asegurarse de que el valor sea una cadena
        const usuarioSelect = document.getElementById('edit_horario_usuario');
        if (horarioDetalle) {
            usuarioSelect.value = String(horarioDetalle.usuario_id);
            console.log('Usuario seleccionado:', usuarioSelect.value);
        }
        
        const startDate = new Date(event.start);
        const endDate = new Date(event.end);
        
        document.getElementById('edit_horario_fecha').value = startDate.toISOString().split('T')[0];
        document.getElementById('edit_horario_inicio').value = 
            startDate.getHours().toString().padStart(2, '0') + ':' + 
            startDate.getMinutes().toString().padStart(2, '0');
        document.getElementById('edit_horario_fin').value = 
            endDate.getHours().toString().padStart(2, '0') + ':' + 
            endDate.getMinutes().toString().padStart(2, '0');
        
        const modalElement = document.getElementById('modalEditarHorario');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }

    // Enviar formulario de editar
    document.getElementById('formEditarHorario').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('edit_horario_id').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        const data = {
            usuario_id: document.getElementById('edit_horario_usuario').value,
            descripcion: document.getElementById('edit_horario_descripcion').value,
            fecha: document.getElementById('edit_horario_fecha').value,
            hora_inicio: document.getElementById('edit_horario_inicio').value,
            hora_fin: document.getElementById('edit_horario_fin').value
        };
        
        fetch(`/Evento/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if(response.ok) {
                return response.json();
            } else {
                throw new Error('Error al actualizar: ' + response.status);
            }
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Evento actualizado correctamente',
                timer: 1500
            }).then(() => {
                location.reload();
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el evento: ' + error.message
            });
        });
    });

    // Botón eliminar horario con Swal.fire
    document.getElementById('btnEliminarHorario').addEventListener('click', function() {
        const id = document.getElementById('edit_horario_id').value;
        const descripcion = document.getElementById('edit_horario_descripcion').value;
        
        Swal.fire({
            title: '¿Eliminar horario?',
            text: `¿Deseas eliminar "${descripcion}"? No podrás revertir esto.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            confirmButtonColor: '#e74c3c',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
                fetch(`/Evento/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if(response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'Evento eliminado correctamente',
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error('Error al eliminar');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el evento'
                    });
                });
            }
        });
    });

    // Actualizar evento cuando se arrastra
    function actualizarEventoDrop(event) {
        const id = event.id;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const newStart = new Date(event.start);
        const newDate = newStart.toISOString().split('T')[0];
        const newTime = newStart.getHours().toString().padStart(2, '0') + ':' + 
                       newStart.getMinutes().toString().padStart(2, '0');
        
        const data = {
            fecha: newDate,
            hora_inicio: newTime
        };
        
        fetch(`/Evento/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data)
        })
        .catch(error => console.error('Error al actualizar:', error));
    }

    function actualizarEventoResize(event) {
        const id = event.id;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const newStart = new Date(event.start);
        const newEnd = new Date(event.end);
        
        const newDate = newStart.toISOString().split('T')[0];
        const newStartTime = newStart.getHours().toString().padStart(2, '0') + ':' + 
                           newStart.getMinutes().toString().padStart(2, '0');
        const newEndTime = newEnd.getHours().toString().padStart(2, '0') + ':' + 
                         newEnd.getMinutes().toString().padStart(2, '0');
        
        const data = {
            fecha: newDate,
            hora_inicio: newStartTime,
            hora_fin: newEndTime
        };
        
        fetch(`/Evento/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data)
        })
        .catch(error => console.error('Error al redimensionar:', error));
    }

    // Validar horarios en los formularios
    function validarHoras(inicioId, finId) {
        const inicio = document.getElementById(inicioId);
        const fin = document.getElementById(finId);
        
        fin.addEventListener('change', function() {
            if(inicio.value && fin.value && fin.value <= inicio.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La hora de fin debe ser posterior a la de inicio'
                });
                fin.value = '';
            }
        });
    }

    validarHoras('evento_inicio', 'evento_fin');
    validarHoras('edit_horario_inicio', 'edit_horario_fin');
</script>

@endsection