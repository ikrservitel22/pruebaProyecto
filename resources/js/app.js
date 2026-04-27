import './bootstrap';
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'

document.addEventListener('DOMContentLoaded', function () {
    // Obtener el elemento del calendario
    let calendarEl = document.getElementById('calendar')

    if (calendarEl) {
        // Inicializar FullCalendar
        let calendar = new Calendar(calendarEl, {

            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: 'dayGridMonth',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },

            //  EVENTOS DESDE LARAVEL - Cargar eventos desde la variable global
            events: window.eventos,

            //  CLICK → MODAL - Manejar clic en evento para mostrar modal de edición
            eventClick: function(info) {

                let evento = info.event;

                // Llenar los campos del formulario con los datos del evento
                document.getElementById('horario_id').value = evento.id;
                document.getElementById('horario_descripcion').value = evento.title;

                let start = evento.start;
                let end = evento.end;

                document.getElementById('horario_fecha').value = start.toISOString().split('T')[0];
                document.getElementById('horario_inicio').value = start.toTimeString().slice(0,5);

                if (end) {
                    document.getElementById('horario_fin').value = end.toTimeString().slice(0,5);
                }

                // Actualizar la acción del formulario
                document.getElementById('formEditarHorario').action = `/Horario/update/${evento.id}`;

                // Mostrar el modal de edición
                let modal = new bootstrap.Modal(document.getElementById('modalEditarHorario'));
                modal.show();
            }

        });

        // Renderizar el calendario
        calendar.render()
    }
})