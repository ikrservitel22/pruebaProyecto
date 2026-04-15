@extends('layouts.app')

@php
    $hideFooter = true;// oculta el footer
@endphp 

@if(!session()->has('usuario'))

    @php
        $hideSidebar = true;// oculta el footer
    @endphp 

    @section('Button') {{-- muestra el boton solo en esta vista--}}
        <a href="/login" class="btn btn-outline-light">Iniciar Sesión</a>
    @endsection

@else
    @section('Button') {{-- muestra el boton solo en esta vista--}}
        <a href="/logout" class="btn btn-outline-light">Cerrar Sesión</a>
    @endsection
@endif

@section('content')

@if(session()->has('usuario'))
    <a href="/lista" class="btn btn-outline-light border bg-dark">
        Lista De Usuarios
    </a>
@endif

@endsection