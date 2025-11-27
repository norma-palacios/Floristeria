@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

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
        
        <a href="{{ route('admin.productos') }}" class="d-block text-decoration-none text-white p-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <span class="fw-bold">Productos</span>
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
    <h1 class="fw-bold mb-4">Pantalla de Bienvenida</h1>
    
    <!-- CARDS -->
    <div class="row gap-4">
        <!-- Card Pedidos -->
        <div class="col-md-5">
            <a href="{{ route('admin.pedidos') }}" style="text-decoration: none;">
                <div class="rounded-4 p-4 text-white fw-bold" style="background: linear-gradient(135deg, #00BCD4, #00ACC1); min-height: 200px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.3s;">
                    <div>
                        <h3 style="font-size: 36px; margin: 0;">Pedidos</h3>
                    </div>
                    <div style="font-size: 80px;">📋</div>
                </div>
            </a>
        </div>
        
        <!-- Card Productos -->
        <div class="col-md-5">
            <a href="{{ route('admin.productos') }}" style="text-decoration: none;">
                <div class="rounded-4 p-4 text-white fw-bold" style="background: linear-gradient(135deg, #E1BEE7, #CE93D8); min-height: 200px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.3s;">
                    <div>
                        <h3 style="font-size: 36px; margin: 0;">Productos</h3>
                    </div>
                    <div style="font-size: 80px;">🌸</div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Brand Name -->
    <div class="mt-5">
        <p style="font-style: italic; color: #666; font-size: 16px;">Dinamita flowersshop</p>
    </div>
</div>

@endsection
