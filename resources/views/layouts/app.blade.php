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

    <div id="content-wrapper" style="width: 100%; margin-left: 0; transition: margin-left .3s, width .3s;">
        <div id="main-content" class="container mt-5 flex-fill flex-grow-1 p-4" style="max-width: 1080px; width: 100%; margin: 70px auto 0 auto;">
            @yield('content')
        </div>
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
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}'
            }).then(() => {
                window.location.reload();
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Eliminar usuario?',
                text: 'No podrás revertir esto',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formEliminar' + id).submit();
                }
            });
        }
    </script>

    <style>
        .bg-perso {
            background-color: #6969a4;
        }
        tbody tr {
            height: 25px;
        }
        .table {
            font-size: 12px;
        }

        .table td, .table th {
            padding: 4px !important;
        }
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
        let sidebarOpen = false;

        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            let wrapper = document.getElementById('content-wrapper');
            let navbar = document.getElementById('main-navbar');

            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(-100%)';
                wrapper.style.width = '100%';
                wrapper.style.marginLeft = '0';
                navbar.style.marginLeft = '0';
            } else {
                sidebar.style.transform = 'translateX(0)';
                wrapper.style.width = 'calc(100% - 250px)';
                wrapper.style.marginLeft = '250px';
                navbar.style.marginLeft = '250px';
            }

            sidebarOpen = !sidebarOpen;
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