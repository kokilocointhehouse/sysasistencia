@extends('layouts.admin')
@section('contenido')
    <style>
        .imagen img {
            background: rgb(232, 233, 232);
            width: 100px;
            height: auto;
        }

    </style>
    {!! Form::open(['url' => route('usuarios.update', $usuario->IdUsuario), 'method' => 'PUT', 'autocomplete' => 'off', 'files' => true]) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('usuario.index') }}">Regresar</a> --}}
                    <h5 class="modal-title" id="exampleModalLongTitle">Datos del Usuario</h5>
                    <input type="hidden" name="IdUsuario" value="{{ $usuario->IdUsuario }}">

                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @php($error_create = 0)
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">N° DUI <span class="text-danger" title="Campo Obligatorio">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control {{ $errors->has('NumDocumento') ? 'is-invalid' : '' }}"
                                                name="NumDocumento" placeholder="Nombre usuario anterior"
                                                value="{{ $usuario->NumDocumento }}">
                                        </div>
                                        @if ($errors->has('NumDocumento'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('NumDocumento') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nombres y Apellidos <span class="text-danger" title="Campo Obligatorio">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control {{ $errors->has('Nombres') ? 'is-invalid' : '' }}"
                                                name="Nombres" placeholder="Número" value="{{ $usuario->Nombres }}">
                                        </div>
                                        @if ($errors->has('Nombres'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('Nombres') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="Direccion"
                                                placeholder="Dirección" value="{{ $usuario->Direccion }}">
                                        </div>
                                        @if ($errors->has('Direccion'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('Direccion') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">N° Teléfono</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="TelefCel" placeholder="Teléfono"
                                                value="{{ $usuario->TelefCel }}">
                                        </div>
                                        @if ($errors->has('TelefCel'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('TelefCel') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Correo Electrónico</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="Correo" placeholder="Correo"
                                                value="{{ $usuario->Correo }}">
                                        </div>
                                        @if ($errors->has('Correo'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('Correo') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tipo Usuario</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                            </div>
                                            <select class="form-control tipo" name="TipoUsuario" id="TipoUsuario">
                                                <option value="" hidden selected> Seleccionar </option>
                                                @foreach ($tipo as $item)
                                                    <option value="{{ $item }}"
                                                        {{ $item == $usuario->TipoUsuario || $item == old('TipoUsuario')  ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('TipoUsuario'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('TipoUsuario') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                {{-- style="display: {{ '1' == $usuario->TipoUsuario ? 'none' : 'block' }};" --}}

                                <div class="col-md-6" id="displaySucursal">
                                    <div class="form-group">
                                        <label for="">Sucursal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-laptop-house"></i></span>
                                            </div>
                                            <select class="form-control" name="idBranch_office">
                                                @foreach ($branch_office as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $usuario->idBranch_office ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('idBranch_office'))
                                            <div>
                                                <span
                                                    class="text-danger">{{ $errors->first('idBranch_office') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6" id="displayPagoHora">
                                    <div class="form-group">
                                        <label for="">Pago Hora <span class="text-danger" title="Campo Obligatorio">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="pagoHora" id="pagoHora"
                                                placeholder="Pago por Hora" value="{{ is_null(old('pagoHora')) ? $usuario->pagoHora  : old('pagoHora') }}" required>
                                        </div>
                                        @if ($errors->has('pagoHora'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('pagoHora') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Contraseña">
                                        </div>
                                        @if ($errors->has('password'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Repetir Contraseña</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                            </div>
                                            <input id="password-confirm" type="password" class="form-control"
                                             name="password_confirmation"  autocomplete="new-password" placeholder="Confirmar Contraseña">
                                        </div>

                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-camera-retro"></i>
                                                </span>
                                            </div>
                                            <input type="file" class="form-control" id="Imagen2" name="foto">
                                        </div>
                                        @if ($errors->has('foto'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('foto') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="img2" class="imagen">
                                        <img src="{{ asset('Imagen/' . $usuario->foto) }}" width="100" height="100">
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer text-center">
                <div style="margin: 0px auto 0px auto">

                    <div style="margin: 0px auto 0px auto">
                        <a href="{{ route('usuarios.index') }}" type="button" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{ Form::close() }}
    <script>
        document.getElementById("Imagen2").onchange = function(e) {
            // Creamos el objeto de la clase FileReader
            let reader = new FileReader();

            // Leemos el archivo subido y se lo pasamos a nuestro fileReader
            reader.readAsDataURL(e.target.files[0]);

            // Le decimos que cuando este listo ejecute el código interno
            reader.onload = function() {
                let preview = document.getElementById('img2'),
                    image = document.createElement('img');
                console.log("mostrado")
                image.src = reader.result;

                preview.innerHTML = '';
                preview.append(image);
            };
        }

        if(document.getElementById('TipoUsuario').value === 'PERSONAL' ){
        document.getElementById('displaySucursal').style.display = 'block';
        document.getElementById('displayPagoHora').style.display = 'block';
    }else{
        document.getElementById('displaySucursal').style.display = 'none';
        document.getElementById('displayPagoHora').style.display = 'none';
        document.getElementById('pagoHora').value = 0;
    }

    const selectElement = document.querySelector('.tipo');
    selectElement.addEventListener('change', (event) => {
        if(event.target.value.toString() === 'ADMINISTRADOR'){
            document.getElementById('displaySucursal').style.display = 'none';
            document.getElementById('displayPagoHora').style.display = 'none';
            document.getElementById('pagoHora').value = 0;


        }else{
            document.getElementById('displaySucursal').style.display = 'block';
            document.getElementById('displayPagoHora').style.display = 'block';

        }

    });
    </script>
    @push('scripts')
        <script>
            $('#pagoHora').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
    @endpush
@endsection
