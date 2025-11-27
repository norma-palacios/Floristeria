<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <style>
        body {
            background-color: #F8D7E3;
            font-family: Arial, sans-serif;
        }

        .navbar-custom {
            background-color: #6A1B9A;
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: #fff !important;
        }

        .navbar-custom .nav-link:hover {
            text-decoration: underline;
        }

        .navbar-custom {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        .navbar-custom .container-fluid {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        .navbar-custom .navbar-nav .nav-link {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
</style>

</head>
<body>

    <!-- NAVBAR BOOSTRAP -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3 px-0">
        <div class="container-fluid px-0">

            <!-- Marca -->
            <a class="navbar-brand fw-bold" href="#">
                Dinamita Flowersshop
            </a>

            <!-- Botón móvil -->
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Items -->
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Inicio</a>
                    </li>
                        @guest
                            @if (!request()->routeIs('login'))
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold" href="{{ route('login') }}">
                                        Iniciar Sesión
                                    </a>
                                </li>
                            @endif

                            @if (!request()->routeIs('register.form'))
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold" href="{{ route('register.form') }}">
                                        Registrarse
                                    </a>
                                </li>
                            @endif
                        @endguest
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Lista de Deseos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">
                            <i class="bi bi-cart3" style="font-size: 1.4rem;"></i>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>