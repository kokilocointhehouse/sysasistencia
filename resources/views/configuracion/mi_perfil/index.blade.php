@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Mi perfíl</h3>
            </div>
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Buttons</li>
                </ol>
            </div> --}}
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive" style="background: white">
			<table class="table ">
                <tr>
                    <td colspan="2" style="color: #b41717">
                        *Esta información es importante para la emisión de reportes.
                    </td>
                </tr>
                <tr>
                    <td><b>FOTO:</b></td>
                    <td> <img src="{{asset('Imagen/'.$usuario->foto)}}" alt=""
                         width="100" height="100"></td>
                </tr>
				<tr>
					<td><b>NOMBRES:</b></td>
                    <td>{{$usuario->Nombres}}</td>
				</tr>
                <tr>
					<td><b>DUI:</b></td>
                    <td>{{$usuario->NumDocumento}}</td>
				</tr>
                <tr>
					<td><b>DIRECCIÓN:</b></td>
                    <td>{{$usuario->Direccion}}</td>
				</tr>
                <tr>
					<td><b>NRO CELULAR:</b></td>
                    <td>{{$usuario->TelefCel}}</td>
				</tr>
                <tr>
					<td><b>CORREO:</b></td>
                    <td>{{$usuario->Correo}}</td>
				</tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a class="btn btn-info" style="width: 150px"
                        href="" data-target="#modal-add-{{$usuario->IdUsuario}}" data-toggle="modal">
                        Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                        </a>
                    </td>
                </tr>

			</table>
		</div>

	</div>
</div>
</div>
@include('configuracion.mi_perfil.modal')
<script type="text/javascript">
	function mostrar(){
    var archivo = document.getElementById("Imagen").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("img").src = reader.result;
        // document.getElementById("nombre_imagen").value = archivo.name;
        }
    }else{
        document.getElementById("img").src = "";
        // document.getElementById("nombre_imagen").value = "";
    }
}


</script>

@push ('scripts')
@if (session()->has('success'))
<script>
    $(document).ready(function() {
        Snackbar.show({text: '{{session('success')}}', actionText: 'CERRAR',
         pos: 'bottom-right', actionTextColor: '#27AE60', duration: 6000});
    });
</script>
@endif
@if (count($errors)>0)
    <script type="text/javascript">
        $(document).ready(function(){
            $('#modal-add').modal('show');
        });
    </script>
@endif
@endpush
@endsection
