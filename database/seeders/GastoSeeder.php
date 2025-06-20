<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gastos')->insert(
            [

                [
                    "descripcion" => "Bolsas de basura",
                    "monto" => "10.00",
                    "tipo_gasto" => "comun",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Material de limpieza",
                    "monto" => "20.00",
                    "tipo_gasto" => "fijo",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Mantenimiento de Ascensor",
                    "monto" => "2500.00",
                    "tipo_gasto" => "extraordinario",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Nomina #1",
                    "monto" => "50.00",
                    "tipo_gasto" => "fijo",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Nomina #2",
                    "monto" => "50.00",
                    "tipo_gasto" => "fijo",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Nomina #3",
                    "monto" => "80.00",
                    "tipo_gasto" => "fijo",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    "descripcion" => "Nomina #4",
                    "monto" => "20.00",
                    "tipo_gasto" => "fijo",
                    "fecha" => now(),
                    "recurrente" => true,
                    "id_proveedor" => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            ]
        );
    }
}
