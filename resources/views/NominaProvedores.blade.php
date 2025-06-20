<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Nomina</title>
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
    <h1>Nomina general {{ date('d/m/Y') }} </h1>
    <table style="margin: 0 auto; width: 100%;">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Servicio</th>
                <th>Teléfono</th>
                <th>Sueldo</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp

            @foreach ($gastosDeNomina as $nomina)
            <tr>
                <td>{{ $nomina->proveedor }}</td>
                <td>{{ $nomina->servicio }}</td>
                <td>{{ $nomina->telefono }}</td>
                <td>{{ $nomina->monto }} $</td>
            </tr>
            @php $total += $nomina->monto; @endphp
            @endforeach

            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
                <td style="font-weight: bold;">{{ $total }} $</td>
            </tr>


        </tbody>

    </table>
</body>

</html>