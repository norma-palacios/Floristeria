<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('login');
    }

     public function processLogin(Request $request)
    {
        // Validar inputs
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario por correo
        $usuario = User::where('correo', $request->correo)->first();

        // Si no existe
        if (!$usuario) {
            return back()->with('error_general', 'Credenciales incorrectas');
        }

        // Verificar contraseña
        if (!Hash::check($request->password, $usuario->password)) {
            return back()->with('error_general', 'Credenciales incorrectas');
        }

        // Iniciar sesión manualmente
        Auth::login($usuario);

        // Redirigir según rol
        if ($usuario->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('inicio');
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}