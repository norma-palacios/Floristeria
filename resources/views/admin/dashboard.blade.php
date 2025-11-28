@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

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
        <a href="{{ route('admin.productos') }}" class="d-block text-decoration-none text-white p-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <span class="fw-bold">Productos</span>
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

<div class="admin-content" style="background-color: #F8F9FA;">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold text-dark m-0">Panel de Control</h1>
        <span class="badge bg-light text-secondary border px-3 py-2">
            <i class="bi bi-calendar-event me-2"></i>{{ now()->format('d M, Y') }}
        </span>
    </div>

    <!--GESTION DE OPERACIONES-->
    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">
        <i class="bi bi-grid-fill me-2"></i>Gestión Operativa
    </h5>

    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <a href="{{ route('admin.pedidos') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: white; border-left: 5px solid #3498db !important; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Pedidos</h4>
                            <p class="text-muted mb-0 small">Gestionar estados y envíos</p>
                        </div>
                        <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: #EBF5FB; width: 60px; height: 60px;">
                            <i class="bi bi-clipboard-data-fill text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-3">
            <a href="{{ route('admin.productos') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: white; border-left: 5px solid #9b59b6 !important; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Inventario</h4>
                            <p class="text-muted mb-0 small">Control de Productos y categorías</p>
                        </div>
                        <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: #F4ECF7; width: 60px; height: 60px;">
                            <i class="bi bi-box-seam-fill" style="color: #9b59b6; font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- SECCION DE REPORTES Y METRICAS-->
    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">
        <i class="bi bi-bar-chart-line-fill me-2"></i>Métricas y Reportes
    </h5>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #9b59b6, #e3a1fdff); border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="opacity-75 mb-1">Ingresos Totales (Mes Actual)</h6>
                        <h2 class="fw-bold mb-0 display-6">${{ number_format($ventaMes, 2) }}</h2>
                    </div>
                    <div class="opacity-50">
                        <i class="bi bi-currency-dollar" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-secondary mb-0">
                        <i class="bi bi-trophy-fill text-warning me-2"></i>Top Productos (Valor)
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 250px; width: 100%;">
                        <canvas id="topVentasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-secondary mb-0">
                        <i class="bi bi-pie-chart-fill text-info me-2"></i>Distribución de Stock
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 250px; width: 100%; display: flex; justify-content: center;">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-5 text-center text-muted small py-3">
        Dinamita Flowersshop System &copy; {{ date('Y') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Configuración global de Chart.js
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.color = '#666';

    // Gráfico Barras (Top Productos)
    const ctxVentas = document.getElementById('topVentasChart').getContext('2d');
    new Chart(ctxVentas, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProductos->pluck('nombre')) !!}, 
            datasets: [{
                label: 'Valor ($)',
                data: {!! json_encode($topProductos->pluck('total_vendido')) !!},
                backgroundColor: 'rgba(155, 89, 182, 0.7)', 
                borderColor: 'rgba(155, 89, 182, 1)',
                borderWidth: 1,
                borderRadius: 6, 
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }, // Ocultar leyenda
            scales: { 
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [5, 5] } // Líneas punteadas
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Gráfico Dona (Stock)
    const ctxStock = document.getElementById('stockChart').getContext('2d');
    new Chart(ctxStock, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($stockProductos->pluck('nombre')) !!},
            datasets: [{
                data: {!! json_encode($stockProductos->pluck('cantidad')) !!},
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { position: 'right', labels: { boxWidth: 12, usePointStyle: true } } 
            },
            cutout: '70%' 
        }
    });
</script>
@endsection