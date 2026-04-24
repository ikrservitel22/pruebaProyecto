@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@section('content')

    <h1 class="mb-4 text-center">Tipos de inputs</h1>

    <div class="d-flex flex-column p-4 md-12 border rounded bg-dark">
        <div clas="w-50 mb-3">
            <select class="col-md-4 mb-4 form-control" id="role">
                <option value="">Seleccione</option>
                <option value="color">color</option>
                <option value="date">date</option>
                <option value="datetime-local">datetime</option>
                <option value="email">email</option>
                <option value="file">file</option>
                <option value="hidden">hidden</option>
                <option value="image">image</option>
                <option value="month">month</option>
                <option value="number">number</option>
                <option value="radio">radio</option>
                <option value="range">range</option>
                <option value="submit">submit</option>
                <option value="tel">tel</option>
                <option value="time">time</option>
                <option value="url">url</option>
                <option value="week">week</option>
            </select>
        </div>
    </div>

    <!-- Contenedor general -->
    <div class="container bg-dark rounded p-2">

        <div id="colorContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="color">
            <p class="mt-1">Selector de color. Permite elegir un color visualmente.</p>
        </div>

        <div id="dateContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="date">
            <p class="mt-2">Permite seleccionar una fecha (día, mes, año).</p>
        </div>

        <div id="datetime-localContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="datetime-local">
            <p class="mt-2">Selecciona fecha y hora.</p>
        </div>

        <div id="emailContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="email" placeholder="correo@ejemplo.com" class="form-control">
            <p class="mt-2">Valida formato de correo electrónico.</p>
        </div>

        <div id="fileContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="file">
            <p class="mt-2">Permite subir archivos desde el equipo.</p>
        </div>

        <div id="hiddenContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="hidden" value="oculto">
            <p class="mt-2">Campo oculto que se envía pero no se muestra.</p>
        </div>

        <div id="imageContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="image" src="https://picsum.photos/100">
            <p class="mt-2">Botón de envío con imagen.</p>
        </div>

        <div id="monthContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="month">
            <p class="mt-2">Permite seleccionar mes y año.</p>
        </div>

        <div id="numberContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="number" class="form-control" placeholder="Ingresa un número">
            <p class="mt-2">Solo acepta valores numéricos.</p>
        </div>

        <div id="radioContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <div>
                <input type="radio" name="opcion"> Opción 1
                <input type="radio" name="opcion"> Opción 2
            </div>
            <p class="mt-2">Permite seleccionar una única opción.</p>
        </div>

        <div id="rangeContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="range">
            <p class="mt-2">Barra deslizante para elegir un valor.</p>
        </div>

        <div id="submitContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="submit" value="Enviar" class="btn btn-primary">
            <p class="mt-2">Botón para enviar formularios.</p>
        </div>

        <div id="telContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="tel" placeholder="3001234567" class="form-control">
            <p class="mt-2">Campo para números telefónicos.</p>
        </div>

        <div id="timeContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="time">
            <p class="mt-2">Selector de hora.</p>
        </div>

        <div id="urlContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="url" placeholder="https://ejemplo.com" class="form-control">
            <p class="mt-2">Valida direcciones web (URL).</p>
        </div>

        <div id="weekContent" class="content card p-3 shadow-sm text-center" style="display:none;">
            <input type="week">
            <p class="mt-2">Permite seleccionar una semana del año.</p>
        </div>

    </div>

    <script>
    document.getElementById('role').addEventListener('change', function() {

        let value = this.value;

        document.querySelectorAll('.content').forEach(el => {
            el.style.display = 'none';
        });

        if (value) {
            let element = document.getElementById(value + 'Content');
            if (element) {
                element.style.display = 'block';
            }
        }
    });
    </script>

@endsection