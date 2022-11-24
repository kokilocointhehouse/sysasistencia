{!! Form::open(array('url'=>'reporte/mensual','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="card-header">
    {{-- <h3 class="card-title">Mis Asistencias</h3> --}}
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            <a href="{{route('reporte_mensual.excel',[$searchText, $searchText2, auth()->user()->IdUsuario])}}" target="_blank" title="Reporte en Documento de Excel"
                class="btn btn-default btn-sm">
                <i class="fas fa-file-excel" style="color: #0da358"></i></a>
            <a href="{{route('reporte_mensual.pdf',[$searchText, $searchText2, auth()->user()->IdUsuario])}}" target="_blank" title="Reporte en PDF"
                class="btn btn-default btn-sm" >
                <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
            {{-- <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}"> --}}
            <select name="searchText2" id="" class="form-control">
                @if($searchText2 == '')
                    @php($searchText2 = date('Y'))
                @endif
                @foreach ($anios_vista as $item)
                    @if ($searchText2 == $item)
                        <option value="{{$item}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$item}}" >{{$item}}</option>
                    @endif
                @endforeach
            </select>
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <select name="searchText" id="" class="form-control">
                @if($searchText == '')
                    @php($searchText = date('m'))
                @endif
                @php($cont = 1)
                @foreach ($meses as $item)
                    @if ($searchText == $cont)
                        <option value="{{$cont}}" selected>{{$item}}</option>
                    @else
                        <option value="{{$cont}}" >{{$item}}</option>
                    @endif

                    @php($cont += 1)
                @endforeach
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{Form::close()}}
