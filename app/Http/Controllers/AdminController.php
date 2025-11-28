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
        // Total de ventas del mes actual (suma de la columna total)
        $ventaMes = DB::table('ordenes')
            ->where('estado', '!=', 'cancelado') // No contamos pedidos cancelados
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // Top 5 Productos con mas Stock (Inventario)
        $stockProductos = DB::table('productos')
            ->select('nombre', 'cantidad')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();


        $topProductos = DB::table('productos')
            ->select('nombre', 'precio as total_vendido') //PRECIO TEMPORAL
            ->orderByDesc('precio')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('ventaMes', 'topProductos', 'stockProductos'));
    
    }

    public function pedidos()
    {
            $pedidos = DB::table('ordenes')
                ->join('usuarios', 'ordenes.usuario_id', '=', 'usuarios.id')
                ->join('direcciones', 'ordenes.direccion_id', '=', 'direcciones.id')
                ->select('ordenes.*', 'usuarios.nombre as nombre_cliente',
                'direcciones.direccion',
                'direcciones.ciudad',
                'direcciones.departamento')
                ->paginate(5);

            return view('admin.ordenes', compact('pedidos'));
    }

    public function productos(Request $request) 
    {
        // Obtener todas las categorías únicas para el menú desplegable
        $categorias = Producto::select('categoria')
            ->distinct()
            ->whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->pluck('categoria');

        //  Iniciar la consulta de productos
        $query = Producto::query();

        //  Aplicar filtro si el usuario seleccionó una categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria', $request->categoria);
        }

        // Obtener resultados paginados
        $productos = $query->paginate(5);

        // Retornar vista con productos y la lista de categorías
        return view('admin.productos', compact('productos', 'categorias'));
    }

    public function crearProducto()
    {
        return view('admin.crearProducto');
    }

    public function guardarProducto(Request $request)
    {
        // Agregamos cantidad y categoria a la validacion
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0', 
            'categoria' => 'required|string|max:100', 
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = '/storage/' . $path;
        }

        Producto::create($validated);
        
        return redirect()->route('admin.productos')->with('success', 'Producto creado correctamente.');
        
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
            'cantidad' => 'required|integer|min:0', 
            'categoria' => 'required|string|max:100', 
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = '/storage/' . $path;
        }

        $producto->update($validated);

        return redirect()->route('admin.productos')->with('success', 'Producto actualizado correctamente');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,pagado,enviado,entregado,cancelado' 
        ]);

        DB::table('ordenes')
            ->where('id', $id)
            ->update([
                'estado' => $request->estado,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }
}
