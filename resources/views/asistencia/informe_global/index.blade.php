<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Informe General de Asistencias</h3>
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
                    @include('asistencia.informe_global.search')
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead style="background: #eaf3fa; color: #12446b">
                            <tr>
                                {{-- <th>N°</th> --}}
                            @if($searchText3 == '' || $searchText3 == 'TODO')
                                <th>Personal</th>
                            @endif
                                <th>Fecha Entrada</th>
                                <th title="Hora de Entrada" style="text-align: center">H. Entrada</th>
                                <th title="Ubicación de Entrada">U. Entrada</th>
                                <th title="Hora de Salida" style="text-align: center">H. Salida</th>
                                <th title="Ubicación de Salida">U. Salida </th>
                                <th style="text-align: center">Tardanza</th>
                                <th>Hora Extra</th>
                                <th style="text-align: center" title="Tiempo Laborado">T. Laborado</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>

                            @php($contador = 1)
                            @foreach ($informe as $item)
                            <tr>
                            @if($searchText3 == '' || $searchText3 == 'TODO')
                                <td>
                                    @php($n = explode(" ", strtoupper($item->Nombres)))
                                    @if (count($n) > 2)
                                        {{$n[0]}} {{$n[1]}}
                                    @else
                                        {{$item->Nombres}}
                                    @endif
                                </td>
                            @endif
                                <td>
                                    {{InformeController::fechaCastellano($item->FechaRegistro)}}
                                    @if (isset($item->EncargadoUpdt))
                                        <span title="Registro Modificado por el Administrador" style="
                                        color: #f07603; font-weight: bold; ">
                                        M</span>
                                    @endif
                                </td>
                                <td align="center">{{$item->HoraEntrada}} </td>
                                <td align="center">
                                    @if ($item->Consideracion == 'CORRECTO')
                                    <span class="badge bg-success" title="Ubicación Correcta">
                                    <a href="//www.google.com/maps/search/{{$item->LatitudEntrada}},{{$item->LongitudEntrada}}"
                                    target="_black"><i class="fas fa-check"></i></a></span>
                                    @else
                                    <span class="badge bg-danger" title="Ubicación F. de Rango">
                                    <a href="//www.google.com/maps/search/{{$item->LatitudEntrada}},{{$item->LongitudEntrada}}"
                                    target="_black"><i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i></a></span>
                                    @endif
                                </td>

                                <td align="center">
                                    @if (isset($item->HoraSalida))
                                        {{$item->HoraSalida}}
                                    @endif
                                </td>
                                <td align="center">
                                    @if (isset($item->Consideracion2))
                                        @if ($item->Consideracion2 == 'CORRECTO')
                                        <span class="badge bg-success" title="Ubicación Correcta">
                                        <a href="//www.google.com/maps/search/{{$item->LatitudSalida}},{{$item->LongitudSalida}}"
                                        target="_black"><i class="fas fa-check"></i></a></span>
                                        @else
                                        <span class="badge bg-danger" title="Ubicación F. de Rango">
                                        <a href="//www.google.com/maps/search/{{$item->LatitudSalida}},{{$item->LongitudSalida}}"
                                        target="_black"><i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i></a></span>
                                        @endif
                                    @endif
                                </td>
                                <td align="center">
                                    @if ($item->HoraEntrada <= $empresa->HoraEntrada)
                                        <span  title="En esta fecha no llegaste tarde. (SIN TARDANZA)">
                                        ...</span>
                                    @else
                                    <span  class="text-danger" title="La tardanza se calcula a partir de la hora de entrada ({{$empresa->HoraEntrada}}) establecida por el Administrador.">
                                        {{RegistroController::RestarHoras($item->HoraEntrada, $empresa->HoraEntrada)}}</span>
                                    @endif
                                </td>
                                <td align="center" class="text-success">
                                    @if ($item->HoraSalida > $empresa->HoraSalida)
                                    {{RegistroController::RestarHoras($item->HoraSalida, $empresa->HoraSalida)}}
                                    @endif
                                </td>
                                <td align="center">
                                    @if (isset($item->HoraSalida))
                                        {{RegistroController::RestarHoras($item->HoraEntrada, $item->HoraSalida)}}
                                    @else
                                    <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <a href="{{route('detalle.pdf',$item->IdRegistro)}}" target="_blank"
                                        class="btn btn-default btn-sm" >
                                        <i class="fa fa-print" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{$informe->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3])}}
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    {{-- @push('scripts')

@endpush --}}

@endsection
