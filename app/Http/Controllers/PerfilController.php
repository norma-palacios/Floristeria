<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Direccion; // Asegúrate de tener este modelo
// use App\Models\Orden; // Si usas modelos para órdenes

class PerfilController extends Controller
{
    // Muestra la pantalla de perfil
    public function index()
    {
        $user = Auth::user();

        // 1. Obtener Órdenes del usuario (usando Query Builder si no tienes modelos aún)
        $ordenes = DB::table('ordenes')
                    ->where('usuario_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

        // 2. Obtener Direcciones del usuario
        $direcciones = DB::table('direcciones')
                        ->where('usuario_id', $user->id)
                        ->get();

        return view('perfil', compact('user', 'ordenes', 'direcciones'));
    }

    // Guarda una nueva dirección desde el Modal
    public function storeAddress(Request $request)
    {
        $request->validate([
            'calle' => 'required|string|max:255',
            'numero_casa' => 'nullable|string|max:50',
            'departamento' => 'required|string',
            'municipio' => 'required|string',
            'etiqueta' => 'nullable|string|max:100', // Lo guardaremos en 'indicaciones' por ahora
        ]);

        // Concatenar calle y número para el campo 'direccion' de la BD
        $direccionCompleta = $request->calle;
        if($request->numero_casa) {
            $direccionCompleta .= ', ' . $request->numero_casa;
        }

        // Usaremos el campo 'indicaciones' para guardar la "Etiqueta" (Ej. Casa, Oficina)
        // ya que tu tabla no tiene columna 'nombre_direccion'
        
        DB::table('direcciones')->insert([
            'usuario_id' => Auth::id(),
            'direccion' => $direccionCompleta,
            'departamento' => $request->departamento, // Mapeado al dropdown "Ciudad" (Depto)
            'ciudad' => $request->municipio,          // Mapeado al dropdown "Municipio"
            'indicaciones' => $request->etiqueta,     // Guardamos la etiqueta aquí
            'created_at' => now()
        ]);

        return redirect()->back()->with('success', 'Dirección agregada correctamente');
    }

    // ACTUALIZAR DIRECCIÓN
    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'etiqueta' => 'nullable|string|max:100', // Campo 'indicaciones' en BD
            'direccion' => 'required|string|max:255',
            'departamento' => 'required|string',
            'municipio' => 'required|string',
        ]);

        // Aseguramos que solo el dueño pueda editar
        DB::table('direcciones')
            ->where('id', $id)
            ->where('usuario_id', Auth::id())
            ->update([
                'indicaciones' => $request->etiqueta,
                'direccion' => $request->direccion, // Guardamos la dirección completa editada
                'departamento' => $request->departamento,
                'ciudad' => $request->municipio
            ]);

        return redirect()->back()->with('success', 'Dirección actualizada correctamente');
    }

    // Eliminar dirección
    public function destroyAddress($id)
    {
        DB::table('direcciones')
            ->where('id', $id)
            ->where('usuario_id', Auth::id()) // Seguridad: solo borrar si es del usuario
            ->delete();

        return redirect()->back()->with('success', 'Dirección eliminada');
    }
}
