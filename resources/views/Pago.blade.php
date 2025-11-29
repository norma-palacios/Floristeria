@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')

<style>
    .checkout-header {
        background-color: #58167d;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: bold;
        display: flex; align-items: center; gap: 15px; margin-bottom: 25px;
    }
    .section-card {
        background: white; border-radius: 12px; padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 20px;
    }
    .form-label { font-weight: bold; color: #555; font-size: 0.9rem; }
    .form-control, .form-select {
        border-radius: 8px; border: 1px solid #ddd; padding: 10px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6A1B9A; box-shadow: 0 0 0 0.2rem rgba(106, 27, 154, 0.25);
    }
    
    /* Resumen */
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; }
    .summary-total { font-weight: bold; font-size: 1.2rem; border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px; display: flex; justify-content: space-between; }
    
    /* Botones */
    .btn-pay { background-color: #58167d; color: white; font-weight: bold; border-radius: 8px; width: 100%; padding: 12px; font-size: 1.1rem; border: none; }
    .btn-pay:hover { background-color: #4B0F6B; color: white; }
    .btn-cancel { background-color: transparent; border: 1px solid #ccc; color: #555; width: 100%; padding: 10px; border-radius: 8px; font-weight: bold; }
    
    /* Modal Personalizado */
    .modal-success-header { background-color: #58167d; color: white; border-bottom: none; }
    .icon-success { font-size: 4rem; color: #28a745; margin-bottom: 15px; }
</style>

<div class="row">
    
    <!-- COLUMNA IZQUIERDA: FORMULARIOS -->
    <div class="col-lg-7">
        
        <div class="checkout-header">
            <a href="{{ route('carrito.index') }}" class="text-white"><i class="bi bi-arrow-left fs-4"></i></a>
            <span class="fs-5">FINALIZAR COMPRA</span>
        </div>

        <form id="paymentForm" action="{{ route('pago.procesar') }}" method="POST">
            @csrf

            <!-- 1. Dirección de Envío -->
            <div class="section-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Dirección de Envío</h5>
                
                @if($direcciones->isEmpty())
                    <div class="alert alert-warning">
                        No tienes direcciones guardadas. 
                        <a href="{{ route('profile.index') }}" class="fw-bold">Agrega una aquí</a>.
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">Selecciona una dirección:</label>
                        <select name="direccion_id" class="form-select" required>
                            @foreach($direcciones as $dir)
                                <option value="{{ $dir->id }}">
                                    {{ $dir->indicaciones }} - {{ $dir->direccion }}, {{ $dir->ciudad }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <!-- 2. Método de Pago -->
            <div class="section-card">
                <h5 class="fw-bold mb-4"><i class="bi bi-credit-card-fill text-primary me-2"></i>Método de Pago</h5>

                <!-- Tabs simulados -->
                <div class="btn-group w-100 mb-4" role="group">
                    <input type="radio" class="btn-check" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                    <label class="btn btn-outline-primary" for="tarjeta">Tarjeta Crédito/Débito</label>

                    <input type="radio" class="btn-check" name="metodo_pago" id="paypal" value="paypal">
                    <label class="btn btn-outline-primary" for="paypal">PayPal</label>
                </div>

                <!-- Formulario Tarjeta -->
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nombre en la tarjeta</label>
                        <input type="text" class="form-control" placeholder="Como aparece en la tarjeta" required>
                    </div>
                    
                    <!-- NÚMERO DE TARJETA CON FORMATO -->
                    <div class="col-12">
                        <label class="form-label">Número de tarjeta</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-credit-card"></i></span>
                            <input type="text" name="numero_tarjeta" id="cardInput" class="form-control" 
                                   placeholder="0000 0000 0000 0000" maxlength="19" required>
                        </div>
                    </div>
                    
                    <!-- FECHA Y CVV CON FORMATO -->
                    <div class="col-md-6">
                        <label class="form-label">Fecha Expiración</label>
                        <input type="text" id="expiryInput" class="form-control" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CVC / CVV</label>
                        <input type="password" id="cvvInput" class="form-control" placeholder="123" maxlength="4" required>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="saveCard">
                            <label class="form-check-label text-muted small" for="saveCard">
                                Guardar esta tarjeta para futuras compras
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- COLUMNA DERECHA: RESUMEN -->
    <div class="col-lg-5">
        <div class="section-card bg-light">
            <h5 class="fw-bold text-center mb-4">Resumen del Pedido</h5>

            @foreach($items as $item)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $item->imagen }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <div class="small fw-bold">{{ $item->nombre }}</div>
                        <div class="text-muted small">Cant: {{ $item->cantidad }}</div>
                    </div>
                    <div class="fw-bold">${{ number_format($item->precio * $item->cantidad, 2) }}</div>
                </div>
            @endforeach

            <hr>

            <div class="summary-item">
                <span>Subtotal</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            <div class="summary-item">
                <span>Envío</span>
                <span class="text-success fw-bold">Gratis</span>
            </div>

            <div class="summary-total">
                <span>Total a Pagar</span>
                <span class="text-primary">${{ number_format($total, 2) }}</span>
            </div>

            <!-- Botón Pagar que activa el Modal -->
            <button type="button" class="btn-pay mt-4" onclick="confirmarPago()">
                PAGAR ${{ number_format($total, 2) }}
            </button>
            
            <a href="{{ route('carrito.index') }}" class="btn-cancel d-block text-center mt-2 text-decoration-none">
                Cancelar
            </a>
        </div>
    </div>

</div>

<!-- MODAL DE ÉXITO -->
<div class="modal fade" id="modalExito" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header modal-success-header justify-content-center">
                <h5 class="modal-title fw-bold">¡Pago Procesado!</h5>
            </div>
            <div class="modal-body p-5">
                <i class="bi bi-check-circle-fill icon-success"></i>
                <h3 class="fw-bold mt-3">¡Orden Exitosa!</h3>
                <p class="text-muted">Gracias por tu compra. Hemos recibido tu pedido correctamente.</p>
                
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="small text-muted mt-2">Redirigiendo a tu perfil...</p>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS DE FORMATEO Y LÓGICA -->
<script>
    // --- 1. Formateo de Tarjeta (Agrega espacios cada 4 números) ---
    document.getElementById('cardInput').addEventListener('input', function (e) {
        // Eliminar todo lo que no sea número
        let value = e.target.value.replace(/\D/g, '');
        // Agregar espacio cada 4 dígitos
        let formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = formattedValue;
    });

    // --- 2. Formateo de Fecha (Agrega la pleca / automáticamente) ---
    document.getElementById('expiryInput').addEventListener('input', function (e) {
        // Eliminar todo lo que no sea número
        let value = e.target.value.replace(/\D/g, '');
        
        // Si tiene más de 2 dígitos, agregar la pleca
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value;
    });

    // --- 3. Formateo de CVV (Solo números) ---
    document.getElementById('cvvInput').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });


    // --- 4. Lógica de Confirmación de Pago ---
    function confirmarPago() {
        const form = document.getElementById('paymentForm');
        
        if (form.checkValidity()) {
            // Mostrar modal
            var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
            myModal.show();

            // Enviar form después de 2.5s
            setTimeout(function() {
                form.submit();
            }, 2500);
        } else {
            // Mostrar errores nativos del navegador
            form.reportValidity();
        }
    }
</script>

@endsection