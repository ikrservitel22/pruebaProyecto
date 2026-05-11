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

            <form id="chatForm" class="d-flex">

                <input
                    type="text"
                    id="mensaje"
                    class="form-control me-2"
                    placeholder="Escribe un mensaje..."
                    autocomplete="off"
                >

                <button class="btn btn-primary">
                    Enviar
                </button>

            </form>

        </div>

    </div>

</div>

<script>

const form = document.getElementById('chatForm');
const input = document.getElementById('mensaje');
const chat = document.getElementById('chat');

form.addEventListener('submit', async (e) => {

    e.preventDefault();

    const mensaje = input.value.trim();

    if (!mensaje) return;

    // Mensaje usuario
    chat.innerHTML += `
        <div class="text-end mb-3">
            <div class="bg-primary text-white p-3 rounded d-inline-block">
                ${mensaje}
            </div>
        </div>
    `;

    input.value = '';

    // Scroll abajo
    chat.scrollTop = chat.scrollHeight;

    try {

        const response = await fetch('/ia/chat', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                mensaje: mensaje
            })

        });

        const data = await response.json();

        // Respuesta IA
        chat.innerHTML += `
            <div class="mb-3">
                <div class="bg-secondary text-white p-3 rounded d-inline-block">
                    ${data.response}
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