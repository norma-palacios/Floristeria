@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<style>
    /* --- Estilos Mejorados para Cards --- */
    .producto-card {
        background: white;
        border-radius: 12px;
        padding: 10px;
        text-align: center;
        transition: 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    
    .producto-card img {
        border-radius: 8px;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .producto-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(106, 27, 154, 0.1);
        border-color: #e0e0e0;
    }

    /* Tipografía ajustada */
    .card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #333;
        margin-top: 10px;
        margin-bottom: 2px;
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis; 
    }
    
    .card-price {
        font-size: 1.1rem;
        color: #6A1B9A;
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* Botones compactos */
    .btn-purple {
        background-color: #6A1B9A;
        color: white;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: background-color 0.2s;
        padding: 6px 0;
    }
    .btn-purple:hover {
        background-color: #4B0F6B;
        color: white;
    }

    .heart-btn {
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        transition: transform 0.2s;
        padding: 0;
        margin-top: 5px;
    }
    .heart-btn:hover { transform: scale(1.1); }
    .heart-filled { color: #E91E63; }
    .heart-empty { color: #6A1B9A; }

    /* Estilos Buscador */
    .search-container {
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        margin-bottom: 25px;
        border: 1px solid #f8f8f8;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6A1B9A;
        box-shadow: 0 0 0 0.2rem rgba(106, 27, 154, 0.15);
    }
    .badge-category {
        background-color: #f3e5f5;
        color: #6A1B9A;
        font-size: 0.65rem;
        padding: 3px 6px;
        border-radius: 4px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
</style>

<div class="container-fluid px-3 mt-3">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BARRA DE BÚSQUEDA Y FILTROS --}}
    <div class="search-container">
        <form action="{{ url('/') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" 
                               placeholder="Buscar flores..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-5">
                    <select name="categoria" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="todas">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-purple btn-sm w-100">Buscar</button>
                </div>
            </div>
            
            @if(request('search') || (request('categoria') && request('categoria') != 'todas'))
                <div class="mt-2 text-end">
                    <a href="{{ url('/') }}" class="text-muted small text-decoration-none" style="font-size: 0.8rem;">
                        <i class="bi bi-x-circle"></i> Limpiar filtros
                    </a>
                </div>
            @endif
        </form>
    </div>

    {{-- LISTADO DE PRODUCTOS --}}
    @if($productos->isEmpty())
        <div class="text-center mt-5 py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" class="mb-3 opacity-50">
            <h4 class="text-muted fs-5">No se encontraron productos</h4>
            <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary mt-2">Ver todo</a>
        </div>
    @else
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
            @foreach ($productos as $producto)
            <div class="col">
                <div class="producto-card">
                    
                    {{-- Header Card --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            @if($producto->categoria)
                                <span class="badge-category">{{ substr($producto->categoria, 0, 10) }}</span>
                            @else
                                <span></span>
                            @endif

                            @if($producto->cantidad > 0)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-1" style="font-size: 0.6rem;">
                                    Disponible
                                </span>
                            @endif
                        </div>

                        {{-- Imagen --}}
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" 
                             onerror="this.src='https://placehold.co/150x150?text=Foto'">

                        {{-- Info --}}
                        <h6 class="card-title" title="{{ $producto->nombre }}">{{ $producto->nombre }}</h6>
                        <div class="card-price">
                            ${{ number_format($producto->precio, 2) }}
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div>
                        <form action="{{ route('carrito.add') }}" method="POST" class="mb-1">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            
                            @auth
                                <button type="submit" class="btn btn-purple w-100">
                                    <i class="bi bi-cart-plus"></i> Añadir
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-purple w-100">
                                    <i class="bi bi-cart-plus"></i> Añadir
                                </a>
                            @endauth
                        </form>

                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            <div class="d-flex justify-content-center">
                                @auth
                                    <button type="submit" class="heart-btn {{ in_array($producto->id, $favoritosIds ?? []) ? 'heart-filled' : 'heart-empty' }}" title="Favoritos">
                                        <i class="bi {{ in_array($producto->id, $favoritosIds ?? []) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="heart-btn heart-empty">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endauth
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

    @endif

</div>

@endsection