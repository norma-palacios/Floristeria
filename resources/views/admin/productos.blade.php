@extends('layouts.admin')

@section('title', 'Lista de Productos - Admin')

@section('content')
<!-- SIDEBAR DERECHO FIJO -->
<div class="admin-sidebar">
    <!-- TOP SECTION -->
    <div>
        <!-- Home Title -->
        <h2 class="text-white text-center fw-bold mb-4" style="font-size: 28px;">Home</h2>
        
        <!-- Usuario -->
        <div class="d-flex align-items-center mb-4 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" style="width: 40px; height: 40px;">
            <span class="text-white fw-bold">{{ auth()->user()->nombre }}</span>
        </div>
        
        <!-- Menu Items -->
        <a href="{{ route('admin.pedidos') }}" class="d-block text-decoration-none text-white p-3 mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <span class="fw-bold">Pedidos</span>
        </a>
        
        <a href="{{ route('admin.productos') }}" class="d-block text-decoration-none text-white p-3 fw-bold mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.15); border-radius: 4px;">
            <span>Productos</span>
        </a>
    </div>
    
    <!-- LOGOUT BUTTON -->
    <div>
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn fw-bold w-100" style="background: #D4A5FF; color: #4B008E; border-radius: 20px; border: none;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="admin-content">
    <!-- HEADER CON BACK BUTTON -->
    <div class="d-flex align-items-center mb-4" style="background: #5A1E8F; padding: 15px 20px; border-radius: 12px; color: white;">
        <a href="{{ route('admin.dashboard') }}" style="color: white; font-size: 24px; margin-right: 15px; text-decoration: none;">
            ←
        </a>
        <h2 class="fw-bold" style="margin: 0;">Listado de productos</h2>
    </div>

    <!-- LISTA DE PRODUCTOS -->
    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        @if($productos->count() > 0)
            @foreach($productos->take(10) as $producto)
                <div class="d-flex align-items-center mb-4 p-4" style="background: #F9F9F9; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                    <!-- IMAGEN PRODUCTO -->
                    <div style="width: 80px; height: 80px; background: white; border-radius: 8px; margin-right: 20px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($producto->imagen)
                            <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/80" alt="Placeholder" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    
                    <!-- INFO PRODUCTO -->
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="color: #333; font-size: 16px;">{{ $producto->nombre }}</h5>
                        <p class="mb-0" style="color: #666; font-size: 14px;">Precio: ${{ number_format($producto->precio, 2) }}</p>
                    </div>
                    
                    <!-- BOTÓN ELIMINAR -->
                    <form action="{{ route('admin.productos.eliminar', $producto->id) }}" method="POST" style="margin-left: 20px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" onclick="return confirm('¿Desea eliminar este producto?');">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#A635C7"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="text-center p-5" style="color: #999;">
                <p>No hay productos disponibles</p>
            </div>
        @endif

        <!-- BOTÓN AGREGAR PRODUCTO -->
        <div class="text-center mt-4">
            <a href="{{ route('admin.productos.crear') }}" class="btn fw-bold" style="background: #5A1E8F; color: white; padding: 10px 30px; border-radius: 6px; text-decoration: none;">
                Agregar producto
            </a>
        </div>
    </div>

    <!-- BRAND NAME -->
    <div class="mt-5">
        <p style="font-style: italic; color: #666; font-size: 16px;">Dinamita flowersshop</p>
    </div>
</div>

@endsection

