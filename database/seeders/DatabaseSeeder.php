<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar tablas existentes para evitar duplicados al re-sembrar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pedidos')->truncate();
        DB::table('usuarios')->truncate();
        DB::table('productos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insertar usuarios
        DB::table('usuarios')->insert([
            [
                'nombre' => 'norma ramirez',
                'correo' => 'norma@gmail.com',
                'telefono' => '72844484',
                'fecha_nacimiento' => '2000-12-24',
                'password' => bcrypt('norma123'),
                'rol' => 'cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Admin',
                'correo' => 'admin@floristeria.com',
                'telefono' => '7000-0000',
                'fecha_nacimiento' => null,
                'password' => bcrypt('admin123'),
                'rol' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insertar productos
        DB::table('productos')->insert([
            ['nombre' => 'Ramo Rosas Rojas', 'precio' => 35.00, 'cantidad' => 10, 'descripcion' => 'Hermoso ramo de rosas rojas frescas, ideal para ocasiones especiales.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201823/rosa1_xswfay.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bouquet Primavera', 'precio' => 28.50, 'cantidad' => 15, 'descripcion' => 'Ramo colorido con flores mixtas de temporada.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201811/rosas3_uanl0s.png', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ramo Elegancia Blanca', 'precio' => 32.00, 'cantidad' => 8, 'descripcion' => 'Ramo de flores blancas que representan pureza y armonía.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201812/rosas4webp_kwvcak.webp', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Arreglo Floral Deluxe', 'precio' => 45.00, 'cantidad' => 5, 'descripcion' => 'Arreglo premium con flores importadas y diseño elegante.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201811/rosas5_miulqw.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ramo Rosado Madison', 'precio' => 30.00, 'cantidad' => 12, 'descripcion' => 'Ramo rosado elegante, perfecto para regalar en aniversarios.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201811/rosas6_bba0h1.webp', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Caja de Rosas Premium', 'precio' => 50.00, 'cantidad' => 7, 'descripcion' => 'Caja fina con rosas premium y detalles decorativos.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201812/rosas7_d2xye9.webp', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Girasoles de Alegría', 'precio' => 25.00, 'cantidad' => 20, 'descripcion' => 'Ramo de girasoles brillantes que transmiten energía.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201822/flores-amarillas_lwvb1i.webp', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Arreglo con Lirios Blancos', 'precio' => 38.00, 'cantidad' => 6, 'descripcion' => 'Arreglo elegante con lirios frescos y follaje.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201815/rosas14_rgeg2m.webp', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Rosas Pastel Deluxe', 'precio' => 40.00, 'cantidad' => 9, 'descripcion' => 'Ramo suave con tonos pastel románticos.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201816/rosas16_lxntpe.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mini Bouquet Sorpresa', 'precio' => 15.00, 'cantidad' => 30, 'descripcion' => 'Pequeño bouquet perfecto para detalles espontáneos.', 'imagen' => 'https://res.cloudinary.com/dq22wmuwc/image/upload/v1764201816/rosas17_cvpz97.webp', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insertar pedidos de prueba CON EL CAMPO TOTAL
        DB::table('pedidos')->insert([
            [
                'usuario_id' => 1, 
                'descripcion' => 'Pedido de un ramo de flores', 
                'direccion' => '5 av norte, San Salvador San Salvador', 
                'total' => 35.00, // <--- Agregado
                'estado' => 'En Progreso', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'usuario_id' => 1, 
                'descripcion' => 'Pedido de un ramo de rosas', 
                'direccion' => '5 av norte, Ciudad Delgado San Salvador', 
                'total' => 45.50, // <--- Agregado
                'estado' => 'En Progreso', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'usuario_id' => 1, 
                'descripcion' => 'Pedido de un ramo de jorasoles', 
                'direccion' => '5 av norte, San Salvador San Salvador', 
                'total' => 30.00, // <--- Agregado
                'estado' => 'Completado', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'usuario_id' => 1, 
                'descripcion' => 'Pedido de un ramo de tulipanes', 
                'direccion' => 'Ilopango San Salvador', 
                'total' => 40.00, // <--- Agregado
                'estado' => 'En Progreso', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'usuario_id' => 1, 
                'descripcion' => 'Pedido de un ramo de claveles', 
                'direccion' => 'Soyapango San Salvador', 
                'total' => 25.00, // <--- Agregado
                'estado' => 'Enviado', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}