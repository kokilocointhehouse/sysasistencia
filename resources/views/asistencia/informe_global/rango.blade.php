<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Informe de Asistencias</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }
        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
            width: 100%;
        }
        td {
            padding: 3px;
            border: 1px solid #000;
        }
        th {
            padding: 3px;
            border: 1px solid #000;
            background: #3a3939;
            color: #ffffff;
        }
        .data{
        /* background: rgb(146, 142, 142); */
        float: right;
        margin: 2% 0% 0% 0%;
        }
    </style>
</head>
<body>
    <div>
        <img src="../public/logo/{{$empresa->Logo}}" alt="" width="80" height="80">
        <p class="data">
            {{$empresa->nomEmpresa}} <br>
            Dirección: {{$empresa->Direccion}}
        </p>
    </div>
    <div class="encabezado" style="background: #163864; color: #ffffff;
    text-align: center; padding: 10px">
        <span>Informe del {{InformeController::fechaCastellano($id)}} al {{InformeController::fechaCastellano($id2)}}</span>
    </div>
    <div>
        <br>
        @if (!empty($id3))
            <p>{{$id3}} <span style="float: right">{{InformeController::fechaCastellano($fecha)}}</span></p>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th width="20">N°</th>
                @if (empty($id3))
                    <th>Personal</th>
                @endif
                <th width="140">Fecha Entrada</th>
                <th >H.Entrada</th>
                <th>Tema de Clase</th>
                <th >H. Salida</th>
                <th >T. Laborado</th>
            </tr>
        </thead>
        <tbody>
            @php($ante2 = '')
            @php($ante = '')
            @php($i = 0)
            @php($horas_laboradas = 0)
            @foreach ($informe as $item)
            <tr>

                <td align="center">
                    @if ($ante2 != $item->Nombres || $ante != $item->FechaRegistro)
                    {{$i +=1}}
                    @endif
                </td>
                @if (empty($id3))
                <td>
                    @if ($ante2 != $item->Nombres || $ante != $item->FechaRegistro)
                        @php($n = explode(" ", strtoupper($item->Nombres)))
                        @if (count($n) > 2)
                            {{$n[0]}} {{$n[1]}}
                        @else
                            {{$item->Nombres}}
                        @endif
                    @endif
                </td>
                @endif
                <td>
                    @if ($ante2 != $item->Nombres || $ante != $item->FechaRegistro)
                    {{InformeController::fechaCastellano($item->FechaRegistro)}}

                    @endif
                </td>
                <td align="center">{{$item->HoraEntrada}} </td>
                <td>{{$item->tema}}</td>
                <td align="center">
                    @if (isset($item->HoraSalida))
                        {{$item->HoraSalida}}
                    @else
                        ...
                    @endif
                </td>

                <td align="center">
                    @if (isset($item->HoraSalida))
                        {{RegistroController::RestarHoras($item->HoraEntrada, $item->HoraSalida)}}
                        @php($m2 = explode(":", RegistroController::RestarHoras($item->HoraEntrada, $item->HoraSalida)))
                        @php($horas_laboradas += ($m2[0] * 3600) + ($m2[1] * 60) + $m2[2])
                    @else
                    <span>...</span>
                    @endif
                </td>
            </tr>
            @php($ante = $item->FechaRegistro)
            @php($ante2 = $item->Nombres)
            @endforeach
            <tr>
                @if (empty($id3))
                <td colspan="5" style="border: 0px">
                </td>
                @else
                <td colspan="4" style="border: 0px">
                </td>
                @endif
                <td align="center" > <b>Total T. Laborado</b> </td>
                <td align="center" ><b>
                    @php($horas_laboradas = InformeController::conversor_segundos  ($horas_laboradas))
                    {{$horas_laboradas}}</b></td>
            </tr>
            <tr>
                @if (empty($id3))
                <td colspan="5" style="border: 0px">
                </td>
                @else
                <td colspan="4" style="border: 0px">
                </td>
                @endif
                <td align="center"> <b>Monto a Pagar</b> </td>
                <td align="center">
                    @php($m3 = explode(":",$horas_laboradas))
                    <b>
                        {{number_format( ($m3[0] + ($m3[1]/60) + ($m3[2]/3600)) * $empresa->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
