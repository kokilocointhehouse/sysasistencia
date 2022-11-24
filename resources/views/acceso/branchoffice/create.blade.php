<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!!Form::open(array('url'=>'acceso/branchoffice','method'=>'POST','autocomplete'=>'off'))!!}
    {!!Form::token()!!}
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Nombre de la Sucursal</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                    </div>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre de la Sucursal" value="{{old('name')}}" required>
                </div>
                <label for="">Ubicación</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control ubicacion" name="ubicacion" value="{{old('ubicacion')}}"
                    placeholder="Ejm: -13.23423433, -71.5665645" required>
                </div>
                <label for="">Radio</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked"></i></span>
                    </div>
                    <input type="text" class="form-control radius" name="radius" value="{{old('radius')}}"
                    placeholder="Ejm: 50" required>
                </div>
                <label for="">Dirección</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                    </div>
                    <input type="text" class="form-control" name="address" value="{{old('address')}}"
                    placeholder="Opcional">
                </div>
            </div>
            <div class="modal-footer">
                <div style="margin: 0px auto 0px auto">
                    @if (count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                        @php($error_create = 0)
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                        </ul>

                    </div>
                    @endif
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}

