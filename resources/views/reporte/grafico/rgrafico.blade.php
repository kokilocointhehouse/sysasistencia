<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 0.71em;
        }
        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
            width: 100%;
        }
        td {
        padding: 3px;
        border: 1px solid #000;
        }
        /* table td {
            padding: 8px;
        } */
    </style>
</head>
<body>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Reporte Gráfico: {{$mes_ac}} - {{$anio_o}} </h3>
                    <p>{{$usuario}}</p>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">
                <div class="card-body table-responsive p-0">
                <table class="text-nowrap">

                    <tr style="background: #343a40; color: #eeeeee;">
                    {{-- <td>PERSONAL</td> --}}
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
                    @foreach ($dias_mes_n as $dn)
                        <td style="text-align: center">{{$dn}}</td>
                    @endforeach
                    </tr>
                    <tr>
                        @php($contador = 1)
                        @foreach($asistencia as $a)
                            @if($a == '*')
                            <td title="ASISTENCIA" style="color: #2fa861; text-align: center; font-weight: bold">
                                A</td>
                            @elseif($a == 'F')
                            <td title="FALTA" style="color: #d81616; text-align: center; font-weight: bold">
                                F
                            </td>
                            @else
                            <td title="TARDE" style="color: #17a2b8; text-align: center; font-weight: bold">
                                T
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
                        <span style="color: #1f7c46">{{$item}} Correctas</span>
                    @elseif($aux_item[1] == 'Tardanza')
                        <span  style="color: #17a2b8;" >
                        {{$item}}</span>
                    @else
                        <span style="color: #d81616;">{{$item}}</span>
                    @endif

                  </div>

                </li>
                @endforeach

              </ul>
            </div>
          </div>
        </div>
    </div>
</body>
</html>


