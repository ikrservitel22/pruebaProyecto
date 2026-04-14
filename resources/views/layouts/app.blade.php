<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>proyecto prueva</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <!-- 🔝 HEADER -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">proyecto prueva</a>
        </div>
    </nav>

    <!-- 📦 CONTENIDO -->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- 🔽 parte de abajo -->
    <footer class="bg-dark text-white text-center p-5 mt-5">
        <p>parte de abajo</p>
    </footer>

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

</body>
</html>