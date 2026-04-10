<h1>Lista de tareas</h1>

<form method="POST" action="/tareas">
    @csrf
    <input type="text" name="nombre" placeholder="nombre">
    <input type="text" name="usuario" placeholder="usuario">
    <input type="text" name="clave" placeholder="pasword">

    <button type="submit">Agregar</button>
</form>

<ul>
<p>registro usuarios</p>
@foreach($tareas as $tarea)
    <p>usuario: </p>
    <li>{{ $tarea->usuario }}</li>
    <p>nombre: </p>
    <li>{{ $tarea->nombre }}</li>
@endforeach
</ul>