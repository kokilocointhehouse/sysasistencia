{!! Form::open(['url' => 'reporte/mis_pagos', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">

    {{-- <h3 class="card-title">Tabla de Asistencias</h3> --}}
    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 650px;">
            <a href="{{route('pago.pdf',[$searchText, $searchText2, auth()->user()->Nombres])}}" target="_blank" title="Reporte en PDF"
                class="btn btn-default btn-sm" >
                <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
            <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}">
            <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
