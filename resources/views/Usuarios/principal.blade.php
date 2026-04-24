@extends('layouts.app')

@php
    $hideFooter = true;// oculta el footer
@endphp 

@if(!session()->has('usuario'))
    @section('Button') {{-- muestra el boton solo en esta vista--}}
        <a href="/login" class="btn btn-outline-light">Iniciar Sesión</a>
    @endsection
@endif

@section('content')

    <a href="/logout" class="btn btn-outline-light">Cerrar Sesión</a>


@endsection