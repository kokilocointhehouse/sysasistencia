@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #ffffff;
        }

    </style>
    <div class="row">
        <div class="col-md-6 col-md-offset-4"
            style="margin-left:auto; margin-right:auto; margin-left: auto; margin-top:60px">
            <div class="card">
                <div class="card-header p-3 mb-2  text-dark">
                    {{-- <p align="center"> {{$empresa_ini->nomEmpresa}}</p>
                <p align="center">
                <img src="{{asset('logo/' . $empresa_ini->logo)}}" width="90"
                style="margin-bottom: -20px;"  alt="">
                </p> --}}
                    <p align="center" style="margin-bottom: 0px;">
                        SISTEMA CONTROL DE ASISTENCIA/2
                    </p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ asset('asistencia/inicio') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('NumDocumento') ? 'has-error' : '' }} ">
                            <label for="">N° Documento</label>
                            <input type="NumDocumento"
                                class="form-control {{ $errors->has('NumDocumento') ? 'is-invalid' : '' }}"
                                name="NumDocumento" placeholder="Ingrese tu N° documento"
                                value="{{ old('NumDocumento') }}" required>
                            {!! $errors->first('NumDocumento', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ubicación
                            </label>
                            <div class="input-group mb-6">
                                <a href="" id="ubicacion" target="_black" class="form-control"> </a>
                                <input type="hidden" name="ubicacion" id="ubicacion2">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fecha">Camara</label>
                            <div class="input-group mb-3 justify-content-center">
                                <video id="video" width="198" autoplay=true class="img-responsive"></video>
                                <canvas id="canvas" width="198" class="img-responsive"></canvas>
                            </div>
                        </div>
                        <input id='fotocamara' name="fotocamara" type="hidden" class="form-control" />
                        <div class="d-grid gap-2">
                            <a class="btn btn-primary btn-block" id="grabar">MARCAR ASISTENCIA</a>
                        </div>
                        <button id="enviar" style="display: none"></button>
                        {{-- <div style="text-align: center;">
                        o  <a href="{{asset('registro/nueva-cuenta')}}" style="text-decoration: none;">Crear una Cuenta</a>
                    </div> --}}
                    </form>
                </div>
                <div class="card-footer" style="text-align: center;">
                    <span class="text-primary"><b> <a style="text-decoration: none;" href="#">


                                    <a href="{{ asset('login') }}" style="float: right">
                                        <b>Iniciar Sesión</b></a></b>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (navigator.geolocation) {
            var success = function(position) {
                var latitud = position.coords.latitude,
                    longitud = position.coords.longitude;
                document.getElementById("ubicacion").innerHTML = latitud + ',' + longitud;
                document.getElementById('ubicacion').setAttribute('href', '//www.google.com/maps/search/' + latitud +
                    ',' + longitud);
                document.getElementById("ubicacion2").value = latitud + ',' + longitud;

                // console.log(punto)
            }
            navigator.geolocation.getCurrentPosition(success, function(msg) {
                console.error(msg);
            });
        }
    </script>
    <script>
        'use strict';
        navigator.mediaDevices.getUserMedia({
            audio: false,
            video: true
        }).then((stream) => {
            if (stream) {
                let video = document.getElementById('video');
                video.srcObject = stream;
                var canvas = document.getElementById('canvas');
                grabar.addEventListener("click", function() {
                    canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight,
                        0, 0, 198, 150);
                    var data = canvas.toDataURL('image/png');
                    document.getElementById('fotocamara').setAttribute('value', data);
                    document.getElementById("enviar").click()

                });
            }
        }).catch((err) => {
            console.log(err);
            grabar.addEventListener("click", function() {});
        })
    </script>
    @push('scripts')
        @if (Session::has('success'))
            <script>
                toastr.success('{{ Session::get('success') }}', 'Operación Correcta', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                toastr.error('{{ Session::get('error') }}', 'Operación Fallida', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
        @if (Session::has('info'))
            <script>
                toastr.info('{{ Session::get('info') }}', 'Advertencia', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
    @endpush
@endsection
