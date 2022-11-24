@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Configuración del Sistema</h3>
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
	<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive" style="background: white">
			<table class="table ">
                <tr colspan="2">
                    <h5>Datos de la Empresa</h5>
                </tr>
                <tr>
                    <td colspan="2" style="color: #b41717">
                        *Esta información es importante para la emisión de reportes.
                    </td>
                </tr>
                <tr>
                    <td><b>LOGO:</b></td>
                    <td> <img src="{{asset('logo/'.$empresa->Logo)}}" alt=""
                         width="100" height="100"></td>
                </tr>
				<tr>
					<td><b>NOMBRE DE LA EMPRESA:</b></td>
                    <td>{{$empresa->nomEmpresa}}</td>
				</tr>
                <tr>
					<td><b>DIRECCIÓN:</b></td>
                    <td>{{$empresa->Direccion}}</td>
				</tr>
                <tr>
                    <td colspan="2"> <h5>Ajustes del Sistema</h5> </td>
                </tr>
                {{-- <tr>
					<td><b>PAGO POR HORA:</b></td>
                    <td>S/ {{$empresa->pagoHora}}</td>
				</tr> --}}
                <tr>
					<td><b>APERTURA DEL SISTEMA:</b></td>
                    <td> {{$empresa->AperturaSistema}}</td>
				</tr>
                <tr>
					<td><b>HORA DE ENTRADA:</b></td>
                    <td> {{$empresa->HoraEntrada}}</td>
				</tr>
                <tr>
					<td><b>HORA DE SALIDA:</b></td>
                    <td> {{$empresa->HoraSalida}}</td>
				</tr>
                {{-- <tr>
					<td><b>UBICACIÓN:</b></td>
                    <td> <a href="//www.google.com/maps/search/{{$empresa->Latitud}},{{$empresa->Longitud}}"
                        target="_black" >{{$empresa->Latitud}},{{$empresa->Longitud}}</a> </td>
				</tr>
                <tr>
					<td><b>RADIO:</b></td>
                    <td>  {{$empresa->radio}}</td>
				</tr> --}}
                <tr>
					<td><b>DIAS DE APERTURA:</b></td>
                    @php($dias_hab = explode('_', $empresa->diasHabilitados))
                    @php($dias = array('LU', 'MA', 'MI', 'JU', 'VI', 'SÁ', 'DO'))
                    <td>
                        @foreach ($dias as $item)
                            @php($aux = false)
                            @foreach ($dias_hab as $item2)
                                @if ($item == $item2)
                                @php($aux = true)
                                @endif
                            @endforeach
                            {{$item}}
                            @if ($aux)
                            <i class="fas fa-circle" style="margin-right: 10px;"></i>
                            {{-- <input type="checkbox" id="cbox1" value="{{$item}}" checked disabled> --}}
                            @else
                            <i class="far fa-circle" style="margin-right: 10px;"></i>
                            {{-- <input type="checkbox" id="cbox1" value="{{$item}}"  disabled> --}}
                            @endif
                        @endforeach

                    </td>
				</tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a class="btn btn-info" style="width: 150px"
                        href="" data-target="#modal-add" data-toggle="modal">
                        Editar <i class="far fa-edit" style="margin-left: 20px"></i>
                        </a>
                    </td>
                </tr>

			</table>
		</div>
	</div>
</div>

@include('configuracion.empresa.modal')
<script type="text/javascript">
	function mostrar(){
    var archivo = document.getElementById("Logo").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("img").src = reader.result;
        document.getElementById("nombre_imagen").value = archivo.name;
        }
    }else{
        document.getElementById("img").src = "";
        document.getElementById("nombre_imagen").value = "";
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
{{-- <script type="text/javascript">
    $("input[type=checkbox]:checked").each(function(){
    valoresCheck.push(this.value);
    });
</script> --}}
@endpush
@endsection
