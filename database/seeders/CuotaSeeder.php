<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cuotas')->insert(
            [
                "descripcion" => "Cuota del mes de junio",
                "monto" => 2730,
                "periodo" =>  1,
                "fecha" => now(),
                "created_at" => now(),
                "updated_at" => now()
            ]
        );
    }
}
