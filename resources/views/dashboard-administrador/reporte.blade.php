<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Gráfico</title>
    <style>
        body{
        font-family: Arial, Helvetica, sans-serif;
        /* font-size: 0.71em; */
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
        border: 1px solid rgb(117, 116, 116);
        }
        .data{
        float: right;
        display: block;
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
    text-align: center; padding: 10px; margin-bottom: 15px">
        <span>Informe Gráfico {{$query}} del {{$query2}} </span>
    </div>
    <table>
        <tr style="background: #343a40; color: #eeeeee;">
            <td>PERSONAL</td>
            @php($cont = 1)
            @foreach ($dias_mes_l as $dl)
                @if ($dl == 'DO' && $dia_ac != $cont)
                <td style="background: #5d6268; text-align: center">{{$dl}}</td>
                @elseif($dia_ac == $cont && (date('Y') == $anio_o || $anio_o == ''))
                <td style="background: #17a2b8; text-align: center">{{$dl}}</td>
                @else
                <td style="text-align: center">{{$dl}}</td>
                @endif
                @php($cont += 1)
            @endforeach
        </tr>
        <tr>
            <td></td>
        @foreach ($dias_mes_n as $dn)
            <td style="text-align: center">{{$dn}}</td>
        @endforeach
        </tr>
        <tr>
            @php($contador = 1)
            @php($t = count($asistencia))
            @foreach($asistencia as $a)
                @php($a = explode('_', $a))
                @if($a[0] == '*')
                <td title="ASISTENCIA" style="color: #128541; text-align: center; font-weight: bold">
                    A
                    @if ($a[2] == "si")
                        <span style="color: #f6920f">*</span>
                    @endif
                </td>
                @elseif($a[0] == 'F')
                <td title="FALTA" style="color: #d81616; text-align: center; font-weight: bold">
                    F
                </td>
                @elseif($a[0] == 'T')
                <td title="TARDE" style="color: #17a2b8; text-align: center; font-weight: bold">
                    T
                    @if ($a[2] == "si")
                        <span style="color: #f6920f">*</span>
                    @endif
                </td>
                @else
                <td  style="color: #292d2e; font-weight: bold">
                    {{$a[0]}}
                </td>
                @endif
                @if((($contador) % ($cant_dias+1)) == 0)
                </tr>
                <tr>
                @endif
                @php($contador +=1)
            @endforeach
                <td colspan="{{$cant_dias+1}}" style="border: 1px 0px 0px 0px solid rgb(117, 116, 116);"></td>

        </tr>
    </table>

    <br>
    @php($c = 1)
    <table>
        <tr style="background: #343a40; color: #eeeeee;">
            <td colspan="4">RESUMEN</td>
        </tr>
        <tr>
            <td>PERSONAL</td>
            <td align="center">ASISTENCIAS</td>
            <td align="center">TARDANZAS</td>
            <td align="center">FALTAS</td>
        </tr>
        <tr>
    @foreach ($estadistica as $item)
        @php($est = explode(' ', $item))
        @if(count($est) >= 2)
            @if($est[1] == 'Asistencias')
                <td align="center"><i class="fas fa-check" style="margin-right: 10px;
                    color: #2fa861;"></i>
                        {{$est[0]}}
                </td>
            @elseif($est[1] == 'Tardanza')
                <td align="center"><span style="margin-right: 5px; font-weight: bold;
                    color: #17a2b8;">T</span>
                    {{$est[0]}}
                </td>
            @elseif($est[1] == 'Faltas')
                <td align="center"><i class="fas fa-times" style="margin-right: 10px;
                    color: #d81616;"></i>{{$est[0]}}</td>
            @else
                <td style="font-weight: bold">{{$item}}</td>
            @endif
        @else
            <td style="font-weight: bold">{{$item}}</td>
        @endif
        @if ($c % 4 == 0)
        </tr>
        <tr>
        @endif
        @php($c += 1)
    @endforeach
            <td colspan="4" style="border: 1px 0px 0px 0px solid rgb(117, 116, 116);">
            </td>
        </tr>
    </table>
</body>
</html>
