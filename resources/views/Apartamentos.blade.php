<!DOCTYPE html>
<html>

<head>
    <title>Reporte de apartamentos</title>
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
    <h1>Listado de apartamentos {{ date('d/m/Y') }} </h1>
    <table style="margin: 0 auto; width: 100%;">
        <thead>
            <tr>
                <th>Propietario</th>
                <th>Inquilino</th>
                <th>Piso</th>
                <th>Letra</th>
                <th>Habitaciones</th>
                <th>Fecha ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartamentos as $apto)
            <tr>
                <td>{{ $apto->propietario}}</td>
                <td>{{ $apto->inquilino ?? 'Sin existencia'}}</td>
                <td>{{ $apto->piso}}</td>
                <td>{{ $apto->letra}}</td>
                <td>{{ $apto->habitaciones}}</td>
                <td>{{ date('d/m/Y', strtotime($apto->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>