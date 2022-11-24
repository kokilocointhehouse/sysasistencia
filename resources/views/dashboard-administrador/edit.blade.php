<?php use App\Http\Controllers\InformeController; ?>
@extends('layouts.admin')
@Section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Editar Registro</h3>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {!!Form::model($registro,['method'=>'PATCH','route'=>['dashboard-administrador.update',$registro->IdRegistro]])!!}
        {{Form::token()}}
			@if (count($errors)>0)
			<div class="alert" style="background: #f8dbdb" role="alert">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
            @if (!isset($registro->HoraSalida))
                <div class="alert" style="background: #f8dbdb" role="alert">
                    Este registro no tiene una hora de Salida
                </div>
            @elseif ($registro->HoraEntrada > $registro->HoraSalida)
                <div class="alert" style="background: #f8dbdb" role="alert">
                    La Hora de Entrada tiene que ser menor a la Hora de Salida
                </div>
            @endif
            <div class="form-group">
                <input type="hidden" name="IdRegistro" value="{{$registro->IdRegistro}}">
            	<label for="IdUsuario">Personal</label>
                <input type="hidden" name="IdUsuario" value= "{{$registro->IdUsuario}}" >
            	<input type="text" class="form-control"
				value= "{{$registro->Nombres}}" disabled>
            </div>
            <div class="form-group">
            	<label for="FechaRegistro">Fecha</label>
            	<input type="text" name="FechaRegistro" class="form-control"
				value= "{{InformeController::fechaCastellano($registro->FechaRegistro)}}"
                disabled>
            </div>
            <div class="form-group">
            	<label for="HoraEntrada">Hora de Entrada</label>
                <input type="hidden" name="HoraEntradaU" value="{{$registro->HoraEntrada}}">
            	<input type="time" name="HoraEntrada" class="form-control"
				value= "{{$registro->HoraEntrada}}">
            </div>
            <div class="form-group">
            	<label for="HoraSalida">Hora de Salida</label>
                <input type="hidden" name="HoraSalidaU" value="{{$registro->HoraSalida}}">
            	<input type="time" name="HoraSalida" class="form-control"
				value= "{{$registro->HoraSalida}}">
            </div>
            <div class="form-group">
            	<label for="Observacion">Observación</label><br>
                <input type="hidden" name="EncargadoUpdt" value="{{auth()->user()->Nombres}}">
                <textarea name="Observacion" id="" cols="30" rows="3"
                style="resize: none;" class="form-control"
                placeholder="Observación o Justificación de la Asistencia.">{{$registro->Observacion}}</textarea>
            </div>
            <div class="form-group">
            	<button  type="submit" id="enviar" style="display: none">Guardar</button>
            </div>
        {!!Form::close()!!}
            <div class="form-group">
				<a href="{{asset('dashboard-administrador')}}" class="btn btn-danger">Cancelar</a>
                <button  class="btn btn-primary guardar">Modificar</button>
            </div>

	</div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        @if (!isset($registro->EncargadoUpdt))
            <div class="alert"  style="background: #b9fbd2">
                Registro sin modificaciones <i class="fas fa-check" style="color: rgb(33, 134, 87);"></i>
            </div>
        @else
            @if (isset($registro->HoraEntradaU))
            <div class="form-group" style="color: #be2f2f">
            	<label for="HoraEntrada">Hora de Entrada Anterior</label>
            	<input type="time" class="form-control" disabled
				value= "{{$registro->HoraEntradaU}}">
            </div>
            @endif
            @if (isset($registro->HoraSalidaU))
            <div class="form-group" style="color: #be2f2f">
            	<label for="HoraEntrada">Hora de Salida Anterior</label>
            	<input type="time" class="form-control" disabled
                @if($registro->HoraSalidaU != '00:00:00')
                    value = "{{$registro->HoraSalidaU}}"
                @endif
                >
            </div>
            @endif
            <div class="form-group" style="color: #be2f2f">
            	<label for="HoraEntrada">Responsable de la ultima modificación</label>
            	<input type="text" class="form-control" disabled
				value= "{{$registro->EncargadoUpdt}}">
            </div>
        @endif
    </div>
</div>

@push ('scripts')
    <script>
        $('.guardar').unbind().click(function () {
          var $button = $(this);
        //   var data_nombre = $button.attr('data-nombre');
          Swal.fire({
            title: 'Confirme la Modificación',
            showDenyButton: true,
            icon: 'warning',
            text: 'Recuerde que estos cambios seran visibles para el PERSONAL y el ADMINISTRADOR',
            confirmButtonText: `Confirmar`,
            denyButtonText: `Cancelar`,
            customClass: 'swal-wide',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#enviar").click();
            } else if (result.isDenied) {
              Swal.fire('No se realizó ninguna modificación.', '', 'info')
            }
          })
        });
    </script>
@endpush
@endsection
