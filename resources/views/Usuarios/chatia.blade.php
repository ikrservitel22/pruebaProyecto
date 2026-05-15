@extends('layouts.app')

@php
    $hideFooter = true;
@endphp 


@section('content')

<div class="container py-4">

    <div class="card bg-dark text-white">

        <div class="card-header">
            <h3>🤖 Chat IA</h3>
        </div>

        <div
            id="chat"
            class="card-body"
            style="
                height: 70vh;
                overflow-y: auto;
                background: black;
            "
        >

            <div class="mb-3">
                <div class="bg-secondary text-white p-3 rounded d-inline-block">
                    Hola 👋 Soy tu asistente IA
                </div>
            </div>

        </div>

        <div class="card-footer">

            <form id="chatForm" class="d-flex gap-2" enctype="multipart/form-data">

                <input
                    type="text"
                    id="mensaje"
                    class="form-control"
                    placeholder="Escribe un mensaje..."
                    autocomplete="off"
                >

                <input
                    type="file"
                    id="audio"
                    accept=".mp3,audio/*"
                    class="form-control"
                >

                <button class="btn btn-primary">
                    Enviar
                </button>

            </form>
        </div>

    </div>

</div>

<script>

let historial = [];

const form = document.getElementById('chatForm');
const input = document.getElementById('mensaje');
const audioInput = document.getElementById('audio');
const chat = document.getElementById('chat');

form.addEventListener('submit', async (e) => {

    e.preventDefault();

    const mensaje = input.value.trim();
    const audio = audioInput.files[0];

    if (!mensaje && !audio) return;

    // =========================
    // MOSTRAR MENSAJE USUARIO
    // =========================
    chat.innerHTML += `
        <div class="text-end mb-3">

            ${
                mensaje
                ? `
                    <div class="bg-primary text-white p-3 rounded d-inline-block">
                        ${mensaje}
                    </div>
                `
                : ''
            }

            ${
                audio
                ? `
                    <div class="bg-info text-dark p-2 rounded mt-2">
                        🎵 ${audio.name}
                    </div>
                `
                : ''
            }

        </div>
    `;

    chat.scrollTop = chat.scrollHeight;

    // =========================
    // FORM DATA
    // =========================
    const formData = new FormData();

    formData.append('mensaje', mensaje);

    // ⚠ IMPORTANTE
    // Laravel espera "audio"
    if (audio) {
        formData.append('audio', audio);
    }

    // =========================
    // LIMPIAR INPUTS
    // =========================
    input.value = '';
    audioInput.value = '';

    try {

        // =========================
        // URL DINÁMICA
        // =========================
        const url = audio
            ? '/ia/audio'
            : '/ia/chat';

        console.log('URL:', url);

        const response = await fetch(url, {

            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: formData
        });

        // =========================
        // DEBUG RESPUESTA
        // =========================
        const text = await response.text();

        console.log('RESPUESTA:', text);

        let data;

        try {

            data = JSON.parse(text);

        } catch (e) {

            console.error('NO ES JSON');

            chat.innerHTML += `
                <div class="mb-3 text-danger">
                    Error backend:<br>
                    ${text}
                </div>
            `;

            return;
        }

        // =========================
        // RESPUESTA IA
        // =========================
        chat.innerHTML += `
            <div class="mb-3">

                <div class="bg-secondary text-white p-3 rounded d-inline-block">

                    <b>Resumen:</b><br>
                    ${data.feedback?.resumen || data.resumen || 'Sin resumen'}

                    <br><br>

                    <b>Sentimiento:</b><br>
                    ${data.feedback?.sentimiento_general || data.sentimiento_general || 'N/A'}

                    <br><br>

                    <b>Temas:</b><br>
                    ${(data.feedback?.temas_principales || data.temas_principales || []).join(', ')}

                    <br><br>

                    <b>Calidad:</b><br>
                    ${data.feedback?.calidad ?? data.calidad ?? 'N/A'}

                    <br><br>

                    <b>Riesgos:</b><br>
                    ${(data.feedback?.riesgos || data.riesgos || []).join(', ')}

                </div>

            </div>
        `;

        chat.scrollTop = chat.scrollHeight;

    } catch (error) {

        console.error(error);

        chat.innerHTML += `
            <div class="mb-3 text-danger">
                Error conectando con IA
            </div>
        `;
    }

});

</script>

@endsection