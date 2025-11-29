<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Floristería</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #F8D7E3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background-color: #6A1B9A;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: #fff !important;
            transition: opacity 0.2s;
        }

        .navbar-custom .nav-link:hover {
            opacity: 0.8;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .badge-notification {
            font-size: 0.7rem;
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(25%, -25%);
        }

        /* Contenedor principal que empuja el footer si lo hubiera */
        .main-content {
            flex: 1;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top">
        <div class="container">

            <!-- Marca -->
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                <i class="bi bi-flower1 me-2"></i>Dinamita Flowers
            </a>

            <!-- Botón móvil -->
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <i class="bi bi-list fs-2"></i>
            </button>

            <!-- Items -->
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="{{ url('/') }}">Inicio</a>
                    </li>

                    @guest
                        <!-- OPCIONES PARA INVITADOS -->
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="{{ route('login') }}">
                                Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold px-3" href="{{ route('register.form') }}">
                                Registrarse
                            </a>
                        </li>
                    @else
                        <!-- OPCIONES PARA USUARIOS LOGUEADOS -->
                        
                        <!-- 1. Lista de Deseos -->
                        <li class="nav-item">
                            <a class="nav-link px-3" href="{{ route('wishlist.index') }}" title="Mis Favoritos">
                                <i class="bi bi-heart-fill me-1"></i> Favoritos
                            </a>
                        </li>

                        <!-- 2. Carrito de Compras -->
                        <li class="nav-item position-relative me-3">
                            <a class="nav-link px-3" href="{{ route('carrito.index') }}">
                                <i class="bi bi-cart3 fs-5"></i>
                                <!-- Badge opcional si quisieras mostrar conteo -->
                                {{-- <span class="badge rounded-pill bg-danger badge-notification">2</span> --}}
                            </a>
                        </li>

                        <!-- 3. Menú de Perfil (Dropdown) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-white text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                    <i class="bi bi-person-fill" style="color: #6A1B9A;"></i>
                                </div>
                                <span class="fw-semibold d-none d-lg-block">{{ Auth::user()->nombre }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
                                        <i class="bi bi-person-gear me-2 text-secondary"></i> Mi Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <!-- Botón de Cerrar Sesión -->
                                    <form action="{{ route('logout') }}" method="GET">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                </ul>
            </div>

        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="main-content container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>