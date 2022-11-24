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
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.mensual.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="htable" style="background: #eaf3fa; color: #12446b">
                            {{-- <th>Id</th> --}}
                            <th>N°</th>
                            <th>Fecha Entrada</th>
                            <th>Hora Entrada</th>
                            <th> <span title="Ubicación Entrada">Ubic. Entrada</span> </th>
                            <th>Hora Salida</th>
                            <th> <span title="Ubicación Salida">Ubic. Salida</span> </th>
                            <th>Tardanza</th>
                            <th style="text-align: center">Hora Extra</th>
                            <th>Tiempo Laborado</th>
                        </thead>
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
                        @if (date('Y-m-d', strtotime($valor_item[0]))== date('Y-m-d', strtotime($fecha)))
                        <tr  style="background: #d0f0f5">
                        @else
                        <tr >
                        @endif
                            <td >{{$contador}}</td>
                            <td>{{InformeController::fechaCastellano($valor_item[0])}}</td>
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
                            <td >
                                @if (!empty($valor_item[3]))
                                    {{$valor_item[3]}}
                                @else
                                    ...
                                @endif
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
                            <td >
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
                            <td>
                                @if ($valor_item[3] != 0)
                                        {{RegistroController::RestarHoras($valor_item[1], $valor_item[3])}}
                                        @php($m2 = explode(":", RegistroController::RestarHoras($valor_item[1], $valor_item[3])))
                                        @php($horas_laboradas += ($m2[0] * 3600) + ($m2[1] * 60) + $m2[2])
                                    @else
                                    <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                                 @endif
                            </td>
                            {{-- <td style="text-align: right">S/ {{number_format(floatval($valor_item[1]) + floatval($valor_item[2]), 2)}}</td> --}}
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
                            <td>
                                <span class="badge bg-success" title="{{$correcto2}} Ubicación(es) Correcta(s)">
                                    {{$correcto2}}
                                    <i class="fas fa-check"></i></span>
                                / <span class="badge bg-danger" title="{{$incorrecto2}} Ubicación(es) Incorrecta(s) 'Fuera de Rango'">
                                        {{$incorrecto2}}
                                    <i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i>
                                </span>

                            </td>
                            <td class="text-danger"><b>{{InformeController::conversor_segundos  ($total_demora)}}</b></td>
                            <td class="text-success" align="center"><b>{{InformeController::conversor_segundos  ($total_horaExtra)}}</b> </td>
                            <td class="text-primary"><b>
                                {{InformeController::conversor_segundos  ($horas_laboradas)}}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    {{-- @push('scripts')

@endpush --}}

@endsection

