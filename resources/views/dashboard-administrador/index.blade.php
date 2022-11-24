@extends ('layouts.admin')
@section ('contenido')
<style>
    table {
        width: 100%;
    }
    table td {
        padding: 3px;
    }
</style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Panel de Control</h3>
                </div>

            </div>
        </div>
    </section>
	{{-- {!!Form::open(array('url'=>'dashboard-administrador','method'=>'post','autocomplete'=>'off'))!!}
	{!!Form::token()!!}
	@if(!isset($empresa->Latitud))
		<input type="text" id="sindato" name="sindato">
		<input type="submit" id="enviar" name="enviar">
	@endif
	{{Form::close()}} --}}
<div class="row">
	<div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $cant_registros_hoy}}</h3>
            <p>Registros Marcados</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
            <a href="#" class="small-box-footer registros">
                Mayor info <i class="fas fa-arrow-circle-right">
                </i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $cant_registros_choy}}</h3>

            <p>Registros Completados</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
            <a href="#" class="small-box-footer registros_c">
                Mayor info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $cant_registros_fhoy}}</h3>
            <p>Registros por Completar</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
            <a href="#" class="small-box-footer registros_pc">
                Mayor info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$cant_usuarionsr}}</h3>
            <p>Usuarios sin marcar asistencia</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
            <a href="#" class="small-box-footer registros_sr">
                Mayor info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-12 col-12">
        <div class="card">
            @include('dashboard-administrador.search')
            <div class="card-body table-responsive p-0">
            <table class="text-nowrap">
                <tr style="background: #343a40; color: #39DA87;">
                <td>PERSONAL</td>
                @php($cont = 1)
                @foreach ($dias_mes_l as $dl)
                    @if ($dl == 'DO' && $dia_ac != $cont)
                    <td style="background: #5d6268; text-align: center">{{$dl}}</td>
                    @elseif($dia_ac == $cont && (date('Y') == $anio_o || $anio_o == ''))
                    <td style="background: #17a2b8; text-align: center">{{$dl}}</td>
                    @else
                    <td style="text-align: center">{{$dl}}</td>
                    @endif
                    @php($cont += 1)
                @endforeach
                </tr>
                <tr>
                    <td></td>
                @foreach ($dias_mes_n as $dn)
                    <td style="text-align: center">{{$dn}}</td>
                @endforeach
                </tr>
                <tr>
                    @php($contador = 1)
                    @foreach($asistencia as $a)
                        @php($a = explode('_', $a))
                        @if($a[0] == '*')
                        <td title="ASISTENCIA" style="color: #D2DA25; text-align: center; font-weight: bold">
                            <form action="{{URL::action('DashController@edit',$a[1])}}" >
                                <input type="submit" style="display: none" name="editar" id="editar_{{$a[1]}}">
                            </form>
                            <a href="#" class="edit" style="color: #2fa861;" data-nombre= "{{$a[1]}}">
                            <i class="fas fa-check"></i>
                            @if ($a[2] == "si")
                            <span title="MODIFICADO" style="color: #f6920f">*</span>
                            @endif
                        </a></td>
                        @elseif($a[0] == 'F')
                        <td title="FALTA" style="color: #d81616; text-align: center; font-weight: bold">
                            <i class="fas fa-times"></i>
                        </td>
                        @elseif($a[0] == 'T')
                        <td title="TARDE" style="color: #17a2b8; text-align: center; font-weight: bold">
                            <form action="{{URL::action('DashController@edit',$a[1])}}" >
                                <input type="submit" style="display: none" name="editar" id="editar_{{$a[1]}}">
                            </form>
                            <a href="#" class="edit" data-nombre= "{{$a[1]}}">{{$a[0]}}
                                @if ($a[2] == "si")
                                <span title="MODIFICADO" style="color: #f6920f">*</span>
                                @endif
                            </a>
                            {!!Form::close()!!}
                        </td>
                        @else
                        <td title="{{$a[0]}}" style="color: #292d2e; font-weight: bold">
                            {{$a[0]}}
                        </td>
                        @endif
                        @if((($contador) % ($cant_dias+1)) == 0)
                        </tr>
                        <tr>
                        @endif
                        @php($contador +=1)
                    @endforeach
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="card-header ui-sortable-handle"  style="background: #343a40; color: #eeeeee;" >
          <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Resumen
          </h3>
        </div>
        <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list ui-sortable" data-widget="todo-list">
            @php($c = 1)
            <table>
                <tr>
                    <td>PERSONAL</td>
                    <td align="center">ASISTENCIAS</td>
                    <td align="center">TARDANZAS</td>
                    <td align="center">FALTAS</td>
                </tr>
                <tr>
            @foreach ($estadistica as $item)
                @php($est = explode(' ', $item))
                @if(count($est) >= 2)
                    @if($est[1] == 'Asistencias')
                        <td align="center"><i class="fas fa-check" style="margin-right: 10px;
                            color: #2fa861;"></i>
                                {{$est[0]}}
                        </td>
                    @elseif($est[1] == 'Tardanza')
                        <td align="center"><span style="margin-right: 5px; font-weight: bold;
                            color: #17a2b8;">T</span>
                            {{$est[0]}}
                        </td>
                    @elseif($est[1] == 'Faltas')
                        <td align="center"><i class="fas fa-times" style="margin-right: 10px;
                            color: #d81616;"></i>{{$est[0]}}</td>
                    @else
                        <td style="font-weight: bold">{{$item}}</td>
                    @endif
                @else
                    <td style="font-weight: bold">{{$item}}</td>
                @endif


                @if ($c % 4 == 0)
                </tr>
                <tr>
                @endif
                @php($c += 1)
            @endforeach

            </table>
            {{-- <li> --}}
              <!-- checkbox -->
              {{-- <div class="icheck-primary d-inline ml-2">
                @php($aux_item = explode(" ", $item))
                @if ($aux_item[1] == 'Asistencias')
                    <i class="fas fa-check" style="color: #2fa861"></i>
                @elseif($aux_item[1] == 'Tardanza')
                    <i class="fas fa-exclamation-triangle" style="color: #17a2b8;" ></i>
                @else
                    <i class="fas fa-times" style="color: #d81616;"></i>
                @endif

              </div> --}}

              {{-- <span class="text">{{$item}}</span> --}}


            {{-- </li> --}}

          </ul>
        </div>
      </div>
    </div>
</div>
@php($registrados_hoy1 = '')
@foreach ($registros_hoy as $item)
    @php ($registrados_hoy1=  $registrados_hoy1 .  $item->Nombres . '\n')
@endforeach
{{-- ----------------------- --}}
@php($registrados_hoy2 = '')
@foreach ($registros_choy as $item)
    @php ($registrados_hoy2=  $registrados_hoy2 .  $item->Nombres . '\n')
@endforeach
{{-- ---------------------- --}}
@php($registrados_hoy3 = '')
@foreach ($registros_pchoy as $item)
    @php ($registrados_hoy3=  $registrados_hoy3 .  $item->Nombres . '\n')
@endforeach
{{-- --------------------- --}}
@php($registrados_hoy4 = '')
@foreach ($registros_srhoy as $item)
    @php ($registrados_hoy4=  $registrados_hoy4 .  $item . '\n')
@endforeach
@push ('scripts')
<script src="{{asset('dist/sweetalert2/prueba.js')}}"></script>
<script>
    $('.registros').unbind().click(function () {
        Swal.fire({
            icon: 'info',
            title: 'Usuarios que marcaron su entrada hoy!',
            html: '<pre>' + '{{$registrados_hoy1}}' + '</pre>',
        })
    });
</script>
{{------------------------------------------------------ --}}
<script>
    $('.registros_c').unbind().click(function () {
        Swal.fire({
            icon: 'success',
            title: 'Usuarios que completaron su entrada - salida hoy!',
            html: '<pre>' + '{{$registrados_hoy2}}' + '</pre>',
        })
    });
</script>
{{-----------------------------------------------------------}}
<script>
    $('.registros_pc').unbind().click(function () {
        Swal.fire({
            icon: 'warning',
            title: 'Usuarios que no completaron su salida hoy!',
            html: '<pre>' + '{{$registrados_hoy3}}' + '</pre>',
        })
    });
</script>
{{-- --------------------------------- --}}
<script>
    $('.registros_sr').unbind().click(function () {
        Swal.fire({
            icon: 'error',
            title: 'Usuarios que no registraron su asistencia hoy!',
            html: '<pre>' + '{{$registrados_hoy4}}' + '</pre>',
        })
    });
</script>
{{-- Para editar --}}
<script>
    $('.edit').unbind().click(function () {
        var $button = $(this);
          var data_nombre = $button.attr('data-nombre');
          Swal.fire({
            title: 'Modificar Registro',
            showDenyButton: true,
            icon: 'warning',
            text: 'Usted realmente quiere continuar con esta acción?',
            confirmButtonText: `Continuar`,
            denyButtonText: `Cancelar`,
            customClass: 'swal-wide',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#editar_" + data_nombre).click();
            } else if (result.isDenied) {
              Swal.fire('No se realizó ninguna modificación', '', 'info')
            }
        })
    });
</script>
@endpush

@endsection
