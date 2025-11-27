@extends('layouts.app')

@section('title', 'Registro')

@section('content')

<!-- Fondo -->
<div class="container-fluid py-5"
     style="background-image: url('https://i.imgur.com/yrtTqGm.jpeg');
            background-size: cover;
            background-position: center;">

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Caja morada -->
            <div class="p-4 rounded-4 shadow"
                 style="background: linear-gradient(to bottom right, #A635C7, #7A1EA1, #5A0F84);
                        opacity: 0.95;">

                <h2 class="text-center text-white fw-bold">Crear Cuenta</h2>
                <p class="text-center text-white mb-4">Complete sus datos para registrarse</p>

                <!-- Card blanca -->
                <div class="bg-white p-4 rounded-4 mb-3">

                    <form action="{{ route('register.save') }}" method="POST">
                        @csrf

                        <label class="fw-bold">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control mb-3" required>

                        <label class="fw-bold">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control mb-3" required>

                        <label class="fw-bold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control mb-3" required>

                        <label class="fw-bold">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control mb-3" required>

                        <label class="fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control mb-3" required>

                        <label class="fw-bold">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control mb-3" required>

                        <!-- Botón de crear cuenta -->
                        <div class="text-center mt-3">
                            <button type="submit"
                                class="btn fw-bold px-4"
                                style="background:#E6D8FF; color:#4B008E;
                                       border-radius:20px; width:70%;">
                                Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Link de iniciar sesión -->
                <div class="text-center">
                    <a href="{{ route('login') }}"
                       class="fw-bold text-white text-decoration-underline">
                        ¿Ya tienes una cuenta? Inicia sesión
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
