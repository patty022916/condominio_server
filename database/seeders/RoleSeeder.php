<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                "nombre" => "Administrador",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "key_modulo1", "name" => "modulo1", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 2, "key" => "key_modulo2", "name" => "modulo2", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 3, "key" => "key_modulo3", "name" => "modulo3", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 4, "key" => "key_modulo4", "name" => "modulo4", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 5, "key" => "key_modulo5", "name" => "modulo5", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()

            ],
            [
                "nombre" => "Propietario",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "key_modulo1", "name" => "modulo1", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "key_modulo2", "name" => "modulo2", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 3, "key" => "key_modulo3", "name" => "modulo3", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 4, "key" => "key_modulo4", "name" => "modulo4", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "key_modulo5", "name" => "modulo5", "view" => true, "create" => true, "update" => true, "delete" => false],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Inquilino",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "key_modulo1", "name" => "modulo1", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "key_modulo2", "name" => "modulo2", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 3, "key" => "key_modulo3", "name" => "modulo3", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 4, "key" => "key_modulo4", "name" => "modulo4", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "key_modulo5", "name" => "modulo5", "view" => true, "create" => true, "update" => true, "delete" => false],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Tesorero",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "key_modulo1", "name" => "modulo1", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "key_modulo2", "name" => "modulo2", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 3, "key" => "key_modulo3", "name" => "modulo3", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 4, "key" => "key_modulo4", "name" => "modulo4", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "key_modulo5", "name" => "modulo5", "view" => true, "create" => true, "update" => true, "delete" => false],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Empleado",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "key_modulo1", "name" => "modulo1", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "key_modulo2", "name" => "modulo2", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 3, "key" => "key_modulo3", "name" => "modulo3", "view" => true, "create" => true, "update" => true, "delete" => false],
                    ["id" => 4, "key" => "key_modulo4", "name" => "modulo4", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "key_modulo5", "name" => "modulo5", "view" => true, "create" => true, "update" => true, "delete" => false],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
        ]);
    }
}
