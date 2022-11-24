<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SISASISTENCIA</title>
    <link rel="shortcut icon" type="image/ico" href="/img/yandrec-logo.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="icon" type="image/png" href="{{asset('images/img-02.ico')}}"/>
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">
</head>
<body>
    <div class="container" >
        @if (session()->has('flash'))
            <div class="alert alert-info">{{ session('flash')}}</div>
        @endif
        @yield('content')
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
