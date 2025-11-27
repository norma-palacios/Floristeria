<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InicioController;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegistroController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegistroController::class, 'register'])->name('register.save');

Route::get('/inicio', [InicioController::class, 'index'])
    ->name('inicio')
    ->middleware('auth');