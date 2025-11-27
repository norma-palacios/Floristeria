@extends('layouts.app')

@section('title', 'Pantalla inicial')

@section('content')

<style>
    .producto-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        transition: 0.3s;
    }
    .producto-card img {
        border-radius: 12px;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .producto-card:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-purple {
        background-color: #6A1B9A;
        color: white;
        border-radius: 10px;
    }
    .btn-purple:hover {
        background-color: #4B0F6B;
        color: white;
    }
    .heart-icon {
        font-size: 24px;
        color: #6A1B9A;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-4 mt-4">

    {{-- SI NO HAY PRODUCTOS, MOSTRAR EMPTY STATE --}}
    @if($productos->isEmpty())
        <div class="text-center mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="150">
            <h3 class="mt-3 text-muted">No hay productos disponibles</h3>
            <p class="text-muted">Agrega productos desde el panel de administración.</p>
        </div>
    @else

        <div class="row justify-content-center">

            @foreach ($productos as $producto)
            <div class="col-md-2 col-6 mb-4">
                <div class="producto-card">

                    {{-- Badge opcional si quieres manejar ofertas --}}
                    @if($producto->cantidad > 0)
                        <span class="badge bg-warning text-dark">¡Disponible!</span>
                    @endif

                    {{-- Imagen del producto --}}
                    <img src="{{ $producto->imagen }}"   class="w-100 rounded object-fit-cover mt-1"
     style="height: 200px;" alt="{{ $producto->nombre }}">

                    {{-- Nombre y precio --}}
                    <p class="mt-2 fw-bold">
                        {{ $producto->nombre }}<br>
                        ${{ number_format($producto->precio, 2) }}
                    </p>

                    {{-- Botón --}}
                    <button class="btn btn-purple w-100 mb-2">Añadir</button>

                    <div class="heart-icon">♡</div>
                </div>
            </div>
            @endforeach

        </div>

    @endif

</div>

@endsection
