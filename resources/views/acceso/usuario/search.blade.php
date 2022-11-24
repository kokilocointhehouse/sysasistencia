{!! Form::open(['url' => 'acceso/usuarios', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    {{-- <h3 class="card-title">Tabla de Usuarios</h3> --}}
    <a class="btn btn-default btn-sm" href="" data-target="#modal-add" data-toggle="modal">
        <i class="fas fa-user-plus" style="color: #0da358"></i>
    </a>
    <div class="card-tools">
        <div class="input-group input-group-sm" >

            <input type="text" name="searchText"
            class="form-control float-right" value="{{$searchText}}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
