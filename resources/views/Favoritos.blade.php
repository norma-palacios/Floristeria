@extends('layouts.app')

@section('title', 'Lista de Deseos')

@section('content')

<style>
    .wishlist-header {
        background-color: #58167d; color: white; padding: 15px;
        border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;
    }
    .wishlist-container {
        background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-height: 400px;
    }
    .wishlist-item {
        display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; gap: 15px;
    }
    .wishlist-img {
        width: 80px; height: 80px; object-fit: cover; border-radius: 4px; background-color: #f0f0f0;
    }
    .wishlist-title { font-weight: bold; font-size: 1rem; margin-bottom: 0; }
    .btn-purple { background-color: #58167d; color: white; border: none; padding: 5px 15px; border-radius: 4px; }
    .btn-purple:hover { background-color: #4a126b; color: white; }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">
        
        {{-- Mensajes de feedback --}}
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info mb-3">{{ session('info') }}</div>
        @endif

        <div class="wishlist-container">
            <div class="wishlist-header">
                <span class="fw-bold fs-5"><i class="bi bi-heart-fill me-2"></i> LISTA DE DESEOS</span>
            </div>

            @forelse($favoritos as $producto)
                <div class="wishlist-item">
                    <!-- Imagen -->
                    <img src="{{ $producto->imagen }}" class="wishlist-img" alt="{{ $producto->nombre }}" 
                         onerror="this.src='https://placehold.co/100x100?text=Foto'">
                    
                    <div class="flex-grow-1">
                        <h5 class="wishlist-title">{{ $producto->nombre }}</h5>
                        <div class="text-muted small">Precio: ${{ number_format($producto->precio, 2) }}</div>
                    </div>

                    <!-- Botón Agregar al Carrito (AHORA FUNCIONAL) -->
                    <form action="{{ route('carrito.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <button type="submit" class="btn btn-purple">Agregar al Carrito</button>
                    </form>

                    <!-- Botón Eliminar -->
                    <form action="{{ route('wishlist.destroy', $producto->fav_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-secondary p-0 ms-2" title="Eliminar">
                            <i class="bi bi-trash3" style="font-size: 1.2rem;"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="p-5 text-center text-muted">
                    <h4><i class="bi bi-heart-break display-4"></i></h4>
                    <p>Tu lista de deseos está vacía.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection