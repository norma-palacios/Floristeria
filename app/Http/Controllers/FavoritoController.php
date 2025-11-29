<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritoController extends Controller
{
    public function index()
    {
        $usuarioId = Auth::id();

        // Obtenemos los favoritos uniendo con la tabla productos
        // para tener nombre, precio e imagen disponible en la vista
        $favoritos = DB::table('favoritos')
            ->join('productos', 'favoritos.producto_id', '=', 'productos.id')
            ->select('favoritos.id as fav_id', 'productos.*')
            ->where('favoritos.usuario_id', $usuarioId)
            ->get();

        return view('favoritos', compact('favoritos'));
    }

       public function store(Request $request)
    {
        // Validamos que se reciba un ID de producto válido
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $userId = Auth::id();
        $productoId = $request->producto_id;

        // Verificamos si ya existe este producto en los favoritos del usuario
        $exists = DB::table('favoritos')
            ->where('usuario_id', $userId)
            ->where('producto_id', $productoId)
            ->exists();

        if (!$exists) {
            // Si no existe, lo insertamos
            DB::table('favoritos')->insert([
                'usuario_id' => $userId,
                'producto_id' => $productoId,
                'created_at' => now()
            ]);
            return redirect()->back()->with('success', 'Producto agregado a favoritos');
        }

        // Si ya existe, avisamos al usuario sin duplicar
        return redirect()->back()->with('info', 'El producto ya estaba en tus favoritos');
    }  

    // Método para eliminar de favoritos
    public function destroy($id)
    {
        DB::table('favoritos')
            ->where('id', $id)
            ->where('usuario_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Producto eliminado de la lista de deseos');
    }
}
