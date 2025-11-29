<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    // 1. MOSTRAR PANTALLA DE PAGO
    public function index()
    {
        $userId = Auth::id();

        // Obtener items del carrito
        $items = DB::table('carrito')
            ->join('productos', 'carrito.producto_id', '=', 'productos.id')
            ->select('carrito.cantidad', 'productos.nombre', 'productos.precio', 'productos.imagen')
            ->where('carrito.usuario_id', $userId)
            ->get();

        // Si el carrito está vacío, regresar al inicio
        if ($items->isEmpty()) {
            return redirect('/')->with('info', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = $items->sum(function($item) {
            return $item->precio * $item->cantidad;
        });

        // Obtener direcciones del usuario para que elija una
        $direcciones = DB::table('direcciones')
            ->where('usuario_id', $userId)
            ->get();

        return view('pago', compact('items', 'total', 'direcciones'));
    }

    // 2. PROCESAR EL PAGO (Simulado)
    public function procesar(Request $request)
    {
        $request->validate([
            'direccion_id' => 'required|exists:direcciones,id',
            'numero_tarjeta' => 'required|min:16', // Validación básica simulada
        ]);

        $userId = Auth::id();

        // A. Obtener datos del carrito una última vez
        $items = DB::table('carrito')
            ->join('productos', 'carrito.producto_id', '=', 'productos.id')
            ->select('carrito.producto_id', 'carrito.cantidad', 'productos.precio')
            ->where('carrito.usuario_id', $userId)
            ->get();
        
        $total = $items->sum(fn($item) => $item->precio * $item->cantidad);

        // B. Crear la Orden
        $ordenId = DB::table('ordenes')->insertGetId([
            'usuario_id' => $userId,
            'direccion_id' => $request->direccion_id,
            'total' => $total,
            'estado' => 'pagado', // Asumimos pago exitoso inmediato
            'metodo_pago' => 'tarjeta',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // C. Mover items a 'orden_detalle' y bajar Stock
        foreach ($items as $item) {
            // Detalle
            DB::table('orden_detalle')->insert([
                'orden_id' => $ordenId,
                'producto_id' => $item->producto_id,
                'precio_unitario' => $item->precio,
                'cantidad' => $item->cantidad,
                'subtotal' => $item->precio * $item->cantidad
            ]);

            // Restar stock
            DB::table('productos')->where('id', $item->producto_id)->decrement('cantidad', $item->cantidad);
        }

        // D. Vaciar Carrito
        DB::table('carrito')->where('usuario_id', $userId)->delete();

        // E. Retornar éxito (esto lo usaremos para disparar el modal en la vista o redirigir)
        return redirect()->route('profile.index')->with('success', '¡Tu orden #' . $ordenId . ' ha sido procesada con éxito!');
    }
}
