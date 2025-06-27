<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public static function getUserKeys($fullname)
    {
        $partes = explode(" ", $fullname, 2);
        return [
            "nombre" => $partes[0],
            "apellido" => isset($partes[1]) ? $partes[1] : ""
        ];
    }

    public static function generatePhone()
    {
        // Prefijos permitidos
        $prefijos = ['0412', '0424', '0416'];
        $prefijo = $prefijos[array_rand($prefijos)];

        // Generar 7 dígitos aleatorios
        $resto = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        return $prefijo . $resto;
    }

    public static function generarCorreoUnico($nombre)
    {
        $base = strtolower($nombre);
        $correo = $base . '@gmail.com';

        $contador = 1;

        // Verificar si ya existe
        while (DB::table('usuarios')->where('email', $correo)->exists()) {
            $correo = $base . $contador . '@gmail.com';
            $contador++;
        }
        return $correo;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $usuarios = [
            "CARMEN BASTARDO",
            "DANIEL PARDO ",
            "VIOLETA MOLANO",
            "NADIA SABBAGH",
            "ELINA COLINA",
            "ORLANDO HERNANDEZ",
            "DAICELIS RAMOS",
            "CIRO MARCANO",
            "ADOLFINA BELLO",
            "ALI CAHMSEDDIN",
            "RAIZA CABELLO",
            "RAMONA JIMENEZ",
            "NATHALIE MARIANI",
            "GLADYS DE PINTO",
            "ELIZABETH GONZALEZ",
            "OLGA GUERRA",
            "CARMEN AGUILERA ",
            "YIXON RONDON",
            "DIANA MICHIELI",
            "MARISELA RIVERO",
            "CELIANA FIGUEROA",
            "YAJAIRA MORALES",
            "MAYRA HERRERA",
            "RUSELA GUERRA",
            "ANGELA RODRIGUEZ",
            "ENRIQUE ROJAS",
            "FRANCY LANZA ",
            "LUCIA RAMIREZ",
            "MIGUEL GUILLEN",
            "JORGE PRADA",
            "ANGELINES SUBERO",
            "ORLANDO GUACARE",
            "MARISELA RIVERO",
            "MARITZA ARIAS",
            "MARIA EUGENIA",
            "ELIEZER RODRIGUEZ",
            "JESUS GONZALEZ",
            "JANNETE RODRIGUEZ",
            "ANA MAZA",
            "LENNYS DE MORILLO",
            "JUAN ZULOAGA",
            "YUSMIRA ORDOSGOITTI",
            "ERICK RIVERO",
            "ALICIA NARVAEZ",
            "JESUS RONDON",
            "OLIVIA ESPINOZA",
            "MAGALY VALENCIA",
            "VENINCIA RAMOS",
            "CARLOS MORGADO,",
            "JORGE PEREZ",
            "CARLOS GIL",
            "SONIA PEREZ",
            "PATRICIA2 AGUILAR",
            "BRIDAIMYS BRITO",
            "RICHARD LOPEZ ",
            "MARIANGEL BRITO",
        ];

        for ($i = 0; $i < count($usuarios); $i++) {
            DB::table('usuarios')->insert([
                'nombre'     => strtolower(UserSeeder::getUserKeys($usuarios[$i])['nombre']),
                'apellido'   => strtolower(UserSeeder::getUserKeys($usuarios[$i])['apellido']),
                'email'      => UserSeeder::generarCorreoUnico(UserSeeder::getUserKeys($usuarios[$i])['nombre']),
                'password'   => rand(8000000, 14999999),
                'telefono'   => UserSeeder::generatePhone(),
                'id_rol'     => 2, //*PROPIETARIO 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('usuarios')->insert([
            [
                'nombre'     => 'Louis',
                'apellido'   => 'Sarmiento',
                'email'      => 'slouis482@gmail.com',
                'password'   => 'admin',
                'telefono'   => '04123456789',
                'id_rol'     => 1, //*ADMINISTRADOR 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Patricia',
                'apellido'   => 'Aguilar',
                'email'      => 'patricia@gmail.com',
                'password'   => 'admin',
                'telefono'   => '4120811588',
                'id_rol'     => 1, //*ADMINISTRADOR 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
