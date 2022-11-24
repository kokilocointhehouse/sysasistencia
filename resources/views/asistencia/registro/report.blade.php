<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi asistencia de Hoy</title>
</head>

<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 0.85em;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    .data{
        /* background: rgb(146, 142, 142); */
        float: right;
        margin: 2% 0% 0% 0%;
    }
    tbody td {
        padding: 3px; border: 1px solid rgb(37, 87, 134);

    }

</style>
<body>
    <div>
        <img src="../public/logo/{{$empresa->Logo}}" alt="" width="80" height="80">
        <p class="data">
            {{$empresa->nomEmpresa}} <br>
            {{$empresa->Direccion}}
        </p>
    </div>
    <div  style="background: #163864; color: #ffffff;
    text-align: center; padding: 10px">
        <span>Informe de {{InformeController::fechaCastellano($informe->FechaRegistro)}} </span>
    </div>
    <div>
        <p>
            {{$usuario->Nombres}}
            <span style="float: right">{{InformeController::fechaCastellano($fecha)}}</span>
        </p>
    </div>
        <table>

            <tbody>
                <tr>
                    <td style="font-weight: bold">Hora de Entrada: </td>
                    <td><span>{{$informe->HoraEntrada}}</span></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Ubicación Entrada: </td>
                    <td><span>{{$informe->LatitudEntrada}},{{$informe->LongitudEntrada}}</span></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Estadeo de GPS Entrada: </td>
                    <td>
                        @if ($informe->Consideracion == 'CORRECTO')
                            <span style="color: #0a7a22; font-weight: bold">
                        @else
                            <span style="color: #ad211c; font-weight: bold">
                        @endif
                        {{$informe->Consideracion}}</span></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Captura Entrada: </td>
                    <td>
                        @if (!empty($informe->capturaEntrada))
                            <img src="../public/capturas_asistencia/{{$informe->capturaEntrada}}" alt="" width="80" height="80">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Tardanza: </td>
                    <td><span>
                        @if ($informe->HoraEntrada > $empresa->HoraEntrada)
                        {{RegistroController::RestarHoras($informe->HoraEntrada, $empresa->HoraEntrada)}}
                        @endif
                    </span></td>
                </tr>

                <tr>
                    <td style="font-weight: bold">Hora Salida: </td>
                    <td> <span>
                        @if (isset($informe->HoraSalida))
                            {{$informe->HoraSalida}}
                        @endif
                    </span></td>

                </tr>
                <tr>
                    <td style="font-weight: bold">Ubicación Salida: </td>
                    <td>
                        <span>
                            @if (isset($informe->HoraSalida))
                            {{$informe->LatitudSalida}},{{$informe->LongitudSalida}}
                            @else
                                No tiene registrado la Salida
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Estado del GPS Salida: </td>
                    <td>
                        @if ($informe->Consideracion2 == 'CORRECTO')
                            <span style="color: #0a7a22; font-weight: bold">
                        @else
                            <span style="color: #ad211c; font-weight: bold">
                        @endif
                            {{$informe->Consideracion2}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Captura Salida: </td>
                    <td>
                        @if (!empty($informe->capturaSalida))
                            <img src="../public/capturas_asistencia/{{$informe->capturaSalida}}" alt="" width="80" height="80">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Tiempo Laborado: </td>
                    <td>
                        <span>
                            @if (isset($informe->HoraSalida))
                            {{RegistroController::RestarHoras($informe->HoraEntrada, $informe->HoraSalida)}}
                            @else
                                No tiene registrado la Salida
                            @endif
                        </span>
                    </td>
                </tr>


            </tbody>
        </table>
</body>
</html>
