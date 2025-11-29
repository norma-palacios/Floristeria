@extends('layouts.admin')

@section('title', 'Lista de Pedidos - Admin')

@section('content')
<div class="admin-sidebar">
    <div>
        <h2 class="text-white text-center fw-bold mb-4" style="font-size: 28px;">Home</h2>
        
        <div class="d-flex align-items-center mb-4 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
            <img src="{{ asset('img/icon_user.png') }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
            <span class="text-white fw-bold">{{ auth()->user()->nombre }}</span>
        </div>
        
        <a href="{{ route('admin.pedidos') }}" class="d-block text-decoration-none text-white p-3 mb-2 fw-bold" style="border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.15); border-radius: 4px;">
            <span>Pedidos</span>
        </a>
        
        <a href="{{ route('admin.productos') }}" class="d-block text-decoration-none text-white p-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <span class="fw-bold">Productos</span>
        </a>
    </div>
    
    <div>
        <form action="{{ route('logout') }}" method="GET" class="w-100">
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
            <h2 class="fw-bold text-center flex-grow-1" style="margin: 0;">Listado de Pedidos</h2>
        </div>

        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @if($pedidos->count() > 0)
                @foreach($pedidos as $pedido)
                    <div class="d-flex align-items-center mb-3 p-3" style="background: #F9F5FF; border-radius: 10px; border-left: 4px solid #A635C7;">
                        <div style="width: 50px; height: 50px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class="bi bi-box2-heart-fill" style="color: #A635C7; font-size: 24px;"></i>
                        </div>
                        
                        <div class="flex-grow-1">
                            <p class="fw-bold mb-1" style="color: #333;">
                                <i class="bi bi-person-fill me-1" style="color: #A635C7;"></i>{{ $pedido->nombre_cliente }}
                            </p>
                            
                            <p class="mb-1" style="color: #666; font-size: 14px;">
                                <i class="bi bi-geo-alt-fill me-1" style="color: #A635C7;"></i>
                                {{ $pedido->direccion }} 
                                <small class="text-muted">({{ $pedido->ciudad }}, {{ $pedido->departamento }})</small>
                            </p>

                            <div class="d-flex gap-3">
                                <p class="mb-0" style="color: #444; font-size: 14px; font-weight: 600;">
                                    Total: ${{ number_format($pedido->total, 2) }}
                                </p>
                                <p class="mb-0" style="color: #888; font-size: 12px; align-self: center;">
                                    ID: #{{ $pedido->id }}
                                </p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.pedidos.actualizar', $pedido->id) }}" method="POST" style="margin-left: 20px;">
                            @csrf
                            @method('PATCH') 
                            <select name="estado" 
                                    class="form-select" 
                                    style="min-width: 140px; border: 1px solid #A635C7; background: white; border-radius: 6px; padding: 8px 12px; cursor: pointer;"
                                    onchange="this.form.submit()">
                                
                                <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>
                                    En Progreso
                                </option>

                                <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>
                                    Enviado
                                </option>

                                <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>
                                    Completado
                                </option>

                                <option value="cancelado" {{ $pedido->estado === 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>

                            </select>
                        </form>
                    </div>
                @endforeach
            @else
                <div class="text-center p-5" style="color: #999;">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p>No hay pedidos disponibles</p>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $pedidos->links('vendor.pagination.custom-purple') }}
        </div>

        <div class="mt-5 text-center">
            <p style="font-style: italic; color: #666; font-size: 16px;">Dinamita flowersshop</p>
        </div>
    </div>

@endsection