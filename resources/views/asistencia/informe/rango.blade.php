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
            font-size: 0.75em;
        }
        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
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
    <div class="encabezado" style="background: #163864; color: #ffffff;
    text-align: center; padding: 10px">
        <span>Informe del {{InformeController::fechaCastellano($id)}} al {{InformeController::fechaCastellano($id2)}}</span>
    </div>

    <div>
        <p>
            @if ($id3 != '')
                {{$usuario->Nombres}}
            @endif
            .
            <span style="float: right">
                {{InformeController::fechaCastellano($fecha)}}
                {{-- <span>M</span> --}}
            </span></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                @if ($id3 == '')
                <th>Nombres</th>
                @endif
                <th>Fecha Entrada</th>
                <th>H. Entrada</th>
                <th>Ubic. Entrada</th>
                <th>H. Salida</th>
                <th>Ubic. Salida</th>
                <th>Tardanza</th>
                <th>Hora Extra</th>
                <th>T. Laborado</th>
            </tr>
        </thead>
        <tbody>
            @php($i = 0)
            @php($correcto = 0)
            @php($incorrecto = 0)
            @php($correcto2 = 0)
            @php($incorrecto2 = 0)
            @php($total_demora = 0)
            @php($total_horaExtra = 0)
            @php($horas_laboradas = 0)
            @foreach ($informe as $item)
            @php($tardanza = '0000-00-00')
            <tr>
                <td>{{$i +=1}}</td>
                {{-- <td>{{$item->IdRegistro}}</td> --}}
                @if ($id3 == '')
                @php($nom = explode(' ', $item->Nombres))
                <td>
                    @if (count($nom) > 2)
                        {{$nom[0]}} {{$nom[1]}}
                    @else
                        {{$item->Nombres}}
                    @endif
                </td>
                @endif
                <td>
                    {{InformeController::fechaCastellano($item->FechaRegistro)}}
                    @if ($item->EncargadoUpdt)
                        <span style="color: #db6606; font-weight: bold">M</span>
                    @endif
                </td>
                <td align="center">{{$item->HoraEntrada}} </td>
                <td>
                    @if ($item->Consideracion == 'CORRECTO')
                    <span style="color: #2b905d">
                        {{$item->Consideracion}}
                    </span>
                        @php($correcto +=1)
                    @else
                        <span style="color: #f03f3f">F. DE RANGO</span>
                        @php($incorrecto +=1)
                    @endif
                </td>
                <td align="center">
                    @if (isset($item->HoraSalida))
                        {{$item->HoraSalida}}
                    @else
                        ...
                    @endif

                </td>
                <td>
                    @if (isset($item->Consideracion2))
                        @if ($item->Consideracion2 == 'CORRECTO')
                            <span style="color: #2b905d">{{$item->Consideracion2}}</span>
                            @php($correcto2 +=1)
                        @else
                            <span style="color: #f03f3f">F. DE RANGO</span>
                            @php($incorrecto2 +=1)
                        @endif
                    @else
                        ...
                    @endif
                </td>
                <td align="center">
                    @if ($item->HoraEntrada <= $empresa->HoraEntrada)
                        <span>...</span>
                    @else
                    <span style="color: #f03f3f">{{RegistroController::RestarHoras($item->HoraEntrada, $empresa->HoraEntrada)}}
                    </span>
                    @php($m = explode(":", RegistroController::RestarHoras($item->HoraEntrada, $empresa->HoraEntrada)))
                    @php($total_demora += ($m[0] * 3600) + ($m[1] * 60) + $m[2])
                    @endif
                </td>
                <td align="center" style="color:#2b905d">
                    @if ($item->HoraSalida > $empresa->HoraSalida)
                        @php($horaExtra = RegistroController::RestarHoras($item->HoraSalida, $empresa->HoraSalida))
                        {{$horaExtra}}
                        @php($horaExtra = explode(":", $horaExtra))
                        @php($total_horaExtra += ($horaExtra[0] * 3600) + ($horaExtra[1] * 60) + $horaExtra[2])
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
            @endforeach
            <tr>
                @if ($id3 == '')
                <td colspan="4" style="border: 0px"></td>
                @else
                <td colspan="3" style="border: 0px"></td>
                @endif
                <td align="center">{{$correcto}} C. / {{$incorrecto}} F.</td>
                <td style="border: 0px"></td>
                <td align="center">{{$correcto2}} C. / {{$incorrecto2}} F.</td>
                <td align="center"><b>{{InformeController::conversor_segundos ($total_demora)}}</b></td>
                <td align="center"><b>{{InformeController::conversor_segundos ($total_horaExtra)}}</b></td>
                <td align="center"><b>{{InformeController::conversor_segundos ($horas_laboradas)}}</b></td>
            </tr>
            @if (!empty($id3))
            <tr>
                <td colspan="7" style="border: 0px"></td>
                <td align="center"><b>Pago T. Laborado</b></td>
                <td align="center">
                    <b>
                        @php($m3 = explode(":",InformeController::conversor_segundos  ($horas_laboradas)))
                        {{number_format( ($m3[0] + ($m3[1]/60) + ($m3[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: 0px"></td>
                <td align="center"><b>Desc. Tardanza</b></td>
                <td align="center">
                    <b>
                        @php($m5 = explode(":",InformeController::conversor_segundos  ($total_demora)))
                       - {{number_format( ($m5[0] + ($m5[1]/60) + ($m5[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: 0px"></td>
                <td align="center"><b>Pago Hora Extra</b></td>
                <td align="center">
                    <b>
                        @php($m6 = explode(":",InformeController::conversor_segundos  ($total_horaExtra)))
                        + {{number_format( ($m6[0] + ($m6[1]/60) + ($m6[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="7" style="border: 0px"></td>
                <td align="center"><b>Monto a Pagar </b></td>
                <td align="center">
                    <b>
                        @php($m4 = explode(":",InformeController::conversor_segundos  ($horas_laboradas - $total_demora + $total_horaExtra)))
                        {{number_format( ($m4[0] + ($m4[1]/60) + ($m4[2]/3600)) * $usuario->pagoHora, 2)}}

                    </b>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
