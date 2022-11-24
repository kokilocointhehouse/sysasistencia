<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-{{$usuario->IdUsuario}}">

    {!!Form::model($usuario,['method'=>'PATCH','route'=>['mi_perfil.update',$usuario->IdUsuario], 'files'=>'true'])!!}
    {{Form::token()}}
    <style>
        .imagen img {
            width: 100px;
            height: auto;
        }
    </style>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">

                <h4 class="modal-title" style="text-align: center; font-weight: bold">
                    Datos de Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-pen"></i></span>
                    </div>
                    <input type="hidden" name="IdUsuario" id="" value="{{$usuario->IdUsuario}}">
                    <input type="text" class="form-control" name="Nombres" placeholder="Nombres" value="{{$usuario->Nombres}}">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" name="NumDocumento" placeholder="Numero de Documento" value="{{$usuario->NumDocumento}}">
                </div>
                <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password2" placeholder="Repita su Contraseña">
                </div> -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Direccion" placeholder="Direccion" value="{{$usuario->Direccion}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" name="Telefono" placeholder="Telefono" value="{{$usuario->TelefCel}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="text" class="form-control" name="correo" placeholder="Correo Electronico" value="{{$usuario->Correo}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password"
                    placeholder="Ingrese su nueva contraseña" >
                </div>

                <div class="input-group mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-image"></i></span>
                        </div>
                        <input type="file" name="foto" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif" class="form-control" onchange="mostrar()">
                    </div>

                    <div >
                        @if($usuario->foto != "")
                        <img src="{{asset('Imagen/'.$usuario->foto)}}" id="img" / width="100" height="100">
                        @endif
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12" style="text-align: center">
                        @if (count($errors)>0)
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12" style="text-align: center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>
        {{ Form::Close() }}

    </div>
