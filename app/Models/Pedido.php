<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'ordenes';

    protected $fillable = [
        'user_id',
        'total',
        'estado', // ejemplo: pendiente, entregado

        
    ];
}