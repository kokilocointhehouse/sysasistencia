<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'acceso/usuarios', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
    {!! Form::token() !!}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }

    </style>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLongTitle">Datos de Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">N° de documento <span class="text-danger" title="Campo Obligatorio">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control NumDocumento" name="NumDocumento" id="NumDocumento"
                                placeholder="Ingrese el Número de Documento" value="{{ old('NumDocumento') }}"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Nombres y Apellidos <span class="text-danger" title="Campo Obligatorio">*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                            </div>
                            <input type="text" class="form-control" name="Nombres" placeholder="Ingrese Nombres"
                                value="{{ old('Nombres') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Dirección</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" name="Direccion" placeholder="Ingrese Dirección"
                                value="{{ old('Direccion') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">N° Teléfono</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" name="Telefono" placeholder="N° de Teléfono"
                                value="{{ old('Telefono') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Correo Electrónico</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input type="text" class="form-control" name="correo" placeholder="Correo Electrónico"
                                value="{{ old('correo') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Tipo Usuario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <select class="custom-select tipo" name="TipoUsuario" id="TipoUsuario" required>
                                <option value="" selected hidden>Seleccionar Tipo</option>
                                @if (old('TipoUsuario') == 'PERSONAL')
                                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                    <option value="PERSONAL" selected>PERSONAL</option>
                                @else
                                    <option value="ADMINISTRADOR" selected>ADMINISTRADOR</option>
                                    <option value="PERSONAL">PERSONAL</option>
                                @endif
                            </select>
                        </div>
                    </div>

                        <div class="col-md-6" id="displaySucursal">
                            <label for="">Sucursal</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-laptop-house"></i></span>
                                </div>
                                <select class="custom-select" name="idBranch_office">
                                    @foreach ($branch_office as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == old('idBranch_office') ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="displayPagoHora">
                            <label for="">Pago Hora <span class="text-danger" title="Campo Obligatorio">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input type="text" class="form-control" name="pagoHora" id="pagoHora"
                                    placeholder="Pago por Hora" value="{{ old('pagoHora') }}" required>
                            </div>
                        </div>


                </div>







                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-image"></i></span>
                    </div>
                    <input type="file" class="form-control" id="Imagen" name="foto">

                </div>
                <div id="img" class="imagen"></div>
                <div class="input-group">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" style="margin: 0px auto 0px auto">
                            <ul>
                                @php($error_create = 0)
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                        <br>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <div style="margin: 0px auto 0px auto">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
