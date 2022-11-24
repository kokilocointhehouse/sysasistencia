<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Reporte Mensual</h3>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Buttons</li>
                    </ol>
                </div> --}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('asistencia.reporte_mensual.search')
                <div class="card-body table-responsive p-0">

                @if ($searchText3 != '' && $searchText3 != 'NADA')
                    <table class="table table-hover text-nowrap">
                        <thead style="background: #eaf3fa; color: #12446b">
                            {{-- <th>Id</th> --}}
                            <th>N°</th>
                            <th>Fecha Entrada</th>
                            <th style="text-align: center">Hora Entrada</th>
                            <th style="text-align: center">Ubic. Entrada</th>
                            <th style="text-align: center">Hora Salida</th>
                            <th style="text-align: center">Ubic. Salida</th>
                            <th style="text-align: center">Tardanza</th>
                            <th style="text-align: center">Hora Extra</th>
                            <th style="text-align: center">Tiempo Laborado</th>

                        </thead>
                    @php($asistencia = 0)
                    @php($contador = 1)
                    @php($correcto = 0)
                    @php($correcto2 = 0)
                    @php($total_demora = 0)
                    @php($total_horaExtra = 0)
                    @php($horas_laboradas = 0)
                    @php($incorrecto = 0)
                    @php($incorrecto2 = 0)
                    @foreach ($array_fechas as $item)
                    @php($valor_item = explode('_', $item))
                        @if (date('Y-m-d', strtotime($valor_item[0]))== date('Y-m-d', strtotime($fecha)))
                        <tr  style="background: #d0f0f5">
                        @else
                        <tr>
                        @endif
                            <td >{{$contador++}}</td>
                            <td>{{InformeController::fechaCastellano($valor_item[0])}}
                            @if ($valor_item[1] != 0 && $valor_item[9] != '')
                                <span  title="Registro Modificado."
                                style="color: #e66108; font-weight: bold; margin-left: 10px">M</span>
                            @endif
                            </td>
                            <td align="center">
                            @if ($valor_item[1] != 0)
                                {{$valor_item[1]}}
                                @php($asistencia += 1)
                            @else
                                ...
                            @endif
                            </td>
                            <td align="center">
                                @if (!empty($valor_item[2]))

                                    @if ($valor_item[2] == 'CORRECTO')
                                        <span class="badge bg-success" title="Ubicación Correcta">
                                        <a href="//www.google.com/maps/search/{{$valor_item[5]}},{{$valor_item[6]}}"
                                            target="_black">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        </span>
                                        @php($correcto +=1)
                                    @else
                                        <span class="badge bg-danger" title="Ubicación se encuentra fuera de rango.">
                                        <a href="//www.google.com/maps/search/{{$valor_item[5]}},{{$valor_item[6]}}"
                                            target="_black">
                                            <i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i>
                                        </a>
                                        </span>
                                        @php($incorrecto +=1)
                                    @endif
                                @else
                                    ...
                                @endif
                            </td>
                            <td align="center">
                                {{$valor_item[3]}}
                                {{-- @if (isset($valor_item[1]))
                                    {{$valor_item[1]}}
                                    @php($asistencia += 1)
                                    @php($m2 = explode(":", $valor_item[1]))
                                    @php($horas_laboradas += ($m2[0] * 3600) + ($m2[1] * 60) + $m2[2])
                                @endif --}}
                            </td>
                            <td align="center">
                                @if (!empty($valor_item[3]))
                                    @if ($valor_item[4] == 'CORRECTO')
                                        <span class="badge bg-success" title="Ubicación Correcta">
                                        <a href="//www.google.com/maps/search/{{$valor_item[7]}},{{$valor_item[8]}}"
                                            target="_black"><i class="fas fa-check"></i></a>
                                            </span>
                                        @php($correcto2 +=1)
                                    @else
                                        <span class="badge bg-danger" title="Ubicación se encuentra fuera de rango.">
                                            <a href="//www.google.com/maps/search/{{$valor_item[7]}},{{$valor_item[8]}}"
                                            target="_black">
                                            <i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i>
                                            </a>
                                        </span>
                                        @php($incorrecto2 +=1)
                                    @endif
                                @else
                                    ...
                                @endif
                            </td>
                            <td align="center">
                                @if ($valor_item[1] > $empresa->HoraEntrada && !empty($valor_item[1]))
                                    <span class="text-danger"> {{RegistroController::RestarHoras($valor_item[1], $empresa->HoraEntrada)}}</span>
                                    @php($m = explode(":", RegistroController::RestarHoras($valor_item[1], $empresa->HoraEntrada)))
                                    @php($total_demora += ($m[0] * 3600) + ($m[1] * 60) + $m[2])
                                @else
                                    <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                                @endif
                            </td>
                            <td align="center">
                                @if ($valor_item[3] > $empresa->HoraSalida && !empty($valor_item[3]))
                                    <span class="text-success"> {{RegistroController::RestarHoras($valor_item[3], $empresa->HoraSalida)}}</span>
                                    @php($m3 = explode(":", RegistroController::RestarHoras($valor_item[3], $empresa->HoraSalida)))
                                    @php($total_horaExtra += ($m3[0] * 3600) + ($m3[1] * 60) + $m3[2])
                                @endif
                            </td>
                            <td align="center">
                                @if ($valor_item[3] != 0)
                                    {{RegistroController::RestarHoras($valor_item[1], $valor_item[3])}}
                                    @php($m2 = explode(":", RegistroController::RestarHoras($valor_item[1], $valor_item[3])))
                                    @php($horas_laboradas += ($m2[0] * 3600) + ($m2[1] * 60) + $m2[2])
                                @else
                                    <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                                 @endif
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="3"><b>{{$asistencia}} registros encontrados en este mes.</b></td>
                            <td align="center"><span class="badge bg-success" title="{{$correcto}} Ubicación(es) Correcta(s)">
                                {{$correcto}}
                                <i class="fas fa-check"></i></span>
                                / <span class="badge bg-danger" title="{{$incorrecto}} Ubicación(es) Incorrecta(s) 'Fuera de Rango'">
                                    {{$incorrecto}}
                                <i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i>
                                </span>
                            </td>
                            <td></td>
                            <td align="center">
                                <span class="badge bg-success" title="{{$correcto2}} Ubicación(es) Correcta(s)">
                                    {{$correcto2}}
                                    <i class="fas fa-check"></i></span>
                                / <span class="badge bg-danger" title="{{$incorrecto2}} Ubicación(es) Incorrecta(s) 'Fuera de Rango'">
                                        {{$incorrecto2}}
                                    <i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i>
                                </span>
                            </td>
                            <td class="text-danger" align="center"><b>
                                {{InformeController::conversor_segundos  ($total_demora)}}</b></td>
                            <td class="text-success" align="center"><b>{{InformeController::conversor_segundos  ($total_horaExtra)}}</b> </td>
                            <td class="text-primary" align="center"><b>
                                {{InformeController::conversor_segundos  ($horas_laboradas)}}</b></td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- @push('scripts')

@endpush --}}

@endsection

