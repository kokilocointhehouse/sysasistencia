<?php use App\Http\Controllers\InformeController; ?>
@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h3>Registro de Asistencia</h3>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
<div class="row">
    <div class="col-md-8">
        <div class="card card-info">
        @if (isset($informe->IdRegistro))
                @if (isset($informe->HoraSalida))
                    <div class="card-header">
                        <h3 class="card-title">Registro Completo de Hoy</h3>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control" id="fecha" placeholder="Fecha" value="{{InformeController::fechaCastellano($informe->FechaRegistro)}}" disabled>
                                  <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hora_entrada">Hora Entrada
                                </label>
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control" id="hora_entrada" placeholder="Hora de Entrada" value="{{$informe->HoraEntrada}}" disabled>
                                  <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="ubicacion_entrada">Ubicación Entrada
                              </label>
                              <div class="input-group mb-3">
                                <a href="//www.google.com/maps/search/{{$informe->LatitudEntrada}},{{$informe->LongitudEntrada}}"
                                class="form-control" target="_black">{{$informe->Consideracion}}</a>
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="hora_salida">Hora Salida</label>
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control" id="hora_salida" placeholder="Hora Salida" value="{{$informe->HoraSalida}}" disabled>
                                  <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ubicacion_salida">Ubicación Salida</label>
                                <div class="input-group mb-3">
                                  <a href="//www.google.com/maps/search/{{$informe->LatitudSalida}},{{$informe->LongitudSalida}}"
                                 class="form-control" target="_black" >{{$informe->Consideracion2}}</a>
                                  <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                  </div>
                                </div>
                            </div>
                        </div>
                          <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{route('detalle.pdf',$informe->IdRegistro)}}" target="_blank"
                                class="btn btn-info" style="float: right">IMPRIMIR</a>
                        </div>
                    </form>
                @else
                  @if ($aux)
                    <div class="card-header">
                        <h3 class="card-title">Detalle de mi Salida</h3>
                    </div>
                    <form>
                    <div class="card-body">
                        <div class="form-group">
                          <label for="fecha">Fecha y Hora de Salida</label>
                            <div class="input-group mb-6">
                                <input type="text" class="form-control" id="fecha" placeholder="Fecha" disabled value="{{$fecha_actual}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Ubicación Salida
                          </label>
                            <div class="input-group mb-6">
                                <a href="" id="ubicacion" target="_black" class="form-control"> </a>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Estado de GPS</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control rojo" id="consideracion" disabled>
                                <div class="input-group-append">
                                      {{-- <i class="fas fa-check"></i> --}}
                                        <a href="{{asset('asistencia/registro')}}"
                                        class="btn btn-dark input-group-text" style="float: right">
                                        <i class="fas fa-sync-alt"></i>
                                        </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Camara</label>
                            <div class="input-group mb-3">
                                <video id="video" width="298" autoplay=true class="img-responsive"></video>
                                <canvas id="canvas" width="298" class="img-responsive"></canvas>
                            </div>
                        </div>
                    </div>
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ Session::get('error') }}</li>
                            </ul>
                        </div>
                    @endif
                      <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-block bg-gradient-danger btn-lg  grabar2" id="grabar">
                            <i class="fas fa-sign-out-alt"></i>
                            Marcar Salida
                        </button>
                    </div>
                    </form>

                    {!! Form::open(['url' => 'marcarsalida', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                    {{ Form::token() }}
                        <div style="display: none">
                            <input type="text" name="idregistro" value="{{$informe->IdRegistro}}">
                            <input type="text" id="latitud_entrada" name="latitud_entrada">
                            <input type="text" id="longitud_entrada" name="longitud_entrada">
                            <input type="text" name="consideracion_input" id="consideracion_input">
                            <input id='fotocamara' name="fotocamara" type="text" class="form-control" />
                            <input type="submit" value="enviar2" id="enviar2">
                        </div>
                    {!!Form::close()!!}
                  @else
                    <h5 style="color: #d12727; text-align: center">NO TIENES HORARIOS DISPONIBLES PARA EL DIA DE HOY</h5>
                      <img src="{{asset('images/disconect.jpg')}}" alt="">
                  @endif
                @endif
        @else
          @if ($aux)
                <div class="card-header">
                    <h3 class="card-title">Detalle de mi Entrada</h3>
                </div>
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fecha">Fecha y Hora de Entrada</label>
                            <div class="input-group mb-6">
                                <input type="text" class="form-control" id="fecha" placeholder="Fecha" disabled value="{{$fecha_actual}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hora_entrada">Ubicación
                            </label>
                            <div class="input-group mb-6">
                                <a href="" id="ubicacion" target="_black" class="form-control"> </a>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="hora_entrada">Estado del gps
                            </label>
                            <div class="input-group mb-6">
                                <input type="text" class="form-control rojo" id="consideracion" disabled>
                                <div class="input-group-append">
                                      {{-- <i class="fas fa-check"></i> --}}
                                        <a href="{{asset('asistencia/registro')}}"
                                        class="btn btn-dark input-group-text" style="float: right">
                                        <i class="fas fa-sync-alt"></i>
                                        </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Camara</label>
                            <div class="input-group mb-3">
                                <video id="video" width="298" autoplay=true class="img-responsive"></video>
                                <canvas id="canvas" width="298" class="img-responsive"></canvas>
                            </div>
                        </div>
                    </div>
                      <!-- /.card-body -->
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="card-footer">
                        <button type="button" class="btn btn-block bg-gradient-success btn-lg grabar" id="grabar">
                            Marcar Asistencia</button>
                    </div>
                </form>
                {{-- Div oculto --}}
                {!!Form::open(array('url'=>'asistencia/registro','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}
                    <div style="display: none">
                        <input type="text" id="latitud_entrada" name="latitud_entrada">
                        <input type="text" id="longitud_entrada" name="longitud_entrada">
                        @php($hora = explode('/ ', $fecha_actual))
                        <input type="text" name="hora_entrada" value="{{$hora[1]}}">
                        <input type="text" name="fecha_entrada" value="{{$fecha}}">
                        <input type="text" name="idusuario" value="{{auth()->user()->IdUsuario}}">
                        <input id='fotocamara' name="fotocamara" type="text" class="form-control" />
                        <input type="text" name="consideracion_input" id="consideracion_input">
                        <input type="submit" value="enviar" id="enviar">
                    </div>
                {!!Form::close()!!}
                <!-- /.card -->
          @else
          <h5 style="color: #d12727; text-align: center">NO TIENES HORARIO DISPONIBLE PARA EL DIA DE HOY</h5>
            <img src="{{asset('images/disconect.jpg')}}" alt="">
          @endif

        @endif
        </div>
    </div>
</div>

/*AQUI SE HACE LA MAGIA*/
@if (!isset($informe->HoraSalida) && $aux)
    <script>
    if(navigator.geolocation){
    var success = function(position){
    var latitud = position.coords.latitude, longitud = position.coords.longitude;
    document.getElementById("ubicacion").innerHTML = latitud + ',' + longitud;
    document.getElementById('ubicacion').setAttribute('href', '//www.google.com/maps/search/'+ latitud + ',' + longitud);
    // Calculamos si esta dentro del rango o no
    var aux = latitud * 10000000, auy = longitud * 10000000;
    var lat_empresa = {{$empresa->latitude*10000000}}, log_empresa = {{$empresa->longitude*10000000}};
    var punto = Math.pow((aux - (1 * lat_empresa)),2) + Math.pow((auy  - (1 * log_empresa)),2);

    var x = document.getElementById("consideracion");
    var radio = {{$empresa->radius * 100}};
    // console.log(radio);
        if (punto <= Math.pow(radio,2)){
            document.getElementById("consideracion").value = 'CORRECTO';
            var consideracion = document.getElementsByClassName("rojo")[0];
            consideracion.className = "verde form-control";

        }else{
            document.getElementById("consideracion").value = 'FUERA DE RANGO';
        }
        document.getElementById('latitud_entrada').value = latitud; document.getElementById('longitud_entrada').value = longitud;
        document.getElementById('consideracion_input').value = document.getElementById("consideracion").value;
        // console.log(punto + ' | ' + Math.pow(radio,2))
    }
    navigator.geolocation.getCurrentPosition(success, function(msg){
    console.error( msg );
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
                var a = data;
                console.log(data);
            });
        }
    }).catch((err)=>{
        console.log(err);
        grabar.addEventListener("click", function() {
            });
    })

</script>

@endif

@push ('scripts')
@if (Session::has('success'))
<script>
    toastr.success('{{ Session::get('success') }}', 'Operación Correcta',  { "positionClass" : "toast-top-right"})
</script>
@endif
<script>
    $('.grabar').unbind().click(function () {
      var $button = $(this);
    //   var data_nombre = $button.attr('data-nombre');
      Swal.fire({
        title: 'Confirme el registro de su Asistencia',
        showDenyButton: true,
        confirmButtonText: `Confirmar`,
        denyButtonText: `Aún no`,
        customClass: 'swal-wide',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $("#enviar").click();
        } else if (result.isDenied) {
          Swal.fire('No se realizó ningún cambio', '', 'info')
        }
      })
    });
</script>
<script>
    $('.grabar2').unbind().click(function () {
      var $button = $(this);
    //   var data_nombre = $button.attr('data-nombre');
      Swal.fire({
        title: 'Confirme el registro de su Salida',
        showDenyButton: true,
        confirmButtonText: `Confirmar`,
        denyButtonText: `Aún no`,
        customClass: 'swal-wide',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // $("#enviar2").click();
            $('#enviar2').click();
        } else if (result.isDenied) {
          Swal.fire('No se realizó ningún cambio', '', 'info')
        }
      })
    });
</script>
@endpush

@endsection





