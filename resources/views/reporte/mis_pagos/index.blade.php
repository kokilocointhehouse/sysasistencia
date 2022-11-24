<?php use App\Http\Controllers\InformeController; ?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Informe de Pagos</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                    @include('reporte.mis_pagos.search')
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead style="background: #eaf3fa; color: #12446b">
                            <tr>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pago as $item)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($item->fecha))}}</td>
                                <td>{{strtoupper($item->nota)}} </td>
                                <td style="text-align: right">
                                    $Dolares {{$item->monto}}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{$pago->appends(['searchText' => $searchText, 'searchText2' => $searchText2])}}
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    {{-- @push('scripts')

@endpush --}}

@endsection
