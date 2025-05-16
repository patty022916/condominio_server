<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $letrasDosHabitaciones = ['A', 'B', 'G', 'H'];
        $letrasTresHabitaciones = ['C', 'D', 'E', 'F'];

        for ($i = 0; $i < 56; $i++) {
            $esDosHabitaciones = $i < 28;

            DB::table('apartamentos')->insert([
                'piso' => $faker->numberBetween(1, 7),
                'letra' => $esDosHabitaciones ? $letrasDosHabitaciones[$i % count($letrasDosHabitaciones)]
                    : $letrasTresHabitaciones[($i - 28) % count($letrasTresHabitaciones)],
                'habitaciones'  => $esDosHabitaciones ? 2 : 3,
                'propietario_id' => $i + 1, // 1 a 56
                'inquilino_id'  => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
