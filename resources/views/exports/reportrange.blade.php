<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Asistencias</title>
    <style>
        th {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th
                @if($id3 == '')
                 colspan="11"
                @else
                colspan="10"
                 @endif
                 style="background: #163864; color: #ffffff;
                text-align: center; height: 20px;">
                    <span>
                        Informe del {{InformeController::fechaCastellano($id)}} al {{InformeController::fechaCastellano($id2)}}
                    </span>
                </th>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                @if($id3 == '')
                <th colspan="4"></th>
                @else
                <th colspan="5">
                    {{$usuario->Nombres}}
                </th>
                @endif

                <th>

                </th>
                @if($id3 == '')
                <th colspan="4" align="right">
                @else
                <th colspan="3" align="right">
                @endif
                    {{InformeController::fechaCastellano($fecha)}}
                </th>

            </tr>
        </thead>
    </table>
    <table>
        <thead>
        <tr>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >N°</th>
            @if($id3 == '')
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Nombres</th>
            @endif
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " colspan="2" >Fecha Entrada</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Hora Entrada</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Ubicación Entrada</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Hora Salida</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Ubicación Salida</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Tardanza</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >Hora Extra</th>
            <th style="border: 1px solid #1e1e20; font-weight: bold; background: #eaf3fa; color: #12446b " >T. Laborado</th>
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
            <tr>
                <td style="border: 1px solid #1e1e20">{{$i +=1}}</td>
                @if($id3 == '')
                <td style="border: 1px solid #1e1e20;  " >{{$item->Nombres}}</td>
                @endif
                {{-- <td>{{$item->IdRegistro}}</td> --}}
                <td style="border-bottom: 1px solid #1e1e20">
                    {{InformeController::fechaCastellano($item->FechaRegistro)}}

                </td>
                <td style="border-bottom: 1px solid #1e1e20;color:#f07603">
                    @if (isset($item->EncargadoUpdt))
                    M
                    @endif
                </td>
                <td align="center" style="border: 1px solid #1e1e20">{{$item->HoraEntrada}} </td>
                @if ($item->Consideracion == 'CORRECTO')
                    <td style="border: 1px solid #1e1e20; color: #338a54" >
                    {{$item->Consideracion}}
                    @php($correcto +=1)
                @else
                    <td style="border: 1px solid #1e1e20; color: #cc2c2c">
                    {{$item->Consideracion}}
                    @php($incorrecto +=1)
                @endif
                </td>
                <td align="center" style="border: 1px solid #1e1e20">
                    @if (isset($item->HoraSalida))
                        {{$item->HoraSalida}}
                    @else
                        ...
                    @endif

                </td>
                @if ($item->Consideracion2 == 'CORRECTO')
                    <td style="border: 1px solid #1e1e20; color: #338a54" >
                    {{$item->Consideracion2}}
                    @php($correcto2 +=1)
                @elseif($item->Consideracion2 == 'FUERA DE RANGO')
                    <td style="border: 1px solid #1e1e20; color: #cc2c2c">
                    {{$item->Consideracion2}}
                    @php($incorrecto2 +=1)
                @else
                    <td style="border: 1px solid #1e1e20">
                    ...
                @endif
                </td>
                @if ($item->HoraEntrada <= $empresa->HoraEntrada)
                    <td align="center" style="border: 1px solid #1e1e20">
                    <span>...</span>
                 @else
                    <td align="center" style="border: 1px solid #1e1e20; color: #cc2c2c">
                    {{RegistroController::RestarHoras($item->HoraEntrada, $empresa->HoraEntrada)}}
                    @php($m = explode(":", RegistroController::RestarHoras($item->HoraEntrada, $empresa->HoraEntrada)))
                    @php($total_demora += ($m[0] * 3600) + ($m[1] * 60) + $m[2])
                @endif
                </td>
                <td align="center" style="color:#2b905d; border: 1px solid #1e1e20">
                    @if ($item->HoraSalida > $empresa->HoraSalida)
                        @php($horaExtra = RegistroController::RestarHoras($item->HoraSalida, $empresa->HoraSalida))
                        {{$horaExtra}}
                        @php($horaExtra = explode(":", $horaExtra))
                        @php($total_horaExtra += ($horaExtra[0] * 3600) + ($horaExtra[1] * 60) + $horaExtra[2])
                    @endif
                </td>
                <td align="center" style="border: 1px solid #1e1e20">
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
                @if($id3 == '')
                <td colspan="5"></td>
                @else
                <td colspan="4"></td>
                @endif

                <td align="center" style="border: 1px solid #1e1e20; font-weight: bold">{{$correcto}}
                     C. / {{$incorrecto}} F.</td>
                <td>
                </td>
                <td align="center" style="border: 1px solid #1e1e20; font-weight: bold">{{$correcto2}}
                    C. / {{$incorrecto2}} F.</td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>{{InformeController::conversor_segundos ($total_demora)}}</b></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>{{InformeController::conversor_segundos ($total_horaExtra)}}</b></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>{{InformeController::conversor_segundos ($horas_laboradas)}}</b></td>
            </tr>
            @if (!empty($id3))
            <tr>
                <td colspan="8" ></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>Pago T. Laborado</b></td>
                <td align="right" style="border: 1px solid #1e1e20;">
                    <b>
                        @php($m3 = explode(":",InformeController::conversor_segundos  ($horas_laboradas)))
                        {{number_format( ($m3[0] + ($m3[1]/60) + ($m3[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="8" ></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>Desc. Tardanza</b></td>
                <td align="right" style="border: 1px solid #1e1e20;">
                    <b>
                        @php($m5 = explode(":",InformeController::conversor_segundos  ($total_demora)))
                        {{number_format( ($m5[0] + ($m5[1]/60) + ($m5[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="8" ></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>Pago Hora Extra</b></td>
                <td align="right" style="border: 1px solid #1e1e20;">
                    <b>
                        @php($m7 = explode(":",InformeController::conversor_segundos  ($total_horaExtra)))
                        {{number_format( ($m7[0] + ($m7[1]/60) + ($m7[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="8" ></td>
                <td align="center" style="border: 1px solid #1e1e20;"><b>Monto a Pagar</b></td>
                <td align="right" style="border: 1px solid #1e1e20;">
                    <b>
                        @php($m6 = explode(":",InformeController::conversor_segundos  ($horas_laboradas - $total_demora + $total_horaExtra)))
                        {{number_format( ($m6[0] + ($m6[1]/60) + ($m6[2]/3600)) * $usuario->pagoHora, 2)}}
                    </b>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
