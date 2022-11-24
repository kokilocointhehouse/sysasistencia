<?php use App\Http\Controllers\BranchOfficeController; ?>
@extends('layouts.admin')
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Listado de Sucursales</h3>
                </div>
            </div>
        </div>
    </section>

    @include('acceso.branchoffice.create')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('acceso.branchoffice.search')

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead style="background: #eaf3fa; color: #12446b">
                            <tr>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Radio</th>
                                <th>Dirección</th>
                                <th colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branchOffice as $b)
                                <tr>
                                    <td>{{ $b->name }}</td>
                                    <td><a href="//www.google.com/maps/search/{{ $b->latitude }},{{ $b->longitude }}"
                                            target="_black">{{ $b->latitude }}, {{ $b->longitude }}</a></td>
                                    <td>{{ $b->radius }}</td>
                                    <td>{{ $b->address }}</td>
                                    <td align="center">
                                        <a href="{{ route('branchoffice.edit', $b->id) }}"><i style="color: #17a2b8"
                                                class="far fa-edit"></i></a>
                                    </td>
                                    <td>
                                        @if (!BranchOfficeController::validation_destroy($b->id))
                                            <form action="{{ route('branchoffice.destroy', $b->id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default borrar text-danger btn-sm"
                                                    title="Eliminar Sucursal {{ $b->name }}"
                                                    data-nombre="{{ $b->name }}"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <input type="text" value="{{old('IdUsuario')}}"> --}}
                </div>
                {{ $branchOffice->appends(['searchText' => $searchText]) }}
            </div>
            <!-- /.card -->
        </div>
    </div>

    @push('scripts')
        @if (session()->has('success'))
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: '{{ session('success') }}',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        actionTextColor: '#27AE60',
                        duration: 6000
                    });
                });
            </script>
        @endif
        @if (session()->has('error'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
        @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    if (document.getElementById('name').value !== '') {
                        $('#modal-add').modal('show');
                    }
                });
            </script>
        @endif
        <script>
            $('.radius').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
            $('.ubicacion').on('input', function() {
                this.value = this.value.replace(/[^0-9,.,-]/g, '');
            });
        </script>
    @endpush
@endsection
