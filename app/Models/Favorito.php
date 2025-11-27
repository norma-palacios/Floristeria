<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';

    protected $fillable = [
        'user_id',
        'producto_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
