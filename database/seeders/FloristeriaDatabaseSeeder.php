<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FloristeriaDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear dirección de prueba
        $direccion_id = DB::table('direcciones')->insertGetId([
            'usuario_id' => 1,
            'direccion' => '5 av norte, San Salvador',
            'ciudad' => 'San Salvador',
            'departamento' => 'San Salvador',
            'indicaciones' => 'Casa blanca con puerta roja',
            'created_at' => now(),
        ]);

        // Crear datos de ejemplo para productos
        DB::table('productos')->insert([
            [
                'nombre' => 'Ramo Hermoso',
                'descripcion' => 'Hermoso ramo floral de 5 gerberas blancas',
                'precio' => 35.00,
                'cantidad' => 10,
                'imagen' => 'https://via.placeholder.com/200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Rosas',
                'descripcion' => 'Ramo de rosas rojas premium',
                'precio' => 45.00,
                'cantidad' => 8,
                'imagen' => 'https://via.placeholder.com/200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Jorasoles',
                'descripcion' => 'Ramo de girasoles amarillos',
                'precio' => 30.00,
                'cantidad' => 15,
                'imagen' => 'https://via.placeholder.com/200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ramo de Tulipanes',
                'descripcion' => 'Ramo de tulipanes variados',
                'precio' => 40.00,
                'cantidad' => 12,
                'imagen' => 'https://via.placeholder.com/200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Crear pedidos de ejemplo usando la tabla ordenes
        DB::table('ordenes')->insert([
            [
                'usuario_id' => 1,
                'direccion_id' => $direccion_id,
                'total' => 35.00,
                'estado' => 'pendiente',
                'metodo_pago' => 'simulado',
                'created_at' => now(),
            ],
            [
                'usuario_id' => 1,
                'direccion_id' => $direccion_id,
                'total' => 45.00,
                'estado' => 'pagado',
                'metodo_pago' => 'simulado',
                'created_at' => now(),
            ],
            [
                'usuario_id' => 1,
                'direccion_id' => $direccion_id,
                'total' => 30.00,
                'estado' => 'entregado',
                'metodo_pago' => 'simulado',
                'created_at' => now(),
            ],
            [
                'usuario_id' => 1,
                'direccion_id' => $direccion_id,
                'total' => 40.00,
                'estado' => 'pendiente',
                'metodo_pago' => 'simulado',
                'created_at' => now(),
            ],
            [
                'usuario_id' => 1,
                'direccion_id' => $direccion_id,
                'total' => 28.00,
                'estado' => 'enviado',
                'metodo_pago' => 'simulado',
                'created_at' => now(),
            ],
        ]);
    }
}
