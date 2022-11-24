{!! Form::open(['url' => 'caja/pago', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">

    <a href="pago/create" class="btn btn-default" >
        <i class="fas fa-plus-circle" style="color: #0da358"></i>
    </a>
    {{-- <h3 class="card-title">Tabla de Asistencias</h3> --}}
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            @if (empty($searchText3))
                @php($searchText3 = 'TODO')
            @endif
            <a href="{{route('pago.pdf',[$searchText, $searchText2, $searchText3])}}" target="_blank" title="Reporte en PDF"
                class="btn btn-default btn-sm" >
                <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
            <select name="searchText3" id="" class="form-control">
                <option value="TODO">MOSTRAR TODO</option>
                @foreach ($usuario as $item)
                    @if ($item->Nombres == $searchText3)
                        <option value="{{$item->Nombres}}" selected>{{$item->Nombres}}</option>
                    @else
                        <option value="{{$item->Nombres}}">{{$item->Nombres}}</option>
                    @endif
                @endforeach
            </select>
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
