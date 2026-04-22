import './bootstrap';
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar')

    if (calendarEl) {
        let calendar = new Calendar(calendarEl, {

            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: 'dayGridMonth',

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },

            // 🔥 EVENTOS DESDE LARAVEL
            events: window.eventos,

            // 🔥 CLICK → MODAL
            eventClick: function(info) {

                let evento = info.event;

                document.getElementById('evento_id').value = evento.id;
                document.getElementById('evento_descripcion').value = evento.title;

                let start = evento.start;
                let end = evento.end;

                document.getElementById('evento_fecha').value = start.toISOString().split('T')[0];
                document.getElementById('evento_inicio').value = start.toTimeString().slice(0,5);

                if (end) {
                    document.getElementById('evento_fin').value = end.toTimeString().slice(0,5);
                }

                document.getElementById('formEditarEvento').action = `/Horario/update/${evento.id}`;

                let modal = new bootstrap.Modal(document.getElementById('modalEditarEvento'));
                modal.show();
            }

        });

        calendar.render()
    }
})