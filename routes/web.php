<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\AdminController;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegistroController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegistroController::class, 'register'])->name('register.save');

Route::get('/inicio', [InicioController::class, 'index'])
    ->name('inicio')
    ->middleware('auth');

// Admin Routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::get('/productos/crear', [AdminController::class, 'crearProducto'])->name('admin.productos.crear');
    Route::post('/productos', [AdminController::class, 'guardarProducto'])->name('admin.productos.guardar');
    Route::delete('/productos/{producto}', [AdminController::class, 'eliminarProducto'])->name('admin.productos.eliminar');
    Route::get('/productos/{producto}/editar', [AdminController::class, 'editarProducto'])->name('admin.productos.editar');
    Route::put('/productos/{producto}', [AdminController::class, 'actualizarProducto'])->name('admin.productos.actualizar');
});