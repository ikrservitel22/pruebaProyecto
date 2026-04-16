<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>proyecto prueva</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="d-flex flex-column height: 100% mt-auto">

    @if(!isset($hideHeader))
        @include('layouts.headerprv')
    @endif 

    <div class="container mt-5 flex-fill flex-grow-1 p-4">
        @yield('content')
    </div>

    @if(!isset($hideSidebar))
        @include('layouts.sidebar', ['menu' => $menu])
    @endif 

    @if(!isset($hideFooter))
        @include('layouts.footer')
    @endif 


    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    </script>
    @endif

    @if(session('error_2'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error_2') }}'
        });
    </script>
    @endif

    <style>
        .accordion-button {
            background-color: #3b4046;
            color: white;
        }

        .accordion-button:not(.collapsed) {
            background-color: #565660;
            color: white;
        }

        .accordion-button::after {
            filter: invert(1);
        }
        .form-select {
            background-color: #fefefe;
            color: white;
            border: 1px solid #ffffff;
        }

        .form-select:focus {
            border-color: #0f84d3;
            box-shadow: 0 0 5px rgba(84, 80, 69, 0.57);
        }
        .form-select option:checked {
            background-color: #a0a0a0c9;
            color: white;
        }
        .form-select option {
            background-color: #ebe9e9;
            color: black;
        }
    </style>

    <script>
        let abierto = true;

        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');

            if (abierto) {
                sidebar.style.right = '-250px';
            } else {
                sidebar.style.right = '0';
            }

            abierto = !abierto;
        }
    </script>
</body>
</html>

{{-- 
@php
    $hideHeader = true;// oculta el header
@endphp

@php
    $hideFooter = true;// oculta el footer
@endphp 
--}}