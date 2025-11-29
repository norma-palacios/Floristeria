<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
      public function index(Request $request)
    {
        // 1. Iniciar la consulta base
        $query = Producto::query();

        // 2. Filtro por Buscador (nombre o descripción)
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // 3. Filtro por Categoría
        if ($request->has('categoria') && $request->categoria != 'todas') {
            $query->where('categoria', $request->categoria);
        }

        // Ejecutar la consulta
        $productos = $query->get();

        // 4. Obtener categorías únicas para el filtro (dropdown)
        // Esto asume que el campo 'categoria' es un string en la tabla productos
        $categorias = Producto::select('categoria')
                        ->whereNotNull('categoria')
                        ->distinct()
                        ->pluck('categoria');

        // 5. Lógica de Favoritos (Existente)
        $favoritosIds = [];
        if (Auth::check()) {
            $favoritosIds = DB::table('favoritos')
                ->where('usuario_id', Auth::id())
                ->pluck('producto_id')
                ->toArray();
        }

        return view('inicio', compact('productos', 'favoritosIds', 'categorias'));
    }
}