<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function showForm()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'password' => 'required|min:6',
        ]);

        // Guardar en BD
        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('success', 'Tu cuenta ha sido creada correctamente.');
    }
}