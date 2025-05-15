<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 56; $i++) {
            DB::table('usuarios')->insert([
                'nombre'     => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'password'   => $faker->password,
                'telefono'   => $faker->phoneNumber,
                'id_rol'     => 2, //*PROPIETARIO 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
