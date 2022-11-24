<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">

    {!! Form::model($empresa, ['method' => 'PATCH', 'route' => ['empresa.update', $empresa->idEmpresa], 'files' => 'true']) !!}
    {{ Form::token() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" style="text-align: center; font-weight: bold">
                    Datos de la Empresa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-header p-3 mb-2  text-dark">

                    <div align="center" id="visual" height="100px" width="100px">
                        <img src="{{ asset('logo/' . $empresa->Logo) }}" id="img" / width="100" height="100">

                    </div>
                    <div style="text-align: center;">
                        <span class="btn btn-info btn-xs btn-file">
                            <i class="fa fa-folder-open text-white" aria-hidden="true"></i>
                            <input type="file" name="Logo" id="Logo" accept="image/png, .jpeg, .jpg, image/gif"
                                onchange="mostrar()">
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="Nombre">NOMBRE DE LA EMPRESA</label>
                        <div class="input-group">
                            <input type="text" name="nomEmpresa"
                                @if (old('nomEmpresa') != '') value="{{ old('nomEmpresa') }}"
                            @else
                                value="{{ $empresa->nomEmpresa }}" @endif
                                class="form-control" placeholder="Ingrese el nombre de la Empresa" required>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="Direccion">DIRECCIÓN</label>
                        <div class="input-group">

                            <input type="text" name="Direccion" id="Direccion"
                                @if (old('Direccion') != '') value="{{ old('Direccion') }}"
                            @else
                                value="{{ $empresa->Direccion }}" @endif
                                class="form-control" placeholder="Ejm: Lima - Jr. Las Americas 454" required>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pagoHora">PAGO POR HORA</label>
                        <div class="input-group">

                            <input type="text" name="pagoHora" id="pagoHora"
                                @if (old('pagoHora') != '') value="{{ old('pagoHora') }}"
                            @else
                                value="{{ $empresa->pagoHora }}" @endif
                                class="form-control" placeholder="Ejm: 10.00" required>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pagoHora">APERTURA DEL SISTEMA</label>
                        <div class="input-group">
                            <input type="time" name="AperturaSistema" id="AperturaSistema"
                                @if (old('AperturaSistema') != '') value="{{ old('AperturaSistema') }}"
                            @else
                                value="{{ $empresa->AperturaSistema }}" @endif
                                class="form-control" placeholder="Ejm: 10:00:00" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pagoHora">HORA DEL ENTRADA</label>
                        <div class="input-group">
                            <input type="time" name="HoraEntrada" id="HoraEntrada"
                                @if (old('HoraEntrada') != '') value="{{ old('HoraEntrada') }}"
                            @else
                                value="{{ $empresa->HoraEntrada }}" @endif
                                class="form-control" placeholder="Ejm: 10:00:00" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pagoHora">HORA DE SALIDA</label>
                        <div class="input-group">
                            <input type="time" name="HoraSalida" id="HoraSalida"
                                @if (old('HoraSalida') != '') value="{{ old('HoraSalida') }}"
                            @else
                                value="{{ $empresa->HoraSalida }}" @endif
                                class="form-control" placeholder="Ejm: 10:00:00" required>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-12">
                    <div class="form-group">
                        <label for="ubicacion">UBICACIÓN</label>
                        <div class="input-group">
                            <input type="text" name="ubicacion" id="ubicacion"
                                @if (old('ubicacion') != '') value="{{ old('ubicacion') }}"
                            @else
                                value="{{ $empresa->Latitud }},{{ $empresa->Longitud }}" @endif
                                class="form-control" placeholder="Ejm: -76.2342323,-31.2342343" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="radio">RADIO</label>
                        <div class="input-group">
                            <input type="number" name="radio" id="radio"
                                @if (old('radio') != '') value="{{ old('radio') }}"
                            @else
                                value="{{ $empresa->radio }}" @endif
                                class="form-control" placeholder="Ejm: 80000" required>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="pagoHora">DIAS HABILITADOS</label>
                        @php($dias_hab = explode('_', $empresa->diasHabilitados))
                        @php($dias = ['LU', 'MA', 'MI', 'JU', 'VI', 'SÁ', 'DO'])
                        <div class="input-group">
                            @foreach ($dias as $item)
                                @php($aux = false)
                                @foreach ($dias_hab as $item2)
                                    @if ($item == $item2)
                                        @php($aux = true)
                                    @endif
                                @endforeach
                                {{ $item }}
                                @if ($aux)
                                    <input type="checkbox" id="cbox1" name="diasLaborados[]"
                                        value="{{ $item }}" checked
                                        style="margin-right: 15px; margin-top: 5px; margin-right: 10px">
                                @else
                                    <input type="checkbox" id="cbox1" name="diasLaborados[]"
                                        value="{{ $item }}"
                                        style="margin-right: 15px; margin-top: 5px; margin-right: 10px">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" style="margin: 0px auto 0px auto">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                    <div class="col-lg-12" style="text-align: center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-info">Confirmar</button>
                    </div>
                </div>
            </div>

        </div>


    </div>
    {{ Form::Close() }}
</div>
