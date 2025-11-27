@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')

<!-- Fondo completo con imagen -->
<div class="container-fluid py-5" 
     style="background-image: url('https://i.imgur.com/yrtTqGm.jpeg'); 
            background-size: cover; background-position: center;">

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <!-- Caja central estilo morado --> 
            <div class="p-4 rounded-4 shadow"
                 style="background: linear-gradient(to bottom right, #A635C7, #7A1EA1, #5A0F84); 
                        opacity: 0.95;">

                <h2 class="text-center text-white fw-bold">Bienvenido</h2>
                <p class="text-center text-white mb-4">Ingrese su usuario y contraseña</p>

                <!-- TARJETA BLANCA -->
                <div class="bg-white p-4 rounded-4">

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <label class="fw-bold">Usuario</label>
                        <input type="text" name="correo" class="form-control mb-3" placeholder="Usuario" required>

                        <label class="fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control mb-3" placeholder="********" required>

                            <!-- BOTONES -->
                        <div class="text-center">
                            <button type="submit"
                                class="btn fw-bold px-4 mb-2"
                                style="background:#E6D8FF; color:#4B008E; border-radius:20px; width:60%;">
                                Iniciar Sesión
                            </button>

                            <a href="{{ route('register.form') }}"
                                class="btn fw-bold px-4"
                                style="background:#E6D8FF; color:#4B008E; border-radius:20px; width:60%;">
                                Registrarse
                            </a>
                        </div>
                        @if (session('error_general'))
                            <div class="alert alert-danger mt-4">
                                {{ session('error_general') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection