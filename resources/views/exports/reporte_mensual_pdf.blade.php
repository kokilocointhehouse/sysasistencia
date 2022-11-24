<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Asistencia {{$id}}-{{$id2}}</title>
</head>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 0.71em;
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
        border: 1px solid rgb(37, 87, 134);
    }
    th{
        padding: 3px; border: 1px solid rgb(37, 87, 134);
        background: #eaf3fa;
        color: #12446b;
    }
    .data{
        float: right;
        margin: 2% 0% 0% 0%;
        }
</style>
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

    <table>
        <tr>
            <td colspan="4" style="border: 0px ;"> {{$usuario->Nombres}}</td>
        </tr>
    </table>
    <div style="background: #163864; color: #ffffff;
    text-align: center; padding: 10px; margin-bottom: 10px">
        <span>Asistencia de {{$id}}-{{$id2}}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th style="font-weight: bold; ;">N°</th>
                <th style="font-weight: bold; ;">Fecha Entrada</th>
                <th style="font-weight: bold; ;">Hora Entrada</th>
                <th style="font-weight: bold; ;"> <span title="Ubicación Entrada">Ubic. Entrada</span> </th>
                <th style="font-weight: bold; ;">Hora Salida</th>
                <th style="font-weight: bold; ;"> <span title="Ubicación Salida">Ubic. Salida</span> </th>
                <th style="font-weight: bold; ;">Tardanza</th>
                <th style="font-weight: bold;">Hora Extra</th>
                <th style="font-weight: bold; ;">Tiempo Laborado</th>
            </tr>
        </thead>

        <tbody>
            @php($asistencia = 0)
            @php($contador = 0)
            @php($correcto = 0)
            @php($correcto2 = 0)
            @php($total_demora = 0)
            @php($total_horaExtra = 0)
            @php($horas_laboradas = 0)
            @php($incorrecto = 0)
            @php($incorrecto2 = 0)
            @foreach ($array_fechas as $item)
            @php($contador += 1)
            @php($valor_item = explode('_', $item))
            <tr>
                <td style="text-align: center">{{$contador}}</td>
                <td >
                    {{InformeController::fechaCastellano($valor_item[0])}}
                    @if ($valor_item[1] != 0 && $valor_item[9] != '')
                        <span  title="Registro Modificado."
                        style="color: #e66108; font-weight: bold; margin-left: 10px">M</span>
                    @endif
                </td>
                <td style="text-align: center">
                    @if ($valor_item[1] != 0)
                        {{$valor_item[1]}}
                        @php($asistencia += 1)
                    @else
                        ...
                    @endif

                </td>
                @if (!empty($valor_item[2]))
                    @if ($valor_item[2] == 'CORRECTO')
                        <td  style="color: #2b905d; text-align: center; ">
                        {{$valor_item[2]}}
                        @php($correcto += 1)
                    @else
                        <td  style="color: #f03f3f; text-align: center; ">
                        {{$valor_item[2]}}
                        @php($incorrecto += 1)
                    @endif
                @else
                    <td style="">
                    ...
                @endif
                </td>
                <td style="text-align: center" >
                    @if (!empty($valor_item[3]))
                        {{$valor_item[3]}}
                    @else
                        ...
                    @endif
                </td>

                @if (!empty($valor_item[3]))
                    @if ($valor_item[4] == 'CORRECTO')
                        <td  style="color: #2b905d; text-align: center; ">
                                {{$valor_item[4]}}
                            @php($correcto2 += 1)
                    @else
                        <td  style="color: #f03f3f; text-align: center; ">
                                {{$valor_item[4]}}
                            @php($incorrecto2 += 1)
                     @endif
                @else
                    <td style="">
                    ...
                @endif
                </td>
                    @if ($valor_item[1] > $empresa->HoraEntrada && !empty($valor_item[1]))
                    <td style="color: #f03f3f; text-align: center">
                         {{RegistroController::RestarHoras($valor_item[1], $empresa->HoraEntrada)}}
                        @php($m = explode(':', RegistroController::RestarHoras($valor_item[1], $empresa->HoraEntrada)))
                        @php($total_demora += $m[0] * 3600 + $m[1] * 60 + $m[2])
                    @else
                    <td style=" text-align: center">
                        ...
                     @endif
                </td>
                <td align="center" style="color: #2b905d">
                    @if ($valor_item[3] > $empresa->HoraSalida && !empty($valor_item[3]))
                        <span class="text-success"> {{RegistroController::RestarHoras($valor_item[3], $empresa->HoraSalida)}}</span>
                        @php($m3 = explode(":", RegistroController::RestarHoras($valor_item[3], $empresa->HoraSalida)))
                        @php($total_horaExtra += ($m3[0] * 3600) + ($m3[1] * 60) + $m3[2])
                    @endif
                </td>
                <td style="text-align: center">
                    @if ($valor_item[3] != 0)
                            {{RegistroController::RestarHoras($valor_item[1], $valor_item[3])}}
                            @php($m2 = explode(':', RegistroController::RestarHoras($valor_item[1], $valor_item[3])))
                            @php($horas_laboradas += $m2[0] * 3600 + $m2[1] * 60 + $m2[2])
                        @else
                        <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                     @endif
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" ><b>{{$asistencia}} registros encontrados en este mes.</b></td>
                <td align="center" >
                    {{$correcto}} C.
                    /
                    {{$incorrecto}} F.
                </td>
                <td></td>
                <td align="center">
                    {{$correcto2}} C.
                    /
                    {{$incorrecto2}} F.
                </td>
                <td  style=" color: #f03f3f; text-align: center"><b>
                    {{InformeController::conversor_segundos  ($total_demora)}}</b></td>
                <td class="text-success" align="center"><b>{{InformeController::conversor_segundos  ($total_horaExtra)}}</b> </td>
                <td style=" color: #3f9af0; text-align: center"><b>
                    {{InformeController::conversor_segundos  ($horas_laboradas)}}</b></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none"></td>
                <td align="center" style="font-weight: bold">Pago T. Laborado</td>
                <td style="text-align: right">
                    <b>
                        @php($m3 = explode(":",InformeController::conversor_segundos  ($horas_laboradas)))
                        {{number_format( ($m3[0] + ($m3[1]/60) + ($m3[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: none"></td>
                <td align="center" style="font-weight: bold">Desc. Tardanza</td>
                <td style="text-align: right">
                    <b>
                        @php($m4 = explode(":",InformeController::conversor_segundos  ($total_demora)))
                        - {{number_format( ($m4[0] + ($m4[1]/60) + ($m4[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: none"></td>
                <td align="center" style="font-weight: bold">Pago Hora Extra</td>
                <td style="text-align: right">
                    <b>
                        @php($m6 = explode(":", InformeController::conversor_segundos  ($total_horaExtra)))
                        {{number_format( ($m6[0] + ($m6[1]/60) + ($m6[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: none"></td>
                <td align="center" style="font-weight: bold">Monto a Pagar</td>
                <td style="text-align: right">
                    <b>
                        @php($m5 = explode(":",InformeController::conversor_segundos  ($horas_laboradas - $total_demora + $total_horaExtra)))
                        {{number_format( ($m5[0] + ($m5[1]/60) + ($m5[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
