@extends('layouts.app')

@section('content')
<head>
	{{-- <title>Login V1</title> --}}
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
<!--===============================================================================================-->
</head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<body>

	</script>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-02.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login')}}">
                    {{ csrf_field() }}
					<span class="login100-form-title">
                    Prototipo de sistema de control de Asistencia con GPS
					</span>

					<div class="wrap-input100 {{ $errors->has('NumDocumento') ? 'has-error' : '' }} ">
						<input class="input100" type="text" name="NumDocumento" placeholder="Usuario" value="{{old ('NumDocumento')}}" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
							{{-- <i class="fa fa-envelope" aria-hidden="true"></i> --}}
						</span>
					</div>
                    {!! $errors->first('NumDocumento', '<span class="help-block text-danger"
                        style ="font-size: 1em">:message </span>') !!}

					<div class="wrap-input100 {{ $errors->has('password') ? 'has-error' : '' }} ">
						<input class="input100" type="password" name="password" placeholder="Contraseña" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
                    {!! $errors->first('password', '<span class="help-block text-danger"
                    style ="font-size: 1em">:message </span>') !!}
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							ENTRAR
						</button>
					</div>
                    <style>

.image-icon-whatsapp{
    position: fixed;
    bottom: 20px;
    right: 20px;
    cursor: pointer;
    transition: all 0.2s;
}

.image-icon-whatsapp:hover{
    transform: scale(0.9);
}

.image-icon-whatsapp:active{
    transform: scale(0.8);
}

.formulariowtsp{
    width: 220px;
    height: 280px;
    background:orange;
    border-radius: 5px;
    position: absolute;
    bottom: 90px;
    right: 60px;
    box-shadow: 0 2px 20px 0 rgba(0,0,0,0.22);
    background:white;
    padding: 5px 10px;
    display: none;
}

.inputwts{
    width: 100%;
    box-sizing: border-box;
    padding: 5px;
    font-family: arial;
    font-size: 13px;
    border-radius: 5px;
    border:1px solid rgba(0,0,0,0.19);
    color: #666;


}

.inputwts:focus{
    outline: none;
}

.textareawts{
    width: 100%;
    min-width: 100%;
    box-sizing: border-box;
    height: 140px;
    max-height: 140px;
    min-height: 140px;
    font-family: arial;
    font-size: 13px;
    border-radius: 5px;
    padding: 5px;
    border:1px solid rgba(0,0,0,0.19);
    color: #666;


}

.textareawts:focus{
    outline: none;
}

.newmessagewts{
    font-family: arial;
    display: block;
    text-align: center;
    width: 100%;
    box-sizing: border-box;
    line-height: 10px;
}
.btnwtsp{
    width: 100%;
    border: none;
    padding: 5px;
    background: #00a82d;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

label{
    font-family: arial;
    font-size: 14px;
    color: #333333;
}




</style>
</head>
<body>

<a href="https://api.whatsapp.com/send?phone=50372194363&text=hola%20hr" target="_blank">Tienes una pregunta al encargado de area? Consulta aqui via Whatsapp</a>

<img id="icon-whatsapp" class="image-icon-whatsapp" src="img/whatsapp.webp" alt="" width="70">


<script>
var IconWhatsapp = document.querySelector('#icon-whatsapp');
var formulariowtsp = document.getElementById('formulariowtsp');
var closemodal = document.querySelector('.closemodal');
var sendbttn = document.querySelector('#sendbttn');


IconWhatsapp.addEventListener('click' , function(){
    formulariowtsp.classList.toggle('entrarysalir')
})

closemodal.addEventListener('click' , function(){
    formulariowtsp.classList.remove('entrarysalir')
})

sendbttn.addEventListener('click' , EnviarMensaje)

function EnviarMensaje(){


    let name = document.querySelector('#inputname').value;
    let mensaje = document.querySelector('#inputmensaje').value;

    let url = "https://api.whatsapp.com/send?phone=50372194363&text=Nombre: %0A" + name + "%0A%0AMensaje: %0A" + mensaje + "%0A";
    window.open(url);

}

					{{-- <div class="text-center p-t-12">
						<span class="txt1">
							Olvidaste
						</span>
						<a class="txt2" href="#">
							Nombre de Usuario / Contraseña?
						</a>
					</div> --}}

					{{-- <div class="text-center p-t-136">
						<a class="txt2" href="#">
							Crear una cuenta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> --}}
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/tilt/tilt.jquery.min.js')}}"></script>


<!--===============================================================================================-->
	<script src="{{asset('js/main.js')}}"></script>

</body>

@endsection
