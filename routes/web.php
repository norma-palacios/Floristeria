<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagoController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');
Route::get('/register', [RegistroController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegistroController::class, 'register'])->name('register.save');

Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('profile.index');
    Route::post('/direcciones', [PerfilController::class, 'storeAddress'])->name('address.store');
    Route::delete('/direcciones/{id}', [PerfilController::class, 'destroyAddress'])->name('address.destroy');
    Route::put('/direcciones/{id}', [PerfilController::class, 'updateAddress'])->name('address.update');

    // Lista de Deseos (Favoritos)
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('wishlist.index');
    Route::post('/favoritos', [FavoritoController::class, 'store'])->name('wishlist.store');
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy'])->name('wishlist.destroy');

    // Carrito de Compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
    Route::delete('/carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');
    Route::put('/carrito/{id}', [CarritoController::class, 'update'])->name('carrito.update');

    Route::get('/checkout', [PagoController::class, 'index'])->name('pago.index');
    Route::post('/checkout/procesar', [PagoController::class, 'procesar'])->name('pago.procesar');
});