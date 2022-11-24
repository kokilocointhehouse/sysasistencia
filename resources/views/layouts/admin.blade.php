<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Asistencia</title>
    <link rel="icon" type="image/png" href="{{ asset('images/img-02.ico') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adicional.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/notification/snackbar/snackbar.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>


            <!-- SEARCH FORM -->
            {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @if (isset($alert->HoraEntrada))
                    @if (auth()->user()->TipoUsuario == 'PERSONAL' && $alert->HoraSalida == null)
                        <!-- Messages Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fas fa-exclamation-triangle" style="color: #ffe600"></i>
                                {{-- <span class="badge badge-danger navbar-badge">*</span> --}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a href="{{ asset('asistencia/registro') }}" class="dropdown-item">
                                    <!-- Message Start -->
                                    <div class="media">
                                        {{-- <i class="fas fa-sign-out-alt"></i> --}}
                                        {{-- <img src="{{asset('dist/img/user1-128x128.jpg')}}"
                alt="User Avatar" class="img-size-50 mr-3 img-circle"> --}}
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                Aún no registró su salida!
                                                <span class="float-right text-sm text-danger"><i
                                                        class="fas fa-exclamation-triangle"
                                                        style="color: #d33b3b"></i></span>
                                            </h3>
                                            <p class="text-sm">
                                            </p>
                                            <p class="text-sm text-muted"><i
                                                    class="fas fa-sign-out-alt"></i></i>Registrar Salida</p>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                </a>
                            </div>
                        </li>
                    @endif
                @endif
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ auth()->user()->Nombres }}</span>
                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i></button>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-maroon-info elevation-4">

            <!-- Brand Logo -->
            @if (auth()->user()->TipoUsuario == 'PERSONAL')
                <a href="{{ asset('asistencia/registro') }}" class="brand-link">
                @else
                    <a href="{{ asset('dashboard-administrador') }}" class="brand-link">
            @endif
            {{-- <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
            <span class="brand-text font-weight-light">Sistema de Asistencia</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->user()->foto != '')
                            <img src="{{ asset('Imagen/' . auth()->user()->foto) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        @php($m = explode(' ', auth()->user()->Nombres))
                        @if (count($m) > 2)
                            <a href="#" class="d-block">{{ $m[0] . ' ' . $m[1] }}</a>
                        @else
                            <a href="#" class="d-block">{{ auth()->user()->Nombres }}</a>
                        @endif
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @if (auth()->user()->TipoUsuario == 'ADMINISTRADOR')
                            <li class="nav-item">
                                <a href="{{ asset('dashboard-administrador') }}"
                                    class="nav-link
            {{ 'dashboard-administrador' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Panel de Control
                                        {{-- <span class="right badge badge-danger">New</span> --}}
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#"
                                    class="nav-link {{ 'asistencia' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Asistencia
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('asistencia/informe_global') }}"
                                            class="nav-link {{ 'informe_global' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Informe General</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('asistencia/reporte_mensual') }}"
                                            class="nav-link {{ 'reporte_mensual' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reporte Mensual</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link {{ 'caja' == request()->segment(1) ? 'active' : '' }}">
                                    <i class=" nav-icon fas fa-cash-register"></i>
                                    <p>
                                        Caja
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('caja/pago') }}"
                                            class="nav-link {{ 'pago' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pagos</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link {{ 'acceso' == request()->segment(1) ? 'active' : '' }}">
                                    <i class=" nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Acceso
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('acceso/usuarios') }}"
                                            class="nav-link {{ 'usuarios' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('acceso/branchoffice') }}"
                                            class="nav-link {{ 'branchoffice' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Sucursal</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#"
                                    class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>
                                        Configuración
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/mi_perfil') }}"
                                            class="nav-link {{ 'mi_perfil' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mi perfil</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/empresa') }}"
                                            class="nav-link {{ 'empresa' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ajustes</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @elseif (auth()->user()->TipoUsuario == 'PERSONAL')
                            <li class="nav-item menu-open">
                                <a href="#"
                                    class="nav-link {{ 'asistencia' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="fas fa-user-cog"></i>
                                    <p>
                                        Asistencia
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('asistencia/registro') }}"
                                            class="nav-link {{ 'registro' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Registro</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('asistencia/informe') }}"
                                            class="nav-link {{ 'informe' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Informe</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link {{ 'reporte' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="fas fa-user-cog"></i>
                                    <p>
                                        Reporte
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/mensual') }}"
                                            class="nav-link {{ 'mensual' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reporte Mensual</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/grafico') }}"
                                            class="nav-link {{ 'grafico' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Reporte Gráfico</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('reporte/mis_pagos') }}"
                                            class="nav-link {{ 'mis_pagos' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mis Pagos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item menu-open">
                                <a href="#"
                                    class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="fas fa-user-cog"></i>
                                    <p>
                                        Configuración
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/mi_perfil') }}"
                                            class="nav-link {{ 'mi_perfil' == request()->segment(2) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mi perfil</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif (auth()->user()->TipoUsuario == 'SUPER_ADMIN')
                        <li class="nav-item">
                            <a href="{{ asset('dashboard-super-administrador') }}"
                                class="nav-link {{'dashboard-super-administrador' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Panel de Control
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-open">
                            <a href="#"
                                class="nav-link {{ 'acceso' == request()->segment(1) ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-user-cog"></i>
                                <p>
                                    Acceso
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('acceso/usuario2') }}"
                                        class="nav-link {{ 'usuario2' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Administrador</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ asset('acceso/super-administrador') }}"
                                        class="nav-link {{ 'super-administrador' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Super Administrador</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-open">
                            <a href="#"
                                class="nav-link {{ 'control' == request()->segment(1) ? 'active' : '' }}">
                                <i class=" nav-icon fas fa-user-cog"></i>
                                <p>
                                    Control
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('control/empresas') }}"
                                        class="nav-link {{ 'empresas' == request()->segment(2) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Empresa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div> --}}
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield ('contenido')
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
               JJ SISTEMAS
            </div>
            <!-- Default to the left -->

        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    @stack('scripts')
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    {{-- Eliminar --}}
    <script src="{{ asset('dist/sweetalert2/eliminar.js') }}"></script>



</body>

</html>
