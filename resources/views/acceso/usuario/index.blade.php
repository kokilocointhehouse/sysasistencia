<?php use App\Http\Controllers\UsuarioController; ?>
@extends('layouts.admin')
@section ('contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Listado de Usuarios</h3>
            </div>
        </div>
    </div>
</section>

@include('acceso.usuario.create')
<div class="row">
    <div class="col-12">
        <div class="card">
            @include('acceso.usuario.search')

            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead style="background: #eaf3fa; color: #12446b">
                        <tr>
                            <th>N° Documento</th>
                            <th>Usuario</th>
                            <th>N° Celular</th>
                            <th>Sucursal</th>
                            <th>Tipo</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center" colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuario as $u)
                        @php($business_name = $u->TipoUsuario == 'ADMINISTRADOR' ? '' : $u->namebranch_office)
                        <tr>
                            <td>{{ $u->NumDocumento}}</td>
                            <td>{{ $u->Nombres}}</td>
                            <td>{{ $u->TelefCel}}</td>
                            <td>{{ $business_name }}</td>
                            <td>{{ $u->TipoUsuario}}</td>
                            <td align="center">
                                @if ($u->IdUsuario != auth()->user()->IdUsuario)
                                    @if ($u->Estado == "ACTIVO")
                                    <button class="btn apertura" title="Cambiar de estado a {{ $u->Nombres }}" data-nombre="{{ $u->IdUsuario }}">
                                        <span class="badge badge-success">{{ $u->Estado}}</span>
                                    @else
                                        <button class="btn apertura" title="Cambiar de estado a {{ $u->Nombres }}" data-nombre="{{ $u->IdUsuario }}">
                                        <span class="badge badge-danger">{{ $u->Estado}}</span>
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ route('usuarios.edit', $u->IdUsuario) }}" class="btn btn-sm btn-default">
                                    <i style="color: #17a2b8" class="far fa-edit"></i></a>
                            </td>
                            <td>
                                @if ($u->IdUsuario != auth()->user()->IdUsuario && UsuarioController::validation_destroy($u->IdUsuario))
                                    <form action="{{route('usuarios.destroy', $u->IdUsuario) }}"
                                        method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-default borrar text-danger btn-sm"
                                            title="Eliminar Empresa {{ $u->Nombres }}"
                                            data-nombre="{{ $u->Nombres }}"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        {{-- @include('acceso.usuario.edit') --}}
                        @endforeach
                    </tbody>
                </table>
                {{-- <input type="text" value="{{old('IdUsuario')}}"> --}}
            </div>
            {{$usuario->appends(['searchText' => $searchText])}}
        </div>
        <!-- /.card -->
    </div>
</div>
<script>
    if(document.getElementById('TipoUsuario').value === 'PERSONAL' ){
        document.getElementById('displaySucursal').style.display = 'block';
        document.getElementById('displayPagoHora').style.display = 'block';
    }else{
        document.getElementById('displaySucursal').style.display = 'none';
        document.getElementById('displayPagoHora').style.display = 'none';
        document.getElementById('pagoHora').value = 0;
    }

    const selectElement = document.querySelector('.tipo');
    selectElement.addEventListener('change', (event) => {
        if(event.target.value.toString() === 'ADMINISTRADOR'){
            document.getElementById('displaySucursal').style.display = 'none';
            document.getElementById('displayPagoHora').style.display = 'none';
            document.getElementById('pagoHora').value = 0;


        }else{
            document.getElementById('displaySucursal').style.display = 'block';
            document.getElementById('displayPagoHora').style.display = 'block';

        }

    });
</script>
<script>
    document.getElementById("Imagen").onchange = function(e) {
        // Creamos el objeto de la clase FileReader
        let reader = new FileReader();
        // Leemos el archivo subido y se lo pasamos a nuestro fileReader
        reader.readAsDataURL(e.target.files[0]);

        // Le decimos que cuando este listo ejecute el código interno
        reader.onload = function() {
            let preview = document.getElementById('img'),
                image = document.createElement('img');
            image.src = reader.result;
            preview.innerHTML = '';
            preview.append(image);
        };
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
<script>
     $('.NumDocumento').on('input', function () {
        this.value = this.value.replace(/[^0-9,-]/g, '').replace(/,/g, '.');
    });
    $('#pagoHora').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });

    $('.apertura').unbind().click(function() {
        var $button = $(this);
        var data_nombre = $button.attr('data-nombre');
        Swal.fire({
            title: '¿Desea cambiar el estado del Usuario?',
            showDenyButton: true,
            confirmButtonText: `Cambiar`,
            denyButtonText: `Cancelar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                var d = '{{URL::action("UsuarioController@show", 0)}}' + data_nombre
                window.location.href = d;
            }
        })
        return false;
    });
</script>

@if (count($errors) > 0)
    <script type="text/javascript">
        $(document).ready(function(){
        <?php if (old('IdUsuario') == '') {?>
            $('#modal-add').modal('show');
        <?php } else { ?>
            $('#modal-add-<?php echo old("IdUsuario") ?>').modal('show');
        <?php }?>
        });
    </script>
@endif

@endpush
@endsection
