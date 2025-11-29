<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    // Muestra el contenido del carrito
    public function index()
    {
        $userId = Auth::id();

        // Obtener items del carrito con información del producto
        $items = DB::table('carrito')
            ->join('productos', 'carrito.producto_id', '=', 'productos.id')
            ->select('carrito.id as carrito_id', 
                'carrito.cantidad',           // <-- ESTO ES LO IMPORTANTE: Cantidad del usuario (1)
                'productos.id as producto_id', 
                'productos.nombre', 
                'productos.precio', 
                'productos.imagen',
                'productos.cantidad as stock')
            ->where('carrito.usuario_id', $userId)
            ->get();

        // Calcular total
        $total = $items->sum(function($item) {
            return $item->precio * $item->cantidad;
        });

        return view('carrito', compact('items', 'total'));
    }

    // Agrega un producto al carrito
    public function add(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $userId = Auth::id();
        $productoId = $request->producto_id;
        
        // 1. Verificar si el producto ya está en el carrito de este usuario
        $itemExistente = DB::table('carrito')
            ->where('usuario_id', $userId)
            ->where('producto_id', $productoId)
            ->first();

        if ($itemExistente) {
            // 2. Si existe, aumentamos la cantidad en +1
            DB::table('carrito')
                ->where('id', $itemExistente->id)
                ->increment('cantidad');
        } else {
            // 3. Si no existe, creamos el registro
            DB::table('carrito')->insert([
                'usuario_id' => $userId,
                'producto_id' => $productoId,
                'cantidad' => 1,
                'created_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Producto añadido al carrito correctamente');
    }

    // ACTUALIZAR CANTIDAD (Para el dropdown del carrito)
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:50' 
        ]);

        DB::table('carrito')
            ->where('id', $id)
            ->where('usuario_id', Auth::id())
            ->update(['cantidad' => $request->cantidad]);

        return redirect()->back()->with('success', 'Cantidad actualizada');
    }

    // Eliminar item del carrito
    public function destroy($id)
    {
        DB::table('carrito')
            ->where('id', $id)
            ->where('usuario_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }
}