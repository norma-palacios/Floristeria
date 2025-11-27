@extends('layouts.admin')

@section('title', isset($producto) ? 'Editar Producto - Admin' : 'Agregar Producto - Admin')

@section('content')
<!-- SIDEBAR DERECHO FIJO -->
<div class="admin-sidebar">
    <!-- TOP SECTION -->
    <div>
        <!-- Home Title -->
        <h2 class="text-white text-center fw-bold mb-4" style="font-size: 28px;">Home</h2>
        
        <!-- Usuario -->
        <div class="d-flex align-items-center mb-4 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
            <img src="{{ asset('img/icon_user.png') }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
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
        <a href="{{ route('admin.productos') }}" style="color: white; font-size: 24px; text-decoration: none;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold text-center flex-grow-1" style="margin: 0;">{{ isset($producto) ? 'Editar producto' : 'Añadir producto' }}</h2>
    </div>

    <!-- FORMULARIO AGREGAR/EDITAR PRODUCTO -->
    <div style="background: white; border-radius: 12px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <form action="{{ isset($producto) ? route('admin.productos.actualizar', $producto) : route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($producto))
                @method('PUT')
            @endif

            <div class="row">
                <!-- COLUMNA IZQUIERDA - IMAGEN -->
                <div class="col-md-4 text-center mb-4">
                    <div style="background: #E8E8E8; border-radius: 12px; padding: 40px; min-height: 350px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                        <img id="previewImagen" src="{{ isset($producto) && $producto->imagen ? asset($producto->imagen) : 'https://via.placeholder.com/200x250' }}" alt="Preview" style="max-width: 100%; max-height: 250px; border-radius: 8px; margin-bottom: 20px; object-fit: cover;">
                        
                        <!-- BOTONES ACCIONES -->
                        <div class="d-flex gap-2 justify-content-center">
                            <label class="btn fw-bold" style="background: #5A1E8F; color: white; cursor: pointer; margin-bottom: 0; border-radius: 6px; padding: 8px 16px;">
                                Subir
                                <input type="file" name="imagen" id="imagenInput" style="display: none;" accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA - FORMULARIO -->
                <div class="col-md-8">
                    <!-- NOMBRE DEL PRODUCTO -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #5A1E8F;">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ramo Adali" value="{{ old('nombre', $producto->nombre ?? '') }}" required style="border: 1px solid #DDD; border-radius: 6px; padding: 10px; font-size: 14px;">
                        @error('nombre')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #5A1E8F;">Descripcion</label>
                        <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="4" placeholder="Hermoso Ramo floral de 5 gerberas..." required style="border: 1px solid #DDD; border-radius: 6px; padding: 10px; font-size: 14px; resize: vertical;">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- PRECIO -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #5A1E8F;">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: white; border: 1px solid #DDD; border-radius: 6px 0 0 6px;">$</span>
                            <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="0.00" step="0.01" min="0" value="{{ old('precio', $producto->precio ?? '') }}" required style="border: 1px solid #DDD; border-radius: 0 6px 6px 0; padding: 10px; font-size: 14px;">
                            @error('precio')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- CATEGORIA O TIPO DE OCASION -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #5A1E8F;">Categoría o tipo de ocasión</label>
                        <input type="text" name="categoria" class="form-control @error('categoria') is-invalid @enderror" placeholder="cumpleaños, boda, san valentín, aniversario, funeral, sin ocasión especial" value="{{ old('categoria', $producto->categoria ?? '') }}" style="border: 1px solid #DDD; border-radius: 6px; padding: 10px; font-size: 14px;">
                        @error('categoria')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- BOTONES DE ACCION -->
                    <div class="d-flex gap-3 mt-5">
                        <button type="submit" class="btn fw-bold" style="background: #5A1E8F; color: white; padding: 12px 40px; border-radius: 6px; border: none; flex: 1;">
                            {{ isset($producto) ? 'Actualizar' : 'Añadir' }}
                        </button>
                        <a href="{{ route('admin.productos') }}" class="btn fw-bold" style="background: #E0E0E0; color: #333; padding: 12px 40px; border-radius: 6px; border: none; text-decoration: none; text-align: center; flex: 1;">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- BRAND NAME -->
    <div class="mt-5">
        <p style="font-style: italic; color: #666; font-size: 16px;">Dinamita flowersshop</p>
    </div>
</div>

<script>
    // Manejar cambio de imagen
    document.getElementById('imagenInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImagen').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
