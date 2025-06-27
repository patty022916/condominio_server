<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class DepartmentSeeder extends Seeder
{
    public static function getDepartmentsKeys($key)
    {


        preg_match('/(\d+)([A-Z])/', $key, $matches);

        $resultado = [
            "piso" => $matches[1],
            "letra" => $matches[2]
        ];

        return $resultado;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

         $apartamentos = [
            '1A','1B','1C','1D','1E','1F','1G','1H',
            '2A','2B','2C','2D','2E','2F','2G','2H',
            '3A','3B','3C','3D','3E','3F','3G','3H',
            '4A','4B','4C','4D','4E','4F','4G','4H',
            '5A','5B','5C','5D','5E','5F','5G','5H',
            '6A','6B','6C','6D','6E','6F','6G','6H',
            '7A','7B','7C','7D','7E','7F','7G','7H'
        ];

        for ($i = 0; $i < count($apartamentos); $i++) {
            $esDosHabitaciones = $i < 28;

            DB::table('apartamentos')->insert([
                'piso' => DepartmentSeeder::getDepartmentsKeys($apartamentos[$i])['piso'],
                'letra' => DepartmentSeeder::getDepartmentsKeys($apartamentos[$i])['letra'],
                'habitaciones'  => $esDosHabitaciones ? 2 : 3,
                'propietario_id' => $i + 1, // 1 a 56
                'inquilino_id'  => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
