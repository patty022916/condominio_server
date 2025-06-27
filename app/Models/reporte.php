<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    public static function listarMorosos()
    {
        return  [
            ['nombre' => 'Ana Pérez', 'apartamento' => 'A101', 'deuda' => 120.50, 'cuota' => 30.00, 'fecha_de_la_deuda' => '2025-06-01'],
            ['nombre' => 'Luis Gómez', 'apartamento' => 'A102', 'deuda' => 75.00, 'cuota' => 25.00, 'fecha_de_la_deuda' => '2025-06-05'],
            ['nombre' => 'María Rodríguez', 'apartamento' => 'A103', 'deuda' => 200.00, 'cuota' => 50.00, 'fecha_de_la_deuda' => '2025-05-28'],
            ['nombre' => 'Carlos Sánchez', 'apartamento' => 'A104', 'deuda' => 150.00, 'cuota' => 50.00, 'fecha_de_la_deuda' => '2025-06-10'],
            ['nombre' => 'Laura Fernández', 'apartamento' => 'A105', 'deuda' => 90.00, 'cuota' => 30.00, 'fecha_de_la_deuda' => '2025-06-02'],
            ['nombre' => 'Diego Torres', 'apartamento' => 'B201', 'deuda' => 60.00, 'cuota' => 20.00, 'fecha_de_la_deuda' => '2025-06-03'],
            ['nombre' => 'Sofía Ramírez', 'apartamento' => 'B202', 'deuda' => 180.00, 'cuota' => 45.00, 'fecha_de_la_deuda' => '2025-05-30'],
            ['nombre' => 'Jorge Herrera', 'apartamento' => 'B203', 'deuda' => 220.00, 'cuota' => 55.00, 'fecha_de_la_deuda' => '2025-06-06'],
            ['nombre' => 'Valentina Ruiz', 'apartamento' => 'B204', 'deuda' => 130.00, 'cuota' => 32.50, 'fecha_de_la_deuda' => '2025-06-04'],
            ['nombre' => 'Gabriel Castro', 'apartamento' => 'B205', 'deuda' => 95.00, 'cuota' => 23.75, 'fecha_de_la_deuda' => '2025-06-08'],
            ['nombre' => 'Camila Morales', 'apartamento' => 'C301', 'deuda' => 105.00, 'cuota' => 35.00, 'fecha_de_la_deuda' => '2025-06-01'],
            ['nombre' => 'Ricardo Mendoza', 'apartamento' => 'C302', 'deuda' => 70.00, 'cuota' => 17.50, 'fecha_de_la_deuda' => '2025-05-29'],
            ['nombre' => 'Daniela Vargas', 'apartamento' => 'C303', 'deuda' => 160.00, 'cuota' => 40.00, 'fecha_de_la_deuda' => '2025-06-09'],
            ['nombre' => 'Pedro Navarro', 'apartamento' => 'C304', 'deuda' => 110.00, 'cuota' => 27.50, 'fecha_de_la_deuda' => '2025-06-11'],
            ['nombre' => 'Lucía Rivas', 'apartamento' => 'C305', 'deuda' => 85.00, 'cuota' => 21.25, 'fecha_de_la_deuda' => '2025-06-07'],
            ['nombre' => 'Fernando Gil', 'apartamento' => 'D401', 'deuda' => 190.00, 'cuota' => 47.50, 'fecha_de_la_deuda' => '2025-06-03'],
            ['nombre' => 'Isabel Soto', 'apartamento' => 'D402', 'deuda' => 100.00, 'cuota' => 25.00, 'fecha_de_la_deuda' => '2025-06-06'],
            ['nombre' => 'Matías Peña', 'apartamento' => 'D403', 'deuda' => 210.00, 'cuota' => 52.50, 'fecha_de_la_deuda' => '2025-06-10'],
            ['nombre' => 'Renata Campos', 'apartamento' => 'D404', 'deuda' => 140.00, 'cuota' => 35.00, 'fecha_de_la_deuda' => '2025-06-02'],
            ['nombre' => 'Tomás Salas', 'apartamento' => 'D405', 'deuda' => 155.00, 'cuota' => 38.75, 'fecha_de_la_deuda' => '2025-06-05']
        ];
    }
}
