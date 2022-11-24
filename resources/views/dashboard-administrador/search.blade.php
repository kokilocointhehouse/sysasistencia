{!! Form::open(array('url'=>'dashboard-administrador', 'method'=>'GET', 'autocomplete'=>'off', 'role'=>'search')) !!}

<div class="card-header">
    {{-- <h3 class="card-title">Mis Asistencias</h3> --}}
    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 400px;">
            @if (empty($searchText))
                @php($searchText = $mes_ac)
            @endif
            @if (empty($searchText2))
                @php($searchText2 = date('Y'))
            @endif
            <a href="{{route('detalle_grafico.pdf', [$searchText, $searchText2])}}" target="_blank" title="Reporte en PDF"
                class="btn btn-default btn-sm" >
                <i class="fas fa-file-pdf" style="color: #d14949"></i></a>
            {{-- <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}"> --}}

            <select class="form-control searchText" name="searchText">
            @foreach($meses_disponibles as $md)
                @if ($md== $searchText)
                <option value="{{$md}}"selected >{{strtoupper($md)}}</option>
                @else
                <option value="{{$md}}">{{strtoupper($md)}}</option>
                @endif

            @endforeach
            </select>
            <select class="form-control searchText2" name="searchText2">
            @if (empty($searchText2))
                @php($searchText2 = date('Y'));
            @endif
            @foreach($anios_proximos as $ap)
                @if ($ap== $searchText2)
                <option value="{{$ap}}" selected>{{$ap}}</option>
                @else
                <option value="{{$ap}}">{{$ap}}</option>
                @endif
            @endforeach
            </select>

            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}

                {{-- @if($searchText == '')
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
                @endforeach --}}
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
