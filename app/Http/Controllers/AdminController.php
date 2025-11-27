<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pedidos()
    {
        $pedidos = DB::table('pedidos')
            ->join('usuarios', 'pedidos.usuario_id', '=', 'usuarios.id')
            ->select('pedidos.*', 'usuarios.nombre as nombre_cliente')
            ->paginate(5);
        return view('admin.pedidos', compact('pedidos'));
    }

    public function productos()
    {
        $productos = Producto::paginate(5);
        return view('admin.productos', compact('productos'));
    }

    public function crearProducto()
    {
        return view('admin.crearProducto');
    }

    public function guardarProducto(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = '/storage/' . $path;
        }

        Producto::create($validated);
        return redirect()->route('admin.productos')->with('success', 'Producto agregado correctamente');
    }

    public function eliminarProducto(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos')->with('success', 'Producto eliminado');
    }

    public function editarProducto(Producto $producto)
    {
        return view('admin.crearProducto', compact('producto'));
    }

    public function actualizarProducto(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = '/storage/' . $path;
        }

        $producto->update($validated);

        return redirect()->route('admin.productos')->with('success', 'Producto actualizado correctamente');
    }
}
