<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pedidos()
    {
        $pedidos = Pedido::with('usuario')->paginate(10);
        return view('admin.pedidos', compact('pedidos'));
    }

    public function productos()
    {
        $productos = Producto::all();
        return view('admin.productos', compact('productos'));
    }

    public function crearProducto()
    {
        return view('admin.crearProducto');
    }

    public function guardarProducto(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'categoria' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);
        return redirect()->route('admin.productos')->with('success', 'Producto agregado correctamente');
    }

    public function eliminarProducto(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos')->with('success', 'Producto eliminado');
    }
}
