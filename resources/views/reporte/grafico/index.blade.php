@extends ('layouts.admin')
@section ('contenido')
<style>
    table {
        width: 100%;
    }
    table td {
        padding: 8px;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Reporte Gráfico</h3>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="card">
            @include('reporte.grafico.search')
            <div class="card-body table-responsive p-0">
            <table class="text-nowrap">

                <tr style="background: #343a40; color: #eeeeee;">
                {{-- <td>PERSONAL</td> --}}
                @php($cont = 1)
                @foreach ($dias_mes_l as $dl)
                    @if ($dl == 'DO' && $dia_ac != $cont)
                    <td style="background: #5d6268">{{$dl}}</td>
                    @elseif($dia_ac == $cont && (date('Y') == $anio_o || $anio_o == ''))
                    <td style="background: #17a2b8">{{$dl}}</td>
                    @else
                    <td>{{$dl}}</td>
                    @endif
                    @php($cont += 1)
                @endforeach
                </tr>
                <tr>
                @foreach ($dias_mes_n as $dn)
                    <td>{{$dn}}</td>
                @endforeach
                </tr>
                <tr>
                    @php($contador = 1)
                    @foreach($asistencia as $a)
                        @if($a == '*')
                        <td title="ASISTENCIA" style="color: #2fa861; text-align: center; font-weight: bold">
                            <i class="fas fa-check"></i></td>
                        @elseif($a == 'F')
                        <td title="FALTA" style="color: #d81616; text-align: center; font-weight: bold">
                            <i class="fas fa-times"></i>
                        </td>
                        @else
                        <td title="TARDE" style="color: #17a2b8; text-align: center; font-weight: bold">
                            <i class="fas fa-exclamation-triangle"></i>
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
        <div class="card-header ui-sortable-handle" >
          <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Resumen
          </h3>
        </div>
        <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list ui-sortable" data-widget="todo-list">
            @foreach ($estadistica as $item)
            <li>
              <!-- checkbox -->
              <div class="icheck-primary d-inline ml-2">
                @php($aux_item = explode(" ", $item))
                @if ($aux_item[1] == 'Asistencias')
                    <i class="fas fa-check" style="color: #2fa861"></i>
                @elseif($aux_item[1] == 'Tardanza')
                    <i class="fas fa-exclamation-triangle" style="color: #17a2b8;" ></i>
                @else
                    <i class="fas fa-times" style="color: #d81616;"></i>
                @endif

              </div>

              <span class="text">{{$item}}</span>


            </li>
            @endforeach

          </ul>
        </div>
      </div>
    </div>
</div>

@endsection
