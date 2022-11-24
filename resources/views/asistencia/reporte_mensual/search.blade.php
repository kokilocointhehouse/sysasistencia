{!! Form::open(['url' => 'asistencia/reporte_mensual', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    {{-- <h3 class="card-title">Mis Asistencias</h3> --}}
    {{-- <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 550px;"> --}}
    <div class="card-body">
        <div class="row">
            @if ($searchText3 == '')
                @php($searchText3 = 'NADA')
            @endif
            @if ($searchText3 != 'NADA')
                <div class="col-md-2">
                <a href="{{ route('reporte_mensual.excel', [$searchText, $searchText2, $searchText3]) }}" target="_blank"
                    title="Reporte en Documento de Excel" class="btn btn-default btn-sm">
                    <i class="fas fa-file-excel" style="color: #0da358"></i></a>
                <a href="{{ route('reporte_mensual.pdf', [$searchText, $searchText2, $searchText3]) }}" target="_blank"
                    title="Reporte en PDF" class="btn btn-default btn-sm">
                    <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
                </div>
            @endif
            {{-- <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}"> --}}
            <div class="col-md-3">
                <select name="searchText3" id="" class="form-control">
                    <option value="NADA">SELECCIONA..</option>
                    @foreach ($usuario as $item)
                        @if ($searchText3 == $item->IdUsuario)
                            <option value="{{ $item->IdUsuario }}" selected>{{ $item->Nombres }} </option>
                        @else
                            <option value="{{ $item->IdUsuario }}">{{ $item->Nombres }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="searchText2" id="" class="form-control">
                    @if ($searchText2 == '')
                        @php($searchText2 = date('Y'))
                    @endif
                    @foreach ($anios_vista as $item)
                        @if ($searchText2 == $item)
                            <option value="{{ $item }}" selected>{{ $item }}</option>
                        @else
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <div class="col-md-3">
                <select name="searchText" id="" class="form-control">
                    @if ($searchText == '')
                        @php($searchText = date('m'))
                    @endif
                    @php($cont = 1)
                    @foreach ($meses as $item)
                        @if ($searchText == $cont)
                            <option value="{{ $cont }}" selected>{{ $item }}</option>
                        @else
                            <option value="{{ $cont }}">{{ $item }}</option>
                        @endif

                        @php($cont += 1)
                    @endforeach
                </select>
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
    {{-- </div>
    </div> --}}
</div>

{{ Form::close() }}
