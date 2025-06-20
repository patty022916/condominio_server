<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedores')->insert(
            [

                [
                    "nombre" => "Andres Garcia",
                    "servicio" => "Limpieza",
                    "telefono" => "04123456789",
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "nombre" => "Andreina Villalobos",
                    "servicio" => "Limpieza",
                    "telefono" => "04123456349",
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "nombre" => "Juan Davila",
                    "servicio" => "Seguridad",
                    "telefono" => "04128475789",
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "nombre" => "Salomon Lopez",
                    "servicio" => "Portero",
                    "telefono" => "04123456789",
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            ]
        );
    }
}
