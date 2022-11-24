{!! Form::open(['url' => 'asistencia/informe_global', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">

    {{-- <h3 class="card-title">Tabla de Asistencias</h3> --}}






</div>
<div class="card-body">
    <div class="row">
        @if (empty($searchText3))
            @php($searchText3 = 'TODO')
        @endif
        <div class="col-md-2">
            <a href="{{route('rango_fecha.excel',[$searchText, $searchText2, $searchText3])}}" target="_blank" title="Reporte en Documento de Excel"
            class="btn btn-default btn-sm">
            <i class="fas fa-file-excel" style="color: #0da358"></i></a>
            <a href="{{route('rango_fecha.pdf',[$searchText, $searchText2, $searchText3])}}" target="_blank" title="Reporte en PDF"
            class="btn btn-default btn-sm" >
            <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
        </div>
        <div class="col-md-3">
            <select name="searchText3" id="" class="form-control">
                <option value="TODO">MOSTRAR TODO</option>
                @foreach ($usuario as $item)
                    @if ($item->IdUsuario == $searchText3)
                        <option value="{{$item->IdUsuario}}" selected>{{$item->Nombres}}</option>
                    @else
                        <option value="{{$item->IdUsuario}}">{{$item->Nombres}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}">
        </div>
        <div class="col-md-3">
            <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}">
        </div>
        <div class="col-md-1">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
