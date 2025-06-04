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
                    ["id" => 1, "key" => "statistics", "name" => "Análisis", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 2, "key" => "administration", "name" => "Administración", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 3, "key" => "general_finances", "name" => "Finanzas Generales", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 4, "key" => "personal_finance", "name" => "Finanzas Personales", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "community", "name" => "Comunidad", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()

            ],
            [
                "nombre" => "Propietario",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "statistics", "name" => "Análisis", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "administration", "name" => "Administración", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 3, "key" => "general_finances", "name" => "Finanzas Generales", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 4, "key" => "personal_finance", "name" => "Finanzas Personales", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 5, "key" => "community", "name" => "Comunidad", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Inquilino",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "statistics", "name" => "Análisis", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 2, "key" => "administration", "name" => "Administración", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 3, "key" => "general_finances", "name" => "Finanzas Generales", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 4, "key" => "personal_finance", "name" => "Finanzas Personales", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 5, "key" => "community", "name" => "Comunidad", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Tesorero",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "statistics", "name" => "Análisis", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 2, "key" => "administration", "name" => "Administración", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 3, "key" => "general_finances", "name" => "Finanzas Generales", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 4, "key" => "personal_finance", "name" => "Finanzas Personales", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "community", "name" => "Comunidad", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
            [
                "nombre" => "Presidente",
                "permisos" => json_encode([
                    ["id" => 1, "key" => "statistics", "name" => "Análisis", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 2, "key" => "administration", "name" => "Administración", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 3, "key" => "general_finances", "name" => "Finanzas Generales", "view" => true, "create" => true, "update" => true, "delete" => true],
                    ["id" => 4, "key" => "personal_finance", "name" => "Finanzas Personales", "view" => false, "create" => false, "update" => false, "delete" => false],
                    ["id" => 5, "key" => "community", "name" => "Comunidad", "view" => true, "create" => true, "update" => true, "delete" => true],
                ]),
                'created_at' => now(),   // necesarios si usas DB::table
                'updated_at' => now()
            ],
        ]);
    }
}
