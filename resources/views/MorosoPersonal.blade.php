<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Morosos</title>
    <style>
        * {
            margin: 10px;
            padding: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        thead {
            background-color: #014693;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>Deudas personales {{ date('d/m/Y') }} </h1>
    <table style="margin: 0 auto; width: 100%;">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apartamento</th>
                <th>Deuda</th>
                <th>Cuota</th>
                <th>Fecha Cuota</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($morosos_generales as $value)
            <tr>
                <td>{{ $value['nombre'] }}</td>
                <td>{{ $value['apartamento'] }}</td>
                <td>{{ $value['deuda'] }} Bs</td>
                <td>{{ $value['cuota'] }} Bs</td>
                <td>{{ date('d/m/Y', strtotime($value['fecha_de_la_deuda'])) }}</td>
            </tr>
            @endforeach



        </tbody>

    </table>
</body>

</html>