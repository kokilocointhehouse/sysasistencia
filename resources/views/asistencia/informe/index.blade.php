<?php use App\Http\Controllers\InformeController; ?>
<?php use App\Http\Controllers\RegistroController; ?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Informe de mis Asistencias</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                    @include('asistencia.informe.search')
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead style="background: #eaf3fa; color: #12446b">
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>Fecha Entrada</th>
                                <th title="Hora de Entrada" style="text-align: center" >H. Entrada</th>
                                <th><span title="Ubicación de Entrada"> U. Entrada</span></th>
                                <th title="Hora de Salida" style="text-align: center">H. Salida</th>
                                <th style="text-align: center"><span title="Ubicación de Salida"> U. Salida</span></th>
                                <th style="text-align: center">Tardanza</th>
                                <th style="text-align: center">Hora Extra</th>
                                <th style="text-align: center">Tiempo Laborado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($informe as $item)
                            <tr >
                                {{-- <td>{{$item->IdRegistro}}</td> --}}
                                <td>{{InformeController::fechaCastellano($item->FechaRegistro)}}</td>
                                <td align="center">{{$item->HoraEntrada}} </td>
                                <td align="center">
                                    @if ($item->Consideracion == 'CORRECTO')
                                    <span class="badge bg-success" title="Ubicación Correcta">
                                    <a href="//www.google.com/maps/search/{{$item->LatitudEntrada}},{{$item->LongitudEntrada}}"
                                    target="_black"><i class="fas fa-check"></i></a></span>
                                    @else
                                    <span class="badge bg-danger" title="Ubicación se encuentra fuera de rango">
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
                                        <span class="badge bg-danger" title="Ubicación se encuentra fuera de rango">
                                        <a href="//www.google.com/maps/search/{{$item->LatitudSalida}},{{$item->LongitudSalida}}"
                                        target="_black"><i  style="padding: 0 3px 0 3px" class="fas fa-exclamation"></i></a></span>
                                        @endif
                                    @else
                                    ...
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
                                    @if ($item->HoraSalida > $item->HoraSalida)
                                    {{RegistroController::RestarHoras($item->HoraSalida, $item->HoraSalida)}}
                                    @endif
                                </td>
                                <td align="center">
                                    {{-- @if ($fecha == $item->FechaRegistro)
                                    <span class="badge bg-teal" style="float: right">Nuevo</span>
                                    @endif --}}
                                    @if (isset($item->HoraSalida))
                                        {{RegistroController::RestarHoras($item->HoraEntrada, $item->HoraSalida)}}
                                    @else
                                    <span title="Este registro no cuenta con una Hora de Salida. (SIN HORA DE SALIDA)">...</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{route('detalle.pdf',$item->IdRegistro)}}" target="_blank"
                                        class="btn btn-default btn-sm" style="float: right"><i class="fa fa-print" aria-hidden="true"></i></a>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{$informe->appends(['searchText' => $searchText])}}
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@push ('scripts')
@if (Session::has('success'))
<script>
    toastr.success('{{ Session::get('success') }}', 'Operación Correcta',  { "positionClass" : "toast-top-right"})
</script>
@endif
@endpush
@endsection
