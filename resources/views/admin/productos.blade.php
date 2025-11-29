@extends('layouts.admin')

@section('title', 'Lista de Productos - Admin')

@section('content')
<div class="admin-sidebar">
    <div>
        <h2 class="text-white text-center fw-bold mb-4" style="font-size: 28px;">Home</h2>
        
        <div class="d-flex align-items-center mb-4 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
            <img src="{{ asset('img/icon_user.png') }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
            <span class="text-white fw-bold">{{ auth()->user()->nombre }}</span>
        </div>
        
        <a href="{{ route('admin.pedidos') }}" class="d-block text-decoration-none text-white p-3 mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <span class="fw-bold">Pedidos</span>
        </a>
        
        <a href="{{ route('admin.productos') }}" class="d-block text-decoration-none text-white p-3 fw-bold mb-2" style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.15); border-radius: 4px;">
            <span>Productos</span>
        </a>
    </div>
    
    <div>
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn fw-bold w-100" style="background: #D4A5FF; color: #4B008E; border-radius: 20px; border: none;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<div class="admin-content">
    <div class="d-flex align-items-center mb-4" style="background: #5A1E8F; padding: 15px 20px; border-radius: 12px; color: white;">
        <a href="{{ route('admin.dashboard') }}" style="color: white; font-size: 24px; text-decoration: none;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold text-center flex-grow-1" style="margin: 0;">Listado de productos</h2>
    </div>

    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        
        <div class="d-flex justify-content-end mb-4">
            <form action="{{ route('admin.productos') }}" method="GET" class="d-flex align-items-center gap-2">
                <label class="fw-bold mb-0" style="color: #666; font-size: 14px;">Filtrar:</label>
                <select name="categoria" class="form-select" style="width: auto; min-width: 180px; border: 1px solid #DDD; font-size: 14px; padding: 8px; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($productos->count() > 0)
            @foreach($productos as $producto)
                <div class="d-flex align-items-center mb-4 p-4" style="background: #F9F9F9; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                    <div style="width: 80px; height: 80px; background: white; border-radius: 8px; margin-right: 20px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($producto->imagen)
                            <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/80" alt="Placeholder" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="color: #333; font-size: 16px;">{{ $producto->nombre }}</h5>
                        <p class="mb-1" style="color: #666; font-size: 14px;">Precio: ${{ number_format($producto->precio, 2) }}</p>
                        
                        <div class="d-flex gap-3">
                            <small style="color: #5A1E8F; font-weight: 500;">
                                <i class="bi bi-tag-fill me-1"></i>{{ $producto->categoria ?? 'Sin categoría' }}
                            </small>
                            <small style="{{ $producto->cantidad < 10 ? 'color: #D32F2F; font-weight: bold;' : 'color: #2E7D32; font-weight: 500;' }}">
                                <i class="bi bi-box-seam me-1"></i>Stock: {{ $producto->cantidad }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <a href="{{ route('admin.productos.editar', $producto->id) }}" class="text-decoration-none" style="margin-right: 15px;">
                            <i class="bi bi-pencil-fill" style="color: #5A1E8F; font-size: 20px;"></i>
                        </a>
                        <form action="{{ route('admin.productos.eliminar', $producto->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" onclick="return confirm('¿Desea eliminar este producto?');">
                                <i class="bi bi-trash-fill" style="color: #5A1E8F; font-size: 20px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center p-5" style="color: #999;">
                <p>No hay productos disponibles en esta categoría.</p>
                @if(request('categoria'))
                    <a href="{{ route('admin.productos') }}" class="btn btn-sm btn-outline-secondary mt-2">Ver todos</a>
                @endif
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('admin.productos.crear') }}" class="btn fw-bold" style="background: #5A1E8F; color: white; padding: 10px 30px; border-radius: 6px; text-decoration: none;">
                Agregar producto
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->appends(request()->query())->links('vendor.pagination.custom-purple') }}
    </div>

    <div class="mt-5">
        <p style="font-style: italic; color: #666; font-size: 16px;">Dinamita flowersshop</p>
    </div>
</div>

@endsection