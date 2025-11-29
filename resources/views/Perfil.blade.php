@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')

<style>
    /* --- Estilos de la Tarjeta --- */
    .profile-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    /* Encabezado Morado */
    .profile-header {
        background-color: #58167d;
        color: white;
        padding: 15px 20px;
        font-weight: bold;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Secciones Internas */
    .profile-section {
        padding: 25px;
        border-bottom: 1px solid #eee;
    }
    .profile-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #333;
    }

    /* --- Estilos de Dirección --- */
    .address-item {
        margin-bottom: 20px;
        border-bottom: 1px dashed #eee;
        padding-bottom: 15px;
    }
    .address-item:last-child {
        border-bottom: none;
    }
    .address-label {
        font-weight: bold;
        color: #333;
        font-size: 1rem;
    }
    .address-text {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 5px;
    }

    /* --- Botones de Acción --- */
    .action-btn {
        font-size: 0.85rem;
        font-weight: bold;
        text-decoration: underline;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
        margin-right: 15px;
    }
    .text-vino { color: #800040; } /* Eliminar */
    .text-gris { color: #666; }    /* Editar */

    .btn-add-address {
        color: #6A1B9A;
        font-weight: bold;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-add-address:hover {
        color: #4a126b;
        text-decoration: underline;
    }

    /* --- Modales --- */
    .modal-header-custom {
        background-color: #58167d;
        color: white;
    }
    .btn-save-custom {
        background-color: #58167d;
        color: white;
        font-weight: bold;
    }
    .btn-save-custom:hover {
        background-color: #4a126b;
        color: white;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <i class="bi bi-person-fill" style="font-size: 1.3rem;"></i> 
                {{ $user->nombre }}
            </div>

            <!-- 1. Datos Usuario -->
            <div class="profile-section">
                <h4 class="section-title">Usuario</h4>
                <div class="mb-1 fw-bold">{{ $user->nombre }}</div>
                <div class="text-muted">{{ $user->correo }}</div>
            </div>

            <!-- 2. Ordenes -->
            <div class="profile-section">
                <h4 class="section-title">Mis Ordenes</h4>
                @forelse($ordenes as $orden)
                    <div class="py-2 d-flex justify-content-start">
                        <span>Orden #{{ $orden->id }} -</span>
                        <span>
                           - Total: $ {{$orden->total}} - 
                        </span>
                        <span class="fw-bold {{ $orden->estado == 'entregado' ? 'text-success' : 'text-primary' }}">
                            - {{ ucfirst($orden->estado) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted small">No tienes órdenes recientes.</p>
                @endforelse
            </div>

            <!-- 3. Direcciones -->
            <div class="profile-section">
                <h4 class="section-title">Mis Direcciones</h4>

                @forelse($direcciones as $direccion)
                    <div class="address-item">
                        <div class="address-label">
                            {{ $direccion->indicaciones ? $direccion->indicaciones : 'Dirección' }}:
                        </div>
                        <div class="address-text">
                            {{ $direccion->direccion }}, {{ $direccion->ciudad }}, {{ $direccion->departamento }}
                        </div>

                        <div class="d-flex mt-2">
                            <!-- Botón Eliminar -->
                            <form action="{{ route('address.destroy', $direccion->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn text-vino">Eliminar</button>
                            </form>
                            
                            <!-- Botón Editar (Trigger Modal) -->
                            <button type="button" class="action-btn text-gris" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditarDireccion"
                                    data-id="{{ $direccion->id }}"
                                    data-etiqueta="{{ $direccion->indicaciones }}"
                                    data-direccion="{{ $direccion->direccion }}"
                                    data-ciudad="{{ $direccion->ciudad }}"
                                    data-depto="{{ $direccion->departamento }}">
                                Editar
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small">No tienes direcciones registradas.</p>
                @endforelse

                <div class="mt-2">
                    <a href="#" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#modalCrearDireccion">
                        Agregar Nueva Direccion
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: CREAR -->
<div class="modal fade" id="modalCrearDireccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold">Agregar Nueva Direccion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <!-- Campos -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Etiqueta</label>
                        <input type="text" name="etiqueta" class="form-control" placeholder="Ej: Casa, Oficina">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Calle</label>
                        <input type="text" name="calle" class="form-control" required placeholder="Calle principal">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Número/Depto</label>
                        <input type="text" name="numero_casa" class="form-control" placeholder="#123">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Departamento</label>
                        <select name="departamento" class="form-select">
                            <option value="San Salvador">San Salvador</option>
                            <option value="La Libertad">La Libertad</option>
                            <option value="Santa Ana">Santa Ana</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Municipio</label>
                        <select name="municipio" class="form-select">
                            <option value="San Salvador">San Salvador</option>
                            <option value="Soyapango">Soyapango</option>
                            <option value="Santa Tecla">Santa Tecla</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-save-custom flex-grow-1">Guardar</button>
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: EDITAR -->
<div class="modal fade" id="modalEditarDireccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold">Editar Direccion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarDireccion" method="POST">
                    @csrf
                    @method('PUT') 

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Etiqueta</label>
                        <input type="text" name="etiqueta" id="edit_etiqueta" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Dirección Completa</label>
                        <input type="text" name="direccion" id="edit_direccion" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Departamento</label>
                        <select name="departamento" id="edit_departamento" class="form-select">
                            <option value="San Salvador">San Salvador</option>
                            <option value="La Libertad">La Libertad</option>
                            <option value="Santa Ana">Santa Ana</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Municipio</label>
                        <select name="municipio" id="edit_ciudad" class="form-select">
                            <option value="San Salvador">San Salvador</option>
                            <option value="Soyapango">Soyapango</option>
                            <option value="Santa Tecla">Santa Tecla</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-save-custom flex-grow-1">Actualizar</button>
                        <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para rellenar el modal de edición -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalEditar = document.getElementById('modalEditarDireccion');
        
        modalEditar.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var etiqueta = button.getAttribute('data-etiqueta');
            var direccion = button.getAttribute('data-direccion');
            var ciudad = button.getAttribute('data-ciudad');
            var depto = button.getAttribute('data-depto');

            var form = document.getElementById('formEditarDireccion');
            form.action = '/direcciones/' + id;

            document.getElementById('edit_etiqueta').value = etiqueta;
            document.getElementById('edit_direccion').value = direccion;
            document.getElementById('edit_departamento').value = depto; 
            document.getElementById('edit_ciudad').value = ciudad;
        });
    });
</script>

@endsection