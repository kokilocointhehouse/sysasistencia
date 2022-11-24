@extends('layouts.admin')
@Section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Nuevo Pago</h3>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			@if (count($errors)>0)
			<div class="alert alert-danger" role="alert">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
			{!!Form::open(array('url'=>'caja/pago','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="IdUsuario">Personal</label>
            	<select name="IdUsuario" id="" class="form-control">
                    @foreach ($usuario as $item)
                        @if (old('IdUsuario') == $item->IdUsuario)
                            <option value="{{$item->IdUsuario}}" selected>{{$item->Nombres}}</option>
                        @else
                            <option value="{{$item->IdUsuario}}" >{{$item->Nombres}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            	<label for="monto">Monto</label>
            	<input type="text" name="monto" class="form-control"
				value= "{{old('monto')}}"
				placeholder="Ingrese el monto a Pagar.">
            </div>
            <div class="form-group">
            	<label for="nota">Nota</label>
            	<input type="text" name="nota" class="form-control"
				value= "{{old('nota')}}"
				placeholder="Ingrese una nota. (Opcional)">
            </div>
            <div class="form-group">
            	<button  type="submit" id="enviar" style="display: none">Guardar</button>
            </div>
            {!!Form::close()!!}
            <div class="form-group">
				<a href="{{asset('caja/pago')}}" class="btn btn-danger">Cancelar</a>
                <button  class="btn btn-primary guardar">Pagar</button>
            </div>



		</div>
	</div>

@push ('scripts')
    <script>
        $('.guardar').unbind().click(function () {
          var $button = $(this);
        //   var data_nombre = $button.attr('data-nombre');
          Swal.fire({
            title: 'Confirme el Pago',
            showDenyButton: true,
            icon: 'warning',
            text: 'Recuerde que no podrá editar, ni eliminar el Pago!',
            confirmButtonText: `Confirmar`,
            denyButtonText: `Cancelar`,
            customClass: 'swal-wide',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#enviar").click();
            } else if (result.isDenied) {
              Swal.fire('No se realizó ningún Pago', '', 'info')
            }
          })
        });
    </script>
@endpush
@endsection
