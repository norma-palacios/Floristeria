<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class InicioController extends Controller
{
    public function index()
    {
        // Traer todos los productos
        $productos = Producto::all();

        return view('inicio', compact('productos'));
    }
}