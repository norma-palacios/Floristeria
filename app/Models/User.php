<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'fecha_nacimiento',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password'
    ];

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}