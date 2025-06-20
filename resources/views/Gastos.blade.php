<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Gastos</title>
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
    <h1>Gastos generales {{ date('d/m/Y') }} </h1>
    <table style="margin: 0 auto; width: 100%;">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Tipo gasto</th>
                <th>Fecha</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp

            @foreach ($gastosFiltrados as $nomina)
            <tr>
                <td>{{ $nomina->descripcion }}</td>
                <td>{{ $nomina->tipo_gasto }}</td>
                <td>{{ date('d/m/Y', strtotime($nomina->fecha)) }}</td>
                <td>{{ $nomina->monto }} $</td>
            </tr>
            @php $total += $nomina->monto; @endphp
            @endforeach

            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
                <td style="font-weight: bold;">{{ $total }}$</td>
            </tr>


        </tbody>

    </table>
</body>

</html>