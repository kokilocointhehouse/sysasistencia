<?php use App\Http\Controllers\InformeController; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Infome de Pagos</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }
        table {
            /* margin-left: auto;
            margin-right: auto; */
            border-collapse: collapse; border-color: rgb(0, 0, 0);
            width: 100%;
        }
        td {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
        }
        th {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }
        .data{
        float: right;
        margin: 2% 0% 0% 0%;
        }
    </style>

</head>

<body>
    <div>
        @if (!empty($empresa->Logo))
            <img src="../public/logo/{{$empresa->Logo}}" alt="" width="80" height="80">
            <p class="data">
                {{$empresa->nomEmpresa}} <br>
                {{$empresa->Direccion}}
            </p>
        @else
            <p>
                {{$empresa->nomEmpresa}} <br>
                {{$empresa->Direccion}}
            </p>
        @endif
    </div>
    <div colspan="3">
        {{$id3}}
    </div>
    <div style="background: #163864; color: #ffffff;
    text-align: center; padding: 10px; margin-bottom: 10px">
        <span>Pagos del {{InformeController::fechaCastellano($id)}} al {{InformeController::fechaCastellano($id2)}}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                @if ($id3 == '')
                    <th>Personal</th>
                @endif
                <th>Descripción</th>
                <th>Monto</th>
            </tr>
        </thead>
            <tbody>
            @php($totalMonto = 0)
            @foreach ($pago as $item)
                <tr>
                    @php($n = explode(' ', strtoupper($item->Nombres)))
                    <td>{{ date('d/m/Y', strtotime($item->fecha)) }}</td>
                    @if ($id3 == '')
                        @if (count($n) > 2)
                            <td>{{$n[0]}} {{$n[1]}}</td>
                        @else
                            <td>{{$item->Nombres}}</td>
                        @endif
                    @endif
                    <td>{{ strtoupper($item->nota) }} </td>
                    <td style="text-align: right">
                        $ : {{ $item->monto }}
                        @php($totalMonto += $item->monto)
                    </td>
                </tr>
            @endforeach
                <tr>
                    @if ($id3 == '')
                    <td colspan="2">
                    @else
                    <td>
                    @endif
                    </td>
                    <td align="right"> <b>Monto Total:</b> </td>
                    <td align="right"> <b>Dolares $:  {{$totalMonto}}</b> </td>
                </tr>
            </tbody>
        </table>
    </body>

    </html>
