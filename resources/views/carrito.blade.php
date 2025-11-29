@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')

<style>
    /* Estilos específicos para igualar el mockup */
    .cart-header {
        background-color: #58167d; /* Morado oscuro del header */
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .cart-item-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .cart-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #eee;
    }

    .item-details {
        flex-grow: 1;
    }

    .item-title {
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .item-price {
        color: #666;
        font-size: 0.95rem;
    }

    /* Botón de Cantidad estilo Mockup */
    .qty-selector {
        background-color: #58167d;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 0.9rem;
        min-width: 110px;
        justify-content: space-between;
    }
    
    .action-icons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-left: 15px;
    }
    
    .icon-btn {
        background: none;
        border: none;
        font-size: 1.4rem;
        color: #6A1B9A;
        padding: 0;
        transition: transform 0.2s;
    }
    .icon-btn:hover { transform: scale(1.1); }

    /* Sección Resumen (Derecha) */
    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .summary-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .summary-divider {
        border-top: 2px solid #6A1B9A; /* Línea morada del diseño */
        margin: 20px 0;
        opacity: 0.3;
    }

    .summary-total {
        font-weight: bold;
        font-size: 1.1rem;
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .btn-pay {
        background-color: #58167d;
        color: white;
        border-radius: 8px;
        font-weight: bold;
    }
    .btn-pay:hover { background-color: #4a126b; color: white; }

    .btn-cancel {
        background-color: transparent;
        border: 1px solid #ccc;
        color: #333;
        border-radius: 8px;
        font-weight: bold;
    }
    .btn-cancel:hover { background-color: #f8f9fa; }

</style>

<div class="row">
    
    <!-- COLUMNA IZQUIERDA: PRODUCTOS -->
    <div class="col-lg-8">
        
        <!-- Header Morado -->
        <div class="cart-header">
            <a href="{{ url('/') }}" class="text-white text-decoration-none">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <span class="fs-5 text-uppercase">Carrito de Compras</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($items->isEmpty())
            <div class="text-center py-5 bg-white rounded">
                <h4>Tu carrito está vacío</h4>
                <a href="{{ url('/') }}" class="btn btn-link">Ir a comprar</a>
            </div>
        @else
            @foreach($items as $item)
                <div class="cart-item-card">
                    
                    <!-- Imagen -->
                    <img src="{{ $item->imagen }}" class="cart-img" alt="Producto"
                         onerror="this.src='https://placehold.co/100x100?text=Foto'">

                    <!-- Info -->
                    <div class="item-details">
                        <div class="item-title">{{ $item->nombre }}</div>
                        <div class="item-price">Precio: ${{ number_format($item->precio, 2) }}</div>
                    </div>

                    <!-- Selector Cantidad FUNCIONAL -->
                    <div class="dropdown">
                        <button class="qty-selector dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Cant: {{ $item->cantidad }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><h6 class="dropdown-header">Cambiar cantidad</h6></li>
                            @for($i=1; $i<=10; $i++)
                                <li>
                                    <!-- Formulario PUT para actualizar cantidad -->
                                    <form action="{{ route('carrito.update', $item->carrito_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cantidad" value="{{ $i }}">
                                        <button type="submit" class="dropdown-item {{ $item->cantidad == $i ? 'active' : '' }}">
                                            {{ $i }} unidad(es)
                                        </button>
                                    </form>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <!-- Iconos de Acción -->
                    <div class="action-icons">
                        <!-- Botón Favoritos -->
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $item->producto_id }}">
                            <button class="icon-btn" title="Guardar para después">
                                <i class="bi bi-heart"></i>
                            </button>
                        </form>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('carrito.destroy', $item->carrito_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="icon-btn" title="Eliminar del carrito">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        @endif

    </div>

    <!-- COLUMNA DERECHA: RESUMEN -->
    <div class="col-lg-4">
        <div class="summary-card">
            <h5 class="summary-title">Compras</h5>

            <!-- Lista resumen -->
            @foreach($items as $item)
                <div class="summary-item">
                    <span class="text-muted text-truncate" style="max-width: 150px;">
                        {{ $item->nombre }}
                    </span>
                    <span class="fw-bold">{{ $item->cantidad }}</span>
                </div>
                <div class="summary-item mt-0 pt-0">
                    <small class="text-muted w-100 text-end">
                        Precio: ${{ number_format($item->precio * $item->cantidad, 2) }}
                    </small>
                </div>
            @endforeach

            <!-- Totales -->
            <div class="summary-divider"></div>

            <div class="summary-item">
                <span>Subtotal:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            
            <div class="summary-total">
                <span>Total:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>

            <!-- Botones -->
            <div class="d-flex gap-2 mt-4">
                <a href="{{ url('/') }}" class="btn btn-cancel flex-grow-1 py-2 text-decoration-none text-center">Cancelar</a>
                <form action="{{ route('pago.index') }}" class="flex-grow-1"  method="get">
                    <button class="btn btn-pay py-2 w-100">Pagar</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection