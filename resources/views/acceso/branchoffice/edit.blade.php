@extends('layouts.admin')
@section('contenido')
    {!! Form::open(['url' => route('branchoffice.update', $branchOffice->id), 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('usuario.index') }}">Regresar</a> --}}
                    <h5 class="modal-title" id="exampleModalLongTitle">Datos del Sucursal</h5>
                    <input type="hidden" name="id" value="{{ $branchOffice->id }}">
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                name="name" placeholder="Nombre del Horario"
                                                value="{{ $branchOffice->name }}" required>
                                        </div>
                                        @if ($errors->has('name'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control ubicacion {{ $errors->has('ubicacion') ? 'is-invalid' : '' }}"
                                                name="ubicacion"
                                                value="{{ $branchOffice->latitude }}, {{ $branchOffice->longitude }}"
                                                required>
                                        </div>
                                        @if ($errors->has('ubicacion'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('ubicacion') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marked"></i></span>
                                            </div>
                                            <input type="text" class="form-control radius" name="radius"
                                                value="{{ $branchOffice->radius }}" required>
                                        </div>
                                        @if ($errors->has('radius'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('radius') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $branchOffice->address }}">
                                        </div>
                                        @if ($errors->has('address'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <div style="margin: 0px auto 0px auto">

                        <div style="margin: 0px auto 0px auto">
                            <a href="{{ route('branchoffice.index') }}" type="button" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
    @push('scripts')
        <script>
            $('.radius').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
            $('.ubicacion').on('input', function() {
                this.value = this.value.replace(/[^0-9,.,-]/g, '');
            });
        </script>
    @endpush
@endsection
